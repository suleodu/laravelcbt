
@extends('layouts.main')

@section('content')
@if (Session::has("upload_status"))
<div class="alert alert-info animated alert-dismissable" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <strong>Student Attendant Upload Status</strong> 
    <div class="row">
        <div class="col-md-4">
            <div class="alert alert-success">
                <p>
                    The below record are loaded successfully
                </p>
                <ul>
                    @foreach(session('upload_status')['loaded'] as $loaded)
                    <li>[[$loaded]]</li>
                    @endforeach
                </ul>
            </div>
        </div>
       
        <div class="col-md-4">
            <div class="alert alert-warning">
                <p>
                    Unable to load the below records.
                    Record already exist in Attendant Bank
                </p>
                <ul>
                    @foreach(session('upload_status')['exist'] as $exist)
                    <li>[[$exist]]</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-danger">
                <p>
                    Unable to load record.
                    No matching record found in User bank. 
                    Navigate to users to add
                </p>
                <ul>
                    @foreach(session('upload_status')['user_not_found'] as $exist)
                    <li>[[$exist]]</li>
                    @endforeach
                </ul>
            </div>
        </div>
        
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Test Property</h3>
                <ul class="panel-controls">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                
                <table id="customers" class="table table-striped">
                    <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="5%">Course Title</th>
                            <th width="5%">Test Type</th>
                            <th width="5%">Total Quest.</th>
                            <th width="5%">Answerable Quest.</th>
                            <th width="5%">Obtainable Mark</th>
                            <th width="5%">Random Quest.</th>
                            <th width="5%">Capture Image</th>
                            <th width="5%">Show score</th>
                            <th width="5%">Show Rank</th>
                            <th width="5%">Time Alloted</th>
                            <th width="5%">Status</th>
                            <th width="5%">Created At</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody ng-cloak>
                        <tr ng-repeat="ts in tests">
                            <td>{{$index + 1}}</td>
                            <td>{{ts.csid}}</td>
                            <td>{{ts.ttypname}}</td>
                            <td>{{ts.question_count}}</td>
                            <td>{{ts.noq}}</td>
                            <td>{{ts.mark_obtainable}}</td>
                            <td>
                                <span  class="badge" ng-class="(ts.rand_question == 'true')? 'badge-success': 'badge-danger'">{{ts.rand_question}}</span>
                            </td>
                            <td>
                                <span  class="badge" ng-class="(ts.image_capture == 'true')? 'badge-success': 'badge-danger'">{{ts.image_capture}}</span>
                            </td>
                            <td>
                                <span  class="badge" ng-class="(ts.show_score == 'true')? 'badge-success': 'badge-danger'">{{ts.show_score}}</span>
                            </td>
                            <td>
                                <span  class="badge" ng-class="(ts.show_rank == 'true')? 'badge-success': 'badge-danger'">{{ts.show_rank}}</span>
                            </td>
                            <td>{{ts.time}}</td>
                            <td>
                                <span  class="badge" ng-class="(ts.status == 'active')? 'badge-success': 'badge-danger'">{{ts.status}}</span>
                            </td>
                            <td>{{ts.created_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a ng-click="setSelected(ts)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit_test_modal">Edit Test</a></li>
                                        <li><a ng-click="setSelected(ts)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload_quest_modal" title="Upload question to this Test">Upload question</a></li>
                                        <li><a href="[[url('/admin/test/questions')]]/{{ts.tid}}" class="btn btn-success btn-sm"  title="Set Question">Set Question</a></li>
                                        <li><a ng-click="setSelected(ts)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#deact_batch_modal" title="Deactivate attendant in a perticular batch">Batch Status</a></li>
                                        <li><a ng-click="setSelected(ts)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#load_attendant_modal" title="Upload Eligibe student that are to take this test">Upload Attendant</a></li>
                                        <li><a ng-click="setSelected(ts)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#delete_test_modal" title="Monitor Image Captured ">Monitor Images</a></li>
                                        
                                    </ul>
                                </div> 
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!--Test Users--> 
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Registered Students</h3>
                <ul class="panel-controls">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <p>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group in">
                            <span class="input-group-addon"><span class="fa fa-search"></span></span>
                            <input type="text" ng-model="search" class="form-control" placeholder="Search" />
                        </div>
                    </div> 
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <span class="label label-info label-form">Total Users: {{test_attendant.length}}</span>
                            <span class="label label-success label-form">Total Finished: 500</span>
                            <span class="label label-warning label-form">Left: 500</span>
                        </div>
                    </div>
                </div>
                </p>
                <table id="customers" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="5%">Student ID</th>
                            <th width="5%">First Name</th>
                            <th width="5%">Last Name</th>
                            <th width="5%">Middle Name</th>
                            <th width="5%">Password</th>
                            <th width="5%">Status</th>
                            <th width="5%">batch</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody ng-cloak>
                        <tr ng-repeat="atnd in test_attendant| filter:search  | limitTo :15" >
                            <td>{{$index + 1}}</td>
                            <td>{{atnd.userid}}</td>
                            <td>{{atnd.user.fname}}</td>
                            <td>{{atnd.user.lname}}</td>
                            <td>{{atnd.user.mname}}</td>
                            <td>Password Here </td>
                            <td><span class="badge badge-success">{{atnd.response_status}}</span></td>
                            <td><span class="badge" ng-class="(atnd.status == 'active')? 'badge-success':'badge-danger'">{{atnd.batch.batch_name}}</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="[[url('/admin/test/history/')]]/{{atnd.attndid}}" target="tab">History</a></li>
                                        <li><a ng-click="" data-toggle="modal" data-target="#delete_test_modal">Edit Time</a></li>
                                        <li><a ng-click="" data-toggle="modal" data-target="#delete_test_modal">Logout</a></li>
                                    </ul>
                                </div> 
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Upload Attendant Test -->        
<div class="modal animated fade in" id="load_attendant_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Upload Student to Test</h4>
            </div>
            <form action="[[ url('/admin/test/load_users') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                NOTE!Add one username per row. Do not leave spaces.
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">List of Student</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <textarea class="form-control" name="users" rows="10" required=""></textarea>                                           
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Batch</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <select name="batch" class="form-control" required="">
                                        <option value="">--Choose Batch --</option>
                                        <option ng-repeat="bc in batch" value="{{bc.batchid}}">{{bc.batch_name}}</option>
                                    </select>                                          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tid" value="{{current.tid}}">
                <input type="hidden" name="assid" value="{{current.assid}}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" >Add Students To Test</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Test -->        
<div class="modal animated fade in" id="edit_test_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Update Test </h4>
            </div>
            <form action="[[ url('/admin/tests/update') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Test Type</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-stumbleupon"></span></span>
                                        <select class="form-control" required name="ttypid">
                                            <option>-- Choose --</option>
                                            <option ng-repeat="tty in test_types" value="{{tty.ttypid}}" ng-selected="current.ttypid == tty.ttypid">{{ tty.ttypname}}</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Answerable Question </label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="number" required="" name="noq" class="form-control" placeholder="No. of Question to be answered" value="{{current.noq}}"/>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Obtainable Score</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="number" required name="mark_obtainable" class="form-control" placeholder="Obtainable Exam Score" value="{{current.mark_obtainable}}"/>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Time Alloted</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="number" required name="time" class="form-control" placeholder="time in Min." value="{{current.time}}"/>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Random Question</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-random"></span></span>
                                        <select class="form-control" name="rand_question" required>
                                            <option>--choose--</option>
                                            <option value="true" ng-selected="current.rand_question == 'true'">Enable</option>
                                            <option value="false" ng-selected="current.rand_question == 'false'">Disable</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Status</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-saved"></span></span>
                                        <select class="form-control" name="status" required>
                                            <option>--choose--</option>
                                            <option value="active" ng-selected="current.status == 'active'">Active</option>
                                            <option value="inactive" ng-selected="current.status == 'inactive'">Inactive</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Capture Image</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-camera"></span></span>
                                        <select class="form-control" name="image_capture" required>
                                            <option>--choose--</option>
                                            <option value="true" ng-selected="current.image_capture == 'true'">Enable</option>
                                            <option value="false"ng-selected="current.image_capture == 'false'">Disable</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Show score </label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-saved"></span></span>
                                        <select class="form-control" name="show_score" required>
                                            <option>--choose--</option>
                                            <option value="true" ng-selected="current.show_score == 'true'">Enable</option>
                                            <option value="false" ng-selected="current.show_score == 'false'">Disable</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Show Ranks </label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-saved"></span></span>
                                        <select class="form-control" name="show_rank" required>
                                            <option>--choose--</option>
                                            <option value="true" ng-selected="current.show_rank == 'true'">Enable</option>
                                            <option value="false" ng-selected="current.show_rank == 'false'" >Disable</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Test Category </label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-saved"></span></span>
                                        <select class="form-control" name="category" required>
                                            <option>--choose--</option>
                                            <option value="CA" ng-selected="current.category == 'CA'" >C.A</option>
                                            <option value="EXAM" ng-selected="current.category == 'EXAM'">EXAM</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Start Message</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <textarea class="form-control" name="start_message">{{current.start_message}}</textarea>                                           
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">End Message</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <textarea class="form-control" name="end_message">{{current.end_message}}</textarea>                                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="edit_id" value="{{current.tid}}">
                <input type="hidden" name="assid" value="{{current.assid}}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" >Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Delete Test--> 
<div class="modal animated fade in" id="upload_quest_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Upload Question</h4>
            </div>
            <form action="[[ url('/admin/tests/delete') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    jxhcjkhkajf
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" >Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--Batch deactivation--> 
<div class="modal animated fade in" id="deact_batch_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Attendee Batch status</h4>
            </div>
            <form action="[[ url('/admin/test/change_batch_status') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                NOTE!Add one username per row. Do not leave spaces.
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Batch</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <select name="batch" class="form-control" required="">
                                        <option value="">--Choose Batch --</option>
                                        <option ng-repeat="bc in batch" value="{{bc.batchid}}">{{bc.batch_name}}</option>
                                    </select>                                          
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Status</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-saved"></span></span>
                                        <select class="form-control" name="status" required>
                                            <option>--choose--</option>
                                            <option value="active" >Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tid" value="{{current.tid}}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" >Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    // Define the `phonecatApp` module
    var cbt = angular.module('cbt', []);

    var test_attendant = <?= $attendants; ?>;
    var test = <?= $test?>;
    var batch = <?= $batch ?>;
    

    cbt.controller('PageController', function ($scope) {
        $scope.test_attendant = test_attendant;
        $scope.tests = test;
        $scope.batch = batch;
        $scope.limit = 15;
        
        $scope.current;
        $scope.setSelected = function (v) {
            $scope.current = v;
        };
        
    });
</script>
@endsection
