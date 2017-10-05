@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="panel panel-default panel-success panel-colorful tabs">                            
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#tab-first" role="tab" data-toggle="tab" aria-expanded="false">2015/2017 CSC111 CA.1</a></li>
                </ul>                            
                <div class="panel-body tab-content">
                    <div class="tab-pane active" id="tab-first" >
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tab-content" ng-cloak="">
                                        <div class="tab-pane active" id="start_test" ng-if="!start_test" >
                                            <span>Alloted Time: {{attendant.test.time}}  </span><br/>
                                            <span>Total Question: {{attendant.test.noq}} </span><br/>
                                            <span>Obtainable Mark: {{attendant.test.mark_obtainable}}</span><br/>
                                            <br/>
                                            <button class="btn btn-default" ng-click="startNow()">Start Test</button>
                                        </div>
                                        
                                        <div ng-repeat="ques in questions" ng-if="start_test" class="tab-pane" ng-class="{'active': $index == 0}" id="{{$index}}">
                                            <b>Question {{$index + 1}}</b>
                                            <p style="color: brown">{{ques.question.instruction}} </p>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div ng-bind-html="renderHTML(ques.question.question)"></div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <table class=" table">
                                                        <tr>
                                                            <td width="2%">
                                                                <input type="radio" name="option_{{$index}}" ng-checked="ques.choice == '1'" ng-click="saveChoice(ques, 1); saveTime(attendant.attndid, attendant.test.time); nextQuestion(); ">
                                                            </td>
                                                            <td width="45%">
                                                                <div ng-bind-html="renderHTML(ques.question.option1)"></div>
                                                            </td>
                                                            
                                                            <td width="2%">
                                                                <input type="radio" name="option_{{$index}}" ng-checked="ques.choice == '2'" ng-click="saveChoice(ques, 2); saveTime(attendant.attndid, attendant.test.time); nextQuestion();">
                                                            </td>
                                                            <td width="45%">    
                                                                <div ng-bind-html="renderHTML(ques.question.option2)"></div>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td width="2%">
                                                                <input type="radio" name="option_{{$index}}" ng-checked="ques.choice == '3'" ng-click="nextQuestion(); saveChoice(ques, 3); saveTime(attendant.attndid, attendant.test.time); nextQuestion();">
                                                            </td>
                                                            <td width="45%">
                                                                <div ng-bind-html="renderHTML(ques.question.option3)"></div>
                                                            </td>
                                                            
                                                            <td width="2%">
                                                                <input type="radio" name="option_{{$index}}" ng-checked="ques.choice == '4'" ng-click="saveChoice(ques, 4); saveTime(attendant.attndid, attendant.test.time); nextQuestion();">
                                                            </td>
                                                            <td width="45%">    
                                                                <div ng-bind-html="renderHTML(ques.question.option4)"></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="end_test">
                                            <div class="alert alert-info">
                                                <p>
                                                    You have Choose to End this Examination Are you sure you what to proceed 
                                                </p>
                                                
                                                <button type="button" class="btn btn-danger" ng-click="setSelected(attendant); get_my_answered(attendant)" data-toggle="modal" data-target="#end_test_modal">End </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="well well-sm" ng-if="start_test" ng-cloak="">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="pagination pagination-sm pull-left">
                                        <li  ng-repeat="ques in questions" ng-if="start_test"  ng-class="{'active': $index == 0 }"><a href="#{{$index}}" data-toggle="tab" aria-expanded="false">{{$index + 1}}</a></li>
                                        <li><a href="#end_test" ng-click="saveTime(attendant.attndid, attendant.test.time)"class="btn btn-warning" role="tab" data-toggle="tab" aria-expanded="false">End Test</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal animated fade in" id="end_test_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">End Assessment </h4>
            </div>
            <form role="form" class="form-horizontal" method="POST" >
                
                <div class="modal-body">
                    <div class="row-fluid" ng-if="!end_ex_load">
                        <div class="alert alert-warning">
                            <p>You have chose to End this Assessment. <br/> 
                                You have {{my_resp.unanswered}} unanswered question <br/>
                                Are you sure you want to proceed with this action >
                            </p>
                        </div>
                    </div>
                    <div class="row-fluid" ng-if="end_ex_load">
                        <div class="" >
                            <p style="text-align: center !important">
                                <img src="[[asset("img/loaders/default.gif")]]">
                            </p>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-success" ng-click="endExam(current)" >Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script type="text/javascript" src="[[asset('js/demo_dashboard.js')]]"></script>
