<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Attendant;
use Carbon\Carbon;
use App\Test;
use App\Choice;
use App\Question;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');    
        
    }
    
    
    public function index(Request $request) 
    {
       $SQL = sprintf("SELECT * FROM CBT_attendants att "
                    . "JOIN CBT_tests ts ON att.tid = ts.tid "
                    . "JOIN CBT_test_types tty ON ts.ttypid = tty.ttypid "
                    . "JOIN CBT_assessments ass ON ts.assid = ass.assid "
                    . "JOIN CBT_courses cs ON ass.csid = cs.csid "
                    . "JOIN CBT_sessions ses ON ass.sesid = ses.sesid "
                    . "WHERE att.userid = ? AND ts.status = 'active' "
                    . "AND ass.status = 'active' AND ses.status = 'active'"
               ) ;
        $active_tests = DB::select($SQL, [Auth::user()->userid]);
        
        $data['active_tests'] = json_encode($active_tests);
        return view('student.index', $data);
    }

    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function instruction(Request $request)
    {
        
        if ($request->isMethod('post'))
        {  
            $request->session()->put('tid', $request->test);
            
            $SQL = sprintf("SELECT * FROM CBT_tests ts "
                        . "JOIN CBT_test_types tty ON ts.ttypid = tty.ttypid "
                        . "JOIN CBT_assessments ass ON ts.assid = ass.assid "
                        . "JOIN CBT_courses cs ON ass.csid = cs.csid "
                        . "JOIN CBT_sessions ses ON ass.sesid = ses.sesid "
                        . "WHERE ts.tid = ? LIMIT 0,1") ;
            $my_test = DB::select($SQL, [$request->test])[0];
            
            $data = array(
                'my_test' => $my_test
            );
            
            return view('student.test_terms', $data);
        }
        else
        {
            return redirect('/student')->with([
                        'flash_message' => 'Invalid Request method',
                        'status' => 'error'
            ]);
        }
        
    }
    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function answer_sheet(Request $request)
    { 
        $data['test_id'] = $request->session()->get('tid');
        
        //Ensure that the HTTP request is either POST or GET
        if ($request->isMethod('post') || $request->isMethod('get') )
        {
            
            //get Attendant with Test details
            $atnd = Attendant::with('test')
                            ->where('tid', $request->session()->get('tid'))
                            ->where('userid', Auth::user()->userid)
                            ->first();
            
            if(!in_array($atnd->response_status, ['standby', 'active'])){
                return redirect('/student')->with([
                                    'flash_message' => 'You have perticipated in this Test',
                                    'status' => 'error'
                        ]);
            }
           
            //Attreibute to be 
            //updated in Attendant
            $upd_data = array();
            
            //set IP in if it is not Set
            if($atnd->ip_in == NULL){
                $upd_data['ip_in'] = $request->server('REMOTE_ADDR');
            }
            
            //set user Agent if it is not Set
            if($atnd->user_agent == NULL){
                $upd_data['user_agent'] = $request->server('HTTP_USER_AGENT');
            }
            
            //set start Time if it is not Set
            if($atnd->start_time == NULL){
                $upd_data['start_time']  = Carbon::now()->toDateTimeString();
            }
            
            
            //set response_status if it is not Set
            if($atnd->response_status != 'active'){
                $upd_data['response_status'] = 'active';
            }
            
            //if attribute is not empty
            //then update attendant
            if(!empty($upd_data)){
                Attendant::where('tid', $request->session()->get('tid'))
                        ->where('userid', Auth::user()->userid)
                        ->update($upd_data);
            }
            
            //Check image capture status of the test 
            //property return true if captured or not enable for the test
            $captured = $this->image_capture($request->session()->get('tid'));
            
            if($captured)
            {
                //Fetch question for user if user has no question yet
                $status = $this->populate_user_choice($atnd);
                
                $user_choice = array();
                
                $user_choice = $this->get_user_choice($atnd->attndid);
                    
                $alloted = $this->timeLeft($atnd->test->time, $atnd->used_time);
                
                //Check if user still has more time to use else redirect to home page
                if($alloted == "00:00:00"){
                    return redirect('/student')->with([
                                'flash_message' => 'You have exhusted your alloted time for this assessment',
                                'status' => 'error'
                        ]);
                }
                session()->put('test_image', $atnd->image_capture);
                $data['my_questions'] = $user_choice;
                $data['attendant'] = $atnd;
                $data['alloted'] = $alloted;
                    
                return view('student.answer_sheet', $data);
            }
            else
            {
                if($request->snaped_img !== null){
                    
                    if($this->save_captured($request, $atnd->attndid)){
                        
                        return redirect('/student/sheet')->with([
                            'flash_message' => 'Selfie Caputured and Save Successfully',
                            'status' => 'success'
                        ]);
                    }
                } 
                return view('student.image_capture', $data); 
            }
            
        }
        else
        {
            return redirect('/student')->with([
                        'flash_message' => 'Invalid Request method',
                        'status' => 'error'
            ]);
        }
       
    }
    
    
    
    
    
    private function get_active_test($assid)
    {
        $SQL = sprintf("SELECT ts.*, s.sesname, cs.csname 
                        FROM CBT_assessments ass 
                        JOIN CBT_courses cs ON ass.csid = cs.csid 
                        JOIN CBT_tests ts ON ass.assid = ts.assid 
                        JOIN CBT_sessions s ON ass.sesid = s.sesid 
                        AND s.status = 'active'
                        JOIN CBT_attendants att ON ts.tid = att.tid
                        WHERE att.userid = ? 
                        AND ts.status = 'active' AND ass.assid = ? ");
        return $active_test = DB::select($SQL, [Auth::user()->userid, $assid]);
    }
    
    
    /**
     * Fetch and load question fro user 
     * Check is question is loaded 
     */
    
    private function populate_user_choice(Attendant $attendant)
    {
        $status = FALSE;
        
        $user_choice = $this->get_user_choice($attendant->attndid);
        
        
        $noq = (int)$attendant->test->noq;
        $tcq = (int)$user_choice->count();
        
        if($noq > $tcq)
        {
            $qtf = $noq - $tcq;
            
            if($attendant->test->rand_question == 'true'){
               $questions = $this->fetch_random_question($attendant->test->tid, $qtf); 
            }
            else{
                $questions = $this->fetch_question($attendant->test->tid, $qtf);
            }
            
            if($questions->count() == $noq){
                
                foreach ($questions as $question){
                    $insert = array(
                        'qid' => $question->qid,
                        'attndid' => $attendant->attndid
                    );
                    Choice::create($insert);  
                }
                $status = TRUE;
                
            }else{
                return redirect('/student')->with([
                                'flash_message' => 'Oops. Insufficient Questions. Contact Administrator ',
                                'status' => 'error'
                        ]);
            }
        }
        
        return $status;
        
    }
    
    
    /**
     * Get userChoice JOIN question 
     * for a particular attendee
     * 
     * @param type String $att 
     * @return type
     */
    private function get_user_choice($att)
    {
        return Choice::with('question')
                ->where('attndid', $att)
                ->get();
    }
    
    
    
    /**
     * Fetch random question for a test 
     * @param String $test_id testID of the question to fetch
     * @param int $size number of random question 
     * @return type
     */
    private function fetch_random_question($test_id, $size)
    {  
        return Question::where('tid', $test_id)
                        ->where('status', 'active')
                        ->inRandomOrder()
                        ->limit($size)
                        ->get();
    }
    
    
    /**
     * Fetch  question for a test 
     * @param String $test_id testID of the question to fetch
     * @param int $size number of random question 
     * @return type
     */
    private function fetch_question($test_id, $size)
    {   
        return Question::where('tid', $test_id)
                ->where('status', 'active')
                ->limit($size)
                ->get();
    }
    
    
    /**
     * 
     * @param type $testid
     * @return boolean
     */
    private function image_capture($testid)
    {
        $data = array();
        $status = TRUE;
        if($testid)
        {
            $test_ppt = Attendant::with('test')
                        ->where('tid', $testid)
                        ->where('userid', Auth::user()->userid)
                        ->first();
            
            if($test_ppt->test->image_capture == 'true')
            {
                if($test_ppt->image_capture == null)
                {
                    $status = FALSE; 
                }
                else{
                    session()->put('test_image', $test_ppt->image_capture);
                    
                }
                
            }
             
        }else{
            return redirect('/student')->with([
                        'flash_message' => "Ops. Something went wrong test ID is missing  ",
                        'status' => 'error'
            ]);
        }
        
        return $status;
    }
    
    
    /**
     * 
     * @param type $request
     * @param type $attndnt
     * @return boolean
     */
    private function save_captured($request, $attndnt)
    {
        $upload_dir = "captured_test_image/{$request->test_id}";
        $img = str_replace('data:image/jpeg;base64,', '', $request->snaped_img);
        $img = str_replace(' ', '+', $img);
        $f_img = base64_decode($img);

        $file = $upload_dir .'/'.$attndnt .'.jpg';
        

        if(!file_exists(public_path().'/'.$upload_dir) || !is_dir(public_path().'/'.$upload_dir) ) {
            File::makeDirectory(public_path().'/'.$upload_dir,0777,true);
            file_put_contents(public_path().'/'.$file, $f_img);
            
            Attendant::where('tid', $request->session()->get('tid'))
                        ->where('userid', Auth::user()->userid)
                        ->update(['image_capture' => $file]);
                
        } else{
            
            file_put_contents(public_path().'/'.$file, $f_img);
            Attendant::where('tid', $request->session()->get('tid'))
                        ->where('userid', Auth::user()->userid)
                        ->update(['image_capture' => $file]);
        }

        return TRUE;
    }
    
    
    /**
     * 
     * @param String $alloc
     * @param String $used
     */
    private function timeLeft($alloc, $used)
    {
        $allocated = explode(':', $alloc);
        $used_time = explode(':', $used);
        
        $dt1 = Carbon::parse($alloc);
        
        $dt1->subHour($used_time[0]);
        $dt1->subMinute($used_time[1]);
        $dt1->subSecond($used_time[2]);
        
        return $dt1->toTimeString();
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function save_choice(Request $request)
    {
        return $response = Choice::where('attndid', $request->attndid)
                    ->where('qid', $request->qid)
                    ->update(['choice' => $request->choice, 'status' => 'true']);
    }
    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function save_error(Request $request)
    {
        
        if(!empty($request->er_dt)){
            foreach($request->er_dt as $dt){
                $response = Choice::where('attndid', $dt['attndid'])
                         ->where('qid', $dt['qid'])
                         ->update(['choice' => $dt['choice'], 'status' => 'true']);
                 var_dump($response);
             }
        } 
        
    }
    
    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function save_time(Request $request )
    {
        $left = $this->timeLeft($request->alloted, $request->time);
        return $response = Attendant::where('attndid', $request->atnd)
                            ->update(['used_time'=> $left]);
    }
    
    
    /**
     * 
     * @param Request $request
     */
    public function end_exam(Request $request)
    {
        
        $pass = 0;
        $fail = 0;
        $answered = 0;
        $unanswered = 0;
        
        $test_ppt = $this->get_test($request->tid);
        
        $my_answered = $this->my_answered($request->attndid);
        
        return  Attendant::where('attndid', $request->attndid)
                        ->update(['response_status' => 'end_test']);   
        
    }
    
    
    /**
     * 
     * @param type $tid
     * @return type
     */
    private function get_test($tid)
    {
        return Test::where('tid', $tid)->first();    
    }
    
    
    /**
     * 
     * @param type $obtainable_score
     * @param type $total_question
     * @param type $score
     * @param type $minus_mark
     * @return type
     */
    private function calculate_score($obtainable_score, $total_question,  $score, $minus_mark = false)
    {
        $myScore =  ($obtainable_score * $score) / $total_question;
        
        if($minus_mark){
           $myScore = $myScore -  $minus_mark;
        }
        
        return $myScore;
    }
    
    
    /**
     * 
     * @param Request $request
     */
    public function get_my_answered(Request $request)
    {
        echo  json_encode($this->my_answered($request->attndid));
    }
    
    
    
    /**
     * 
     * @param type $attndid
     * @return boolean
     */
    private function my_answered($attndid)
    {
        $pass = 0;
        $fail = 0;
        $answered = 0;
        $unanswered = 0;
        
        $choices = DB::table('choices')
                ->join('questions', 'choices.qid', '=', 'questions.qid')
                ->where('choices.attndid', $attndid)
                ->get(['choices.*', 'questions.choice AS answer']);

        
        if(!empty($choices))
        {
            foreach ($choices AS $choice)
            {
                if ($choice->choice != NULL)
                {
                    $answered = $answered + 1;

                    if ($choice->choice === $choice->answer)
                    {
                        $pass = $pass + 1;
                    }
                    else
                    {
                        $fail = $fail + 1;
                    }
                } 
                else
                {
                    $unanswered = $unanswered + 1;
                }
            }
            return array(
                            'pass' => $pass,
                            'fail' => $fail,
                            'unanswered' => $unanswered
                        );
        }
        else
        {
            return FALSE;
        }
        
    }
}
