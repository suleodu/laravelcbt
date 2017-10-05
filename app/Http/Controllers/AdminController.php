<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Session;
use App\User;
use App\Course;
use App\Assessment;
use App\Test;
use App\Testtype;
use App\Attendant;
use App\Exam_centers;
use App\Batch;
use App\Question;

//Adedayo

/**
 * @name Admin
 * @author sdsjkdlf
 */
class AdminController extends Controller {

    /**
     * @name Admin index Page 
     * @return type View
     */
    public function index() {

        return view('admin.index');
    }

    /*
      |--------------------------------------------------------------------------
      | Start Session management
      |--------------------------------------------------------------------------
     */

    
    public function sessions() {
        $sessions = Session::all();
        $active_ses = Session::where('status', 'active')->first();
        $data['activeses'] = $active_ses;
        $data['sessions'] = $sessions;
        return view('admin.sessions', $data);
        
        
    }

    /**
     * jfgskjdfglksdjglkjsdlkgjsldk
     * @param Request $request
     * @return Vew
     */
    public function create_session(Request $request) {

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'sesname' => 'required|max:9',
                'passmark' => 'required|integer',
                'status' => 'required'
            ]);

            //set active then deactvate any actve session 
            if ($request->status == 'active') {
                Session::where('status', 'active')->update(['status' => 'inactive']);
                $ses_data = array(
                    'sesname' => $request->sesname,
                    'passmark' => $request->passmark,
                    'status' => $request->status
                );
                $session = Session::create($ses_data);
                return redirect('/admin/sessions')->with([
                            'flash_message' => 'Session Created and set active Successfuly ',
                            'status' => 'success'
                ]);
            } else {
                $ses_data = array(
                    'sesname' => $request->sesname,
                    'passmark' => $request->passmark,
                    'status' => $request->status
                );
                $session = Session::create($ses_data);
                return redirect('/admin/sessions')->with([
                            'flash_message' => 'Session Created and set inactive Successfuly',
                            'status' => 'success'
                ]);
            }
        } else {
            return redirect('/admin/sessions')->with([
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
    public function update_session(Request $request) {
        $this->validate($request, [
            'sesname' => 'required|max:9',
            'passmark' => 'required|integer',
            'status' => 'required'
        ]);

        if ($request->isMethod('post')) {


            if ($request->status == 'active') {

                Session::where('status', 'active')->update(['status' => 'inactive']);
                $ses_data = array(
                    'sesname' => $request->sesname,
                    'passmark' => $request->passmark,
                    'status' => $request->status
                );

                Session::where('sesid', $request->edit_id)
                        ->update([
                            'sesname' => $request->sesname,
                            'passmark' => $request->passmark,
                            'status' => $request->status]
                );
                return redirect('/admin/sessions')->with([
                            'flash_message' => 'Sesson updated successfully',
                            'status' => 'success'
                ]);
            } else {

                Session::where('sesid', $request->edit_id)
                        ->update([
                            'sesname' => $request->sesname,
                            'passmark' => $request->passmark,
                            'status' => $request->status]
                );
                return redirect('/admin/sessions')->with([
                            'flash_message' => 'Sesson updated successfully',
                            'status' => 'success'
                ]);
            }
        } else {
            return redirect('/admin/sessions')->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    
    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function delete_session(Request $request) {
        if ($request->isMethod('post')) {
            $session = Session::destroy($request->edit_id);
            return redirect('/admin/sessions')->with([
                        'flash_message' => 'Session and other connected record deleted successfully',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/sessions')->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    /*
      | --------------------------------------------------------------------------
      | End Session management
      | --------------------------------------------------------------------------
     */




    /*
      | --------------------------------------------------------------------------
      | Start User  management
      | --------------------------------------------------------------------------
     */

    
    /**
     * 
     * @return type
     */
    public function users() {
       
        $users = User::where('access', 'student')->orderBy('userid', 'asc')->get();
        $data['users'] = $users;
        return view('admin.users', $data);
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function create_user(Request $request) {
        //ensure that form request method is a POST method
        if ($request->isMethod('post')) {
            //Set the form validation rules
            $rule = array();
            $rule['userid'] = 'required|unique:users,userid';
            $rule['fname'] = 'required';
            $rule['lname'] = 'required';
            $rule['password'] = 'required';

            if ($request->mname != '') {
                $rule['mname'] = 'required';
            }

            if ($request->email != '') {
                $rule['email'] = 'required|email';
            }
            $this->validate($request, $rule);

            $user_data = array(
                'userid' => strtoupper($request->userid),
                'fname' => strtoupper($request->fname),
                'lname' => strtoupper($request->lname),
                'mname' => strtoupper($request->mname),
                'email' => strtoupper($request->email),
                'access' => 'student',
                'password' => bcrypt($request->password),
                'status' => $request->status
            );
            User::create($user_data);
            return redirect('/admin/users')->with([
                        'flash_message' => 'User Created and set active Successfuly ',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/users')->with([
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
    public function update_user(Request $request) {
        //ensure that form request method is a POST method
        if ($request->isMethod('post')) {
            //Set the form validation rules
            $rule = array();
            $rule['userid'] = 'required';
            $rule['fname'] = 'required';
            $rule['lname'] = 'required';

            if ($request->mname != '') {
                $rule['mname'] = 'required';
            }

            if ($request->password != '') {
                $rule['password'] = 'required';
            }

            if ($request->email != '') {
                $rule['email'] = 'required|email';
            }
            $this->validate($request, $rule);

            $user_data = array(
                'userid' => strtoupper($request->userid),
                'fname' => strtoupper($request->fname),
                'lname' => strtoupper($request->lname),
                'mname' => strtoupper($request->mname),
                'email' => strtoupper($request->email),
                'access' => 'student',
                'status' => $request->status
            );
            if ($request->password != '') {

                $user_data['password'] = bcrypt($request->password);
            }

            User::where('userid', $request->edit_id)->update($user_data);
            return redirect('/admin/users')->with([
                        'flash_message' => 'User Updated Successfuly ',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/users')->with([
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
    public function delete_user(Request $request) {

        if ($request->isMethod('post')) {
            $session = User::destroy($request->edit_id);
            return redirect('/admin/users')->with([
                        'flash_message' => 'user and other connected record deleted successfully',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/users')->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function upload_user(Request $request) {
        if ($request->isMethod('post')) {
            if ($request->hasFile('csvfile')) {

                $path = $request->file('csvfile')->getRealPath();
                if ($handle = fopen($path, "r")) {
                    while (($data = fgetcsv($handle, 1500, ",")) !== FALSE) {
                        $us = array(
                            'userid' => $data[0],
                            'fname' => strtoupper($data[1]),
                            'mname' => strtoupper($data[2]),
                            'lname' => strtoupper($data[3]),
                            'password' => bcrypt(strtolower($data[3])),
                            'status' => 'active'
                        );

                        try {
                            User::firstOrCreate($us);
                        } catch (\Illuminate\Database\QueryException $exc) {
                            echo $exc->getTraceAsString();
                        }
                    }

                    return redirect('/admin/users')->with([
                                'flash_message' => 'User Uploaded Successfully',
                                'status' => 'error'
                    ]);
                } else {
                    return redirect('/admin/users')->with([
                                'flash_message' => 'Unable to open the CSV file',
                                'status' => 'error'
                    ]);
                }
            }
        } else {
            return redirect('/admin/users')->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    /*
      |--------------------------------------------------------------------------
      | End of Users Management
      |--------------------------------------------------------------------------
     */




    /*
      |--------------------------------------------------------------------------
      | Start Courses Management
      |--------------------------------------------------------------------------
     */

    public function courses() {
        $courses = Course::all();
        $data['courses'] = $courses;
        //dd($courses);
        return view('admin.courses', $data);
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function create_course(Request $request) {
        //ensure that form request method is a POST method
        if ($request->isMethod('post')) {
            //Set the form validation rules
            $rule = array();
            $rule['csid'] = 'required|unique:courses,csid';
            $rule['csname'] = 'required';
            $rule['status'] = 'required';

            $this->validate($request, $rule);

            $course_data = array(
                'csid' => strtoupper($request->csid),
                'csname' => strtoupper($request->csname),
                'status' => $request->status
            );
            Course::create($course_data);
            return redirect('/admin/courses')->with([
                        'flash_message' => 'Course Created and set active Successfuly ',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/courses')->with([
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
    public function update_course(Request $request) {
        //ensure that form request method is a POST method
        if ($request->isMethod('post')) {
            //Set the form validation rules
            $rule = array();
            $rule['csid'] = 'required';
            $rule['csname'] = 'required';
            $rule['status'] = 'required';

            $this->validate($request, $rule);

            $course_data = array(
                'csid' => strtoupper($request->csid),
                'csname' => strtoupper($request->csname),
                'status' => $request->status
            );

            Course::where('csid', $request->edit_id)->update($course_data);
            return redirect('/admin/courses')->with([
                        'flash_message' => 'Courses Updated Successfuly ',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/courses')->with([
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
    public function delete_course(Request $request) {

        if ($request->isMethod('post')) {
            Course::destroy($request->edit_id);
            return redirect('/admin/courses')->with([
                        'flash_message' => 'Course and other connected record deleted successfully',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/courses')->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function upload_course(Request $request) {
        if ($request->isMethod('post')) {
            if ($request->hasFile('csvfile')) {

                $course = array();
                $path = $request->file('csvfile')->getRealPath();
                if ($handle = fopen($path, "r")) {
                    while (($data = fgetcsv($handle, 1500, ",")) !== FALSE) {
                        $cs = array(
                            'csid' => strtoupper($data[0]),
                            'csname' => strtoupper($data[1]),
                            'status' => 'active'
                        );

                        try {
                            Course::firstOrCreate($cs);
                        } catch (\Illuminate\Database\QueryException $exc) {
                            echo $exc->getTraceAsString();
                        }
                    }

                    return redirect('/admin/courses')->with([
                                'flash_message' => 'Course Uploaded Successfully',
                                'status' => 'error'
                    ]);
                } else {
                    return redirect('/admin/courses')->with([
                                'flash_message' => 'Unable to open the CSV file',
                                'status' => 'error'
                    ]);
                }
            }
        } else {
            return redirect('/admin/courses')->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    /*
      | --------------------------------------------------------------------------
      | Start Assessment  management
      | --------------------------------------------------------------------------
     */

    public function assessments() {
        $active_ses = Session::where('status', 'active')->first();
        $assessments = Assessment::with(['session', 'course'])->where('sesid', $active_ses->sesid)->get();
        $courses = Course::where('status', 'active')->get();

        $data['active_session'] = $active_ses;
        $data['assessments'] = json_encode($assessments);
        $data['courses'] = $courses;
        return view('admin.assessments', $data);
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function create_assessment(Request $request) {
        if ($request->isMethod('post')) {

            $rule = array();
            $rule['csid'] = 'required';
            $rule['ca_score'] = 'required';
            $rule['ex_score'] = 'required';
            $rule['sesid'] = 'required';
            $rule['status'] = 'required';

            $this->validate($request, $rule);

            $p_key = $request->csid . '_' . $request->sesid;

            $assessments_data = array(
                'assid' => $p_key,
                'csid' => $request->csid,
                'sesid' => $request->sesid,
                'ca_score' => $request->ca_score,
                'ex_score' => $request->ex_score,
                'status' => $request->status
            );

            try {
                Assessment::create($assessments_data);
            } catch (QueryException $exc) {

                return redirect('/admin/assessments')->with([
                            'flash_message' => $exc->getMessage(),
                            'status' => 'warning'
                ]);
            }


            return redirect('/admin/assessments')->with([
                        'flash_message' => 'Course Created and set active Successfuly ',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/assessments')->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function update_assessment(Request $request) {
        //ensure that form request method is a POST method
        if ($request->isMethod('post')) {
            //Set the form validation rules
            $rule = array();
            $rule['csid'] = 'required';
            $rule['ca_score'] = 'required';
            $rule['ex_score'] = 'required';
            $rule['sesid'] = 'required';
            $rule['status'] = 'required';

            $this->validate($request, $rule);

            $assessments_data = array(
                'csid' => $request->csid,
                'sesid' => $request->sesid,
                'ca_score' => $request->ca_score,
                'ex_score' => $request->ex_score,
                'status' => $request->status
            );

            Assessment::where('assid', $request->edit_id)->update($assessments_data);
            return redirect('/admin/assessments')->with([
                        'flash_message' => 'Assessments Updated Successfuly ',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/assessments')->with([
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
    public function delete_assessment(Request $request) {
        if ($request->isMethod('post')) {
            Assessment::destroy($request->edit_id);
            return redirect('/admin/assessments')->with([
                        'flash_message' => 'Assessment and other connected record deleted successfully',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/assessments')->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    
    
    /**
     * Get all test Under a perticular 
     * Assessment for the current 
     * active session
     * 
     * @param type $ass_id
     * @return type
     */
    public function assessment($ass_id) {

        $assessment = Assessment::with('session', 'course')->where('assid', $ass_id)->first();
        
        $query = sprintf("SELECT t.*,typ.ttypname, s.sesname,c.csid, "
                        . "(SELECT COUNT(q.qid) FROM CBT_questions q WHERE q.tid = t.tid) AS question_count "
                        . "FROM CBT_tests t "
                        . "JOIN CBT_test_types typ ON t.ttypid = typ.ttypid "
                        . "JOIN CBT_assessments ass ON t.assid = ass.assid "
                        . "JOIN CBT_sessions s ON ass.sesid = s.sesid "
                        . "JOIN CBT_courses c ON ass.csid = c.csid "
                        . "WHERE ass.assid = ? ");
        $tests = DB::select($query, [$ass_id]);
        
        $used_test_type = array();
        foreach($tests as $test){
            array_push($used_test_type, $test->ttypid);
        }
        $test_type = Testtype::whereNotIn('ttypid',$used_test_type)->get();
        
        if (!$assessment) {
            return view('errors.503');
        }
        
        $test_type2 = Testtype::all();
        
        $data['assessment'] = $assessment;
        $data['tests'] = json_encode($tests);
        $data['test_types'] = json_encode($test_type);
        $data['test_types2']= json_encode($test_type2);
        
        return view('admin.assessment', $data);
    }

    
    
    /*
      | --------------------------------------------------------------------------
      | Test Types  management
      | --------------------------------------------------------------------------
     */
    
    public function test_types() {
        $test_type = Testtype::all();
        $data['test_type'] = $test_type;
        //dd($courses);
        return view('admin.test_type', $data);
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function create_test_type(Request $request) {
        //ensure that form request method is a POST method
        if ($request->isMethod('post')) {
            //Set the form validation rules
            $rule = array();
            $rule['ttypname'] = 'required';
            $rule['status'] = 'required';

            $this->validate($request, $rule);

            $test_type_data = array(
                'ttypname' => strtoupper($request->ttypname),
                'status' => $request->status
            );
            Testtype::create($test_type_data);
            return redirect('/admin/test_type')->with([
                        'flash_message' => 'Test Type is created and set active Successfuly ',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/test_type')->with([
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
    public function update_test_type(Request $request) {
        //ensure that form request method is a POST method
        if ($request->isMethod('post')) {
            //Set the form validation rules
            $rule = array();
            
            $rule['ttypname'] = 'required';
            $rule['status'] = 'required';

            $this->validate($request, $rule);

            $course_data = array(
                'ttypname' => strtoupper($request->ttypname),
                'status' => $request->status
            );

            Testtype::where('ttypid', $request->edit_id)->update($course_data);
            return redirect('/admin/test_type')->with([
                        'flash_message' => 'Test Type Updated Successfuly ',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/test_type')->with([
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
    public function delete_test_type(Request $request) {

        if ($request->isMethod('post')) {
            Testtype::destroy($request->edit_id);
            return redirect('/admin/test_type')->with([
                        'flash_message' => 'Test type and other connected record deleted successfully',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/courses')->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }
    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function create_test(Request $request) {
        //ensure that form request method is a POST method
        if ($request->isMethod('post')) {
            $rule = array();
            $rule['assid'] = 'required';
            $rule['ttypid'] = 'required';
            $rule['noq'] = 'required';
            $rule['category'] = 'required';
            $rule['mark_obtainable'] = 'required';
            $rule['rand_question'] = 'required';
            $rule['image_capture'] = 'required';
            $rule['show_score'] = 'required';
            $rule['show_rank'] = 'required';
            $rule['start_message'] = 'required';
            $rule['end_message'] = 'required';
            $rule['time'] = 'required';
            $rule['status'] = 'required';

            $this->validate($request, $rule);

            $test_data = array(
                'tid' => $request->assid . '_' . $request->ttypid,
                'assid' => $request->assid,
                'category' => $request->category,
                'noq' => (int) $request->noq,
                'ttypid' => $request->ttypid,
                'mark_obtainable' => (int) $request->mark_obtainable,
                'rand_question' => $request->rand_question,
                'image_capture' => $request->image_capture,
                'show_score' => $request->show_score,
                'show_rank' => $request->show_rank,
                'start_message' => $request->start_message,
                'end_message' => $request->end_message,
                'time' => $request->time,
                'status' => $request->status
            );

            try {
                Test::create($test_data);
            } catch (\Illuminate\Database\QueryException $exc) {

                if ($exc->errorInfo[1] == 1062) {
                    return redirect('/admin/assessment/' . $request->assid)->with([
                                'flash_message' => "Duplicate Entry! Test already Exist",
                                'status' => 'error'
                    ]);
                }
            }
            return redirect('/admin/assessment/' . $request->assid)->with([
                        'flash_message' => "Test Created Successfully",
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/assessment/' . $request->assid)->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function update_test(Request $request) {
        if ($request->isMethod('post')) {
            $rule = array();
            $rule['ttypid'] = 'required';
            $rule['noq'] = 'required';
            $rule['category'] = 'required';
            $rule['mark_obtainable'] = 'required';
            $rule['rand_question'] = 'required';
            $rule['image_capture'] = 'required';
            $rule['show_score'] = 'required';
            $rule['show_rank'] = 'required';
            $rule['time'] = 'required';
            $rule['status'] = 'required';

            $this->validate($request, $rule);

            $test_data = array(
                'category' => $request->category,
                'noq' => (int) $request->noq,
                'ttypid' => $request->ttypid,
                'mark_obtainable' => (int) $request->mark_obtainable,
                'rand_question' => $request->rand_question,
                'image_capture' => $request->image_capture,
                'show_score' => $request->show_score,
                'show_rank' => $request->show_rank,
                'start_message' => $request->start_message,
                'end_message' => $request->end_message,
                'time' => $request->time,
                'status' => $request->status
            );


            try {
                Test::where('tid', $request->edit_id)->update($test_data);

                return redirect('/admin/assessment/' . $request->assid)->with([
                            'flash_message' => "Test Updated Successfully",
                            'status' => 'success'
                ]);
            } catch (\Illuminate\Database\QueryException $exc) {

                if ($exc->errorInfo[1] == 1062) {
                    return redirect('/admin/assessment/' . $request->assid)->with([
                                'flash_message' => "Duplicate Entry! Test already Exist",
                                'status' => 'error'
                    ]);
                }
            }
        } else {
            return redirect('/admin/assessment/' . $request->assid)->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function delete_test(Request $request) {
        if ($request->isMethod('post')) {
            Test::destroy($request->edit_id);
            return redirect('/admin/assessment/' . $request->assid)->with([
                        'flash_message' => 'Test and other connected record deleted successfully',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/assessment/' . $request->assid)->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

    
    /**
     * 
     * @param Request $request
     * @param type $test_id
     * @return type
     */
    public function manage_test(Request $request, $test_id) {
        $query = sprintf("SELECT t.*,typ.ttypname, s.sesname,c.csid, "
                        . "(SELECT COUNT(q.qid) FROM CBT_questions q WHERE q.tid = t.tid) AS question_count "
                        . "FROM CBT_tests t "
                        . "JOIN CBT_test_types typ ON t.ttypid = typ.ttypid "
                        . "JOIN CBT_assessments ass ON t.assid = ass.assid "
                        . "JOIN CBT_sessions s ON ass.sesid = s.sesid "
                        . "JOIN CBT_courses c ON ass.csid = c.csid "
                        . "WHERE t.tid = ? ");
        $test = DB::select($query, [$test_id]);
      
        $test_attendant = Attendant::with('test', 'user', 'batch')->where('tid', $test_id)->get();
        $batch = Batch::all();
        $data = array();
        $data['test'] = json_encode($test);
        $data['batch'] = json_encode($batch);
        $data['attendants'] = json_encode($test_attendant);
        
        return view('admin.manage_test', $data);
    }

    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function load_test_users(Request $request) {
        //check if method is POST
        if ($request->isMethod('post')) {
            //Define Upload Status
            $upload_status = array(
                'exist' => array(),
                'loaded' => array(),
                'user_not_found' => array(),
            );

            //set form Validation rule
            //validate from request
            $rule = array(
                'users' => 'required',
                'tid' => 'required'
            );
            $this->validate($request, $rule);
            //Sanitize form post
            $users_str = trim(preg_replace('/\s\s+/', ' ', $request->users));
            //explode users from from post to array
            $users = explode(" ", $users_str );
            
            //Loop through the users 
            foreach ($users as $user) 
            { 
                //Check existence of each users in users table 
                //before performing instersion into attendant table 
                $found_in_user = User::where('userid', $user)
                                    ->where('access', 'student')
                                    ->count();
                
                if($found_in_user > 0)
                { 
                    //try insert user to attendant and
                    //catch duplicate entry if user 
                    //already exist on users table 
                    try 
                    {
                        $attend_data = array(
                            'attndid' =>  $user."_".$request->tid,
                            'userid'  =>  $user, 
                            'tid'     =>  $request->tid,
                            'batchid'   =>  $request->batch,
                            'used_time'   =>  '00:00:00',
                        );
                        
                        Attendant::create($attend_data);
                        
                        array_push($upload_status['loaded'], $user);
                    } 
                    catch (\Illuminate\Database\QueryException $exc) 
                    {
                        if ($exc->errorInfo[1] == 1062) {
                            array_push($upload_status['exist'], $user);
                        }
                    }
                }
                else
                {
                    array_push($upload_status['user_not_found'], $user);
                }
            }
            return redirect('/admin/test/manage/' . $request->tid)->with([
                        'upload_status' => $upload_status
            ]);
        } 
        else 
        {
            return redirect('/admin/test/manage/' . $request->tid)->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }
    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function attendee_batch_status(Request $request){
        //ensure that form request method is a POST method
        if ($request->isMethod('post')){
            $resp = Attendant::where('tid', $request->tid)
                              ->where('batchid', $request->batch)
                              ->update(['status' => $request->status]);
            
            $msg = sprintf("%s Student(s) in the selected batch has been set to %s successfully", $resp,$request->status );
            
            return redirect('/admin/test/manage/' . $request->tid)->with([
                        'flash_message' => $msg,
                        'status' => 'success'
            ]);
        }
        else
        {
            return redirect('/admin/test/manage/' . $request->tid)->with([
                        'flash_message' => 'Invalid request method',
                        'status' => 'error'
            ]);
        }
    }

   /*
    | --------------------------------------------------------------------------
    | Examination Center
    | --------------------------------------------------------------------------
   */

    
    public function exam_centers() {
        $center = Exam_centers::all();
        $data['center'] = $center;
        return view('admin.exam_centres', $data);
    }
    
    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function create_center(Request $request){
        //ensure that form request method is a POST method
        if ($request->isMethod('post')) {
            //Set the form validation rules
            $rule = array();
            $rule['centerid'] = 'required|unique:exam_centers,centerid';
            $rule['center_name'] = 'required|unique:exam_centers,center_name';
            $rule['ip'] = 'required|ip';
            $rule['status'] = 'required';

            $this->validate($request, $rule);

            $center_data = array(
                'centerid' => strtoupper($request->centerid),
                'center_name' => strtoupper($request->center_name),
                'ip' => $request->ip,
                'status' => $request->status
            );
            Exam_centers::create($center_data);
            return redirect('/admin/centers')->with([
                        'flash_message' => 'Exammination Center and set active Successfuly ',
                        'status' => 'success'
            ]);
        } else {
            return redirect('/admin/centers')->with([
                        'flash_message' => 'Invalid Request method',
                        'status' => 'error'
            ]);
        }
    }
    
    
    /**
     * 
     * @param Request $request
     * @param type $test_id
     * @return type
     */
    public function set_question(Request $request, $test_id){
        
        $question = Question::where('tid', $test_id)->get();
        $data['test_id'] =  $test_id;
        $data['tot_quest'] = $question->count();
        return view('admin.set_question', $data);
    }
    
    
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function save_question(Request $request){
        if ($request->isMethod('post')){
            $question = Question::where('tid', $request->test_id)->get();
            
            $rule = array();
            $rule['question'] = 'required';
            $rule['option1'] = 'required';
            $rule['option2'] = 'required';
            $rule['option3'] = 'required';
            $rule['option4'] = 'required';
            $rule['choice'] = 'required';
            
            $this->validate($request, $rule);
            
            $quest_data = array(
                    'qid' =>  $request->test_id."_".($question->count() + 1),
                    'tid'  =>  $request->test_id, 
                    'instruction'  =>  $request->instruction,
                    'question'  =>  $request->question,
                    'option1'   =>  $request->option1,
                    'option2'   =>  $request->option2,
                    'option3'   =>  $request->option3,
                    'option4'   =>  $request->option4,
                    'choice'   =>  $request->choice,
                );
            
            Question::create($quest_data);
            return redirect("/admin/test/questions/{$request->test_id}")->with([
                        'flash_message' => 'Question Added to Test Successfully',
                        'status' => 'success'
            ]);
        }
        else{
            return redirect("/admin/test/questions/{$request->test_id}")->with([
                        'flash_message' => 'Invalid Request method',
                        'status' => 'error'
            ]);
        }
    }
    
    
    
    /**
     * 
     * @param Request $request
     * @param type $test_id
     * @return type
     */
    public function question_bank(Request $request, $test_id = NULL){
        if ($request->isMethod('get')){
            $question = Question::where('tid', $test_id)->get();
            
            $data['question'] = $question;
            return view("");
        }
        else
        {
            return redirect("/admin/test/questions/{$request->test_id}")->with([
                        'flash_message' => 'Invalid Request method',
                        'status' => 'error'
            ]);
        }
    }
    
    
    /**
     * 
     * @param type $attndid
     */
    public function test_history($attndid){
        $pass = 0;
        $fail = 0;
        $unanswered = 0;
        
        $my_report = DB::table('attendants')
                ->join('choices','attendants.attndid', '=', 'choices.attndid')
                ->join('questions', 'choices.qid', '=', 'questions.qid')
                ->select('*')
                ->where('attendants.attndid', $attndid ) 
                ->addSelect('questions.choice as answer')
                ->addSelect('choices.choice as my_choice')
                ->get();
        
        foreach ($my_report as $value) {
            
            if($value->my_choice == NULL){
                $unanswered += 1;
            }
            else
            {
                if($value->my_choice == $value->answer){
                    $pass += 1; 
                }
                else 
                {
                    $fail += 1;
                }
            }
        }
        $data['param'] = array(
                        'pass' => $pass,
                        'fail' => $fail,
                        'Unanswered' => $unanswered
                    );
        $data['rs'] = $my_report;
        
        //dd($my_report);
        
        return view('admin.test_history', $data);
        
    }
    
    
    
    public function assesment_report($assid){
        
        $tests = Test::where('assid', $assid )->get();
        
        foreach($tests as $test){
            
        }
    }
}