@endsection

@section('script')
<script>
    var ans_arr = {};
    var jsons = new Array();
    localStorage.clear();
    if (localStorage.getItem('ans_arr')) {
        jsons = JSON.parse(localStorage.getItem('ans_arr'));
    } 
    
</script>

<script type="text/javascript" src="[[asset('js/angular/angular-sanitize.min.js')]]"></script>
<script type="text/javascript">
    // Define the `phonecatApp` module
    var cbt = angular.module('cbt', ['ngSanitize']);
    
    var save_choice_url = "<?= url("/student/choice")?>";
    var save_error_url = "<?= url("/student/save_err")?>";
    var save_time_url = "<?= url("/student/time")?>";
    var end_exam_url = "<?= url("/student/endexam")?>";
    var my_answered_url = "<?= url("/student/my_answered")?>";
    var student_url = "<?= url("/student")?>";
    var question = <?= json_encode($my_questions)?>;
    var attendant = <?= json_encode($attendant)?>;
    var alloted = <?= json_encode($alloted); ?>;

    cbt.controller('PageController', function ($scope, $sce, $http ) {
    $scope.end_ex_load = false;
    $scope.save_choice_url = save_choice_url;
    $scope.end_exam_url = end_exam_url;
    $scope.student_url = student_url;
    $scope.save_time_url = save_time_url;
    $scope.save_error_url = save_error_url;
    $scope.my_answered_url = my_answered_url;
    $scope.start_test = false;
    $scope.questions = question;
    $scope.attendant = attendant;
    $scope.time1 = alloted;
    $scope.choice = {};
    
    
    
    $scope.current;
    $scope.setSelected = function (v) {
        $scope.current = v;
    }
    
    
    /**
     * Render 
     * 
     * @param {type} html_code
     * @return {unresolved}
     */
    $scope.renderHTML = function(html_code){
        var decoded = angular.element('<textarea />').html(html_code).text();
        return $sce.trustAsHtml(decoded);
    };
    
    
    
    /**
     * 
     * @return {undefined}
     */
    $scope.startNow = function(){
        $scope.start_test = true;
        $scope.timmer();
        localStorage.removeItem("ans_arr");
//        localStorage.setItem("ans_arr", []);
    };
    
    
    
    /**
     * 
     * @return {undefined}
     */
    $scope.timmer = function(){
        var $used = $scope.time1;
        function update() {
            var myTime = $used;
            var ss = myTime.split(":");
            var dt = new Date();
            dt.setHours(ss[0]);
            dt.setMinutes(ss[1]);
            dt.setSeconds(ss[2]);
            var dt2 = new Date(dt.valueOf() - 1000);
            var ts = dt2.toTimeString().split(" ")[0];
            //$("#worked").html(ts);
            $used = ts;
            $scope.time1 = $used;
            $scope.$apply();
            
            if(dt2.toTimeString() >= '00:00:01'){
                setTimeout(update, 1000);
            }else{
                alert('Your Time is up ');
                $scope.endExam($scope.attendant);
                $scope.try_unsave();
                $scope.saveTime($scope.attendant.attndid, $scope.attendant.test.time);
                window.location.replace($scope.student_url);
            }
        }
        setTimeout(update, 1000);
    };
    
    
    
    /**
     * 
     * @param {type} picked
     * @return {undefined}
     */
    $scope.saveChoice = function(q, option){
        var post = {
                qid : q.qid,
                attndid : q.attndid,
                choice: option
            };
        $http({
            method : "POST",
            url : $scope.save_choice_url,
            data: post
        }).then(function mySucces(response) {
            $.notify('Choice  Submitted', 'success');
            
            if(localStorage.getItem('ans_arr')){
                $scope.try_unsave();
            }
            
        }, function myError(response) {
            $scope.pushToLocalStorage(post); 
        });
        
    };
    
    
    /**
     * 
     * @param {type} atnd
     * @return {undefined}
     */
    $scope.updateTime = function(atnd){
        alert("Update my timer ");
    };
    
    
    
    /**
     * Logout 
     * 
     * @param {type} user
     * @return {undefined}
     */
    $scope.logoutUser = function(user){
        alert("..Loging Out user ");
    }
   
   
   
   /**
    * End exam 
    * 
    * @param {type} user
    * @return {undefined}
    */
    $scope.endExam = function(atnd){
        console.log(localStorage.getItem('ans_arr'));
        $scope.end_ex_load = true;
        $http({
            method : "POST",
            url : $scope.end_exam_url,
            data: {
                attndid : atnd.attndid,
                tid : atnd.tid,
                userid:atnd.userid,
                assid : atnd.test.assid,
                category: attendant.test.category
            }
        }).then(function mySucces(response) {
            $scope.try_unsave();
            $.notify('Operation Successfull', 'success');
            window.location.replace($scope.student_url);
        }, function myError(response) {
            $.notify("Operation Not successful try again", 'error');
        });
    };
    
    
    
    
    /**
     * Fetch all my answered question
     * @param {type} atnd
     * @return {undefined}
     */
    $scope.get_my_answered = function(atnd){
        $scope.end_ex_load = false;
        $http({
            method : "POST",
            url : $scope.my_answered_url,
            data: {
                attndid : atnd.attndid,
            }
        }).then(function mySucces(response) {
            $scope.my_resp = response.data;
            $scope.end_ex_load = false;
            console.log($scope.my_resp);
        }, function myError(response) {
            $.notify("Operation Not successful try again", 'error');
        });
        
    }
    
    
    
    /**
     * Push all un submitted choice to local storage 
     * will be submitted later
     * 
     * @param {type} choice
     * @return {undefined}
     */
    $scope.pushToLocalStorage = function(choice){
        
        jsons.push(choice);
        localStorage.setItem('err_ans', JSON.stringify(jsons));
        console.log(localStorage.getItem('err_ans'));
        $.notify('Choice can NOT be submitted. Continue with your work', 'error');
        
    };
    
    
    
    /**
     * Jump to the next question
     * 
     * @return {undefined}
     */
    $scope.nextQuestion = function(){
        console.log("Moving to the next question");
        return $('.pagination > .active').next('li').find('a').trigger('click');  
    };
    
    
    /**
     * Save unsubmited choice when network is okay 
     * @return {undefined}
     */
    $scope.try_unsave = function(){
        var unsaved = localStorage.getItem('err_ans');
        var f = JSON.parse(unsaved);
        
        $http({
            method : "POST",
            url : $scope.save_error_url,
            data: {er_dt : f}
        }).then(function mySucces(response) {
            $.notify('Your Unsubmitted choice has been submitted successfully', 'success');
            localStorage.removeItem('err_ans');
        }, function myError(response) {
            
        });
    };
    
    
    
    /**
     * 
     * @return {undefined}
     */
    $scope.saveTime = function(attend_id, alloted_time){
        $http({
            method : "POST",
            url : $scope.save_time_url,
            data: {
                atnd : attend_id,
                time : $scope.time1,
                alloted : alloted_time
            }
        }).then(function mySucces(response) {
            console.log("time saved");
        }, function myError(response) {
            console.log("time not saved")
        });
    };
   
    $scope.startNow();
});




</script>
@endsection
