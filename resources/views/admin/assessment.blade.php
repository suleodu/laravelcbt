
@extends('layouts.main')

@section('content')

<div class="row" ng-cloak="">
    <div class="col-md-12">
        <p>&nbsp;</p>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Test for {{assessment.session.sesname}} {{assessment.course.csid}} Assessment</h3>
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
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <div class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#create_test_modal">Add New Test</button>
                        </div>
                    </div>
                </div>
                </p>
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
                        <tr ng-repeat="ts in tests|filter:search">
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
                                    <button class="btn btn-sm btn-default  dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a ng-click="setSelected(ts)" data-toggle="modal" data-target="#edit_test_modal">Edit</a></li>
                                        <li><a ng-click="setSelected(ts)" data-toggle="modal" data-target="#delete_test_modal">Delete</a></li>
                                        <li><a href="[[url('/admin/assessment/')]]/{{ts.assid}}/report">Report</a></li>
                                        <li><a href="[[url('/admin/test/manage')]]/{{ts.tid}}">Manage</a></li>
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

<!-- Create new Test -->        
<div class="modal animated fade in" id="create_test_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Create New Test for {{assessment.session.sesname}} {{assessment.course.csid}}</h4>
            </div>
            <form action="[[ url('/admin/tests/create') ]]" role="form" class="form-horizontal" method="POST" >
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
                                            <option ng-repeat="tty in test_types" value="{{tty.ttypid}}">{{ tty.ttypname}}</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Answerable Question </label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="number" required="" name="noq" class="form-control" placeholder="No. of Question to be answered" value="[[ old('noq') ]]"/>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Obtainable Score</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="number" required name="mark_obtainable" class="form-control" placeholder="Obtainable Exam Score" value="[[ old('mark_obtainable') ]]"/>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Time Alloted</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        <input type="text" required name="time" class="form-control" placeholder="time in Min." value="[[ old('time') ]]"/>
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
                                            <option value="true">Enable</option>
                                            <option value="false">Disable</option>
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
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
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
                                            <option value="true">Enable</option>
                                            <option value="false">Disable</option>
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
                                            <option value="true">Enable</option>
                                            <option value="false">Disable</option>
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
                                            <option value="true">Enable</option>
                                            <option value="false">Disable</option>
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
                                            <option value="CA">C.A</option>
                                            <option value="EXAM">EXAM</option>
                                        </select>
                                    </div>                                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Start Message</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <textarea class="form-control" name="start_message"></textarea>                                           
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">End Message</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <textarea class="form-control" name="end_message"></textarea>                                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="assid" value="{{assessment.assid}}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" >Create</button>
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
                                            <option ng-repeat="tty2 in test_types2" value="{{tty2.ttypid}}" ng-selected="current.ttypid == tty2.ttypid">{{ tty2.ttypname}}</option>
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
                                        <input type="text" required name="time" pattern="/^([0-1][0-9]|2[0-3]):([0-5][0-9])(?::([0-5][0-9]))?$/g" class="form-control" placeholder="00:00:00" value="{{current.time}}"/>
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
<div class="modal animated fade in" id="delete_test_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Delete Test  {{current.tid}} </h4>
            </div>
            <form action="[[ url('/admin/tests/delete') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <p>You have chose to Test  {{current.tid}} please not that by proceeding with this action 
                            will delete all associated record to the Test i.e.</p>
                        <ul>
                            <li>All test Question of  {{current.tid}} will be automatically deleted </li>
                            <li>All test question Student that has enrolled and took the Test will deleted  </li>
                            <li>All question answered by student for {{current.tid}} will be automatically deleted </li>
                        </ul>
                        <p>
                            Are you sure you still want to delete the Test  ? 
                        </p>
                    </div>

                    <input type="hidden" name="edit_id" value="{{current.tid}}">
                    <input type="hidden" name="assid" value="{{current.assid}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" >Delete</button>
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

    var assessment = <?= $assessment; ?>;
    var test = <?= $tests?>;
    var test_type = <?= $test_types?>;
    var test_type2 = <?= $test_types2?>;

    cbt.controller('PageController', function ($scope) {
        $scope.assessment = assessment;
        $scope.tests = test;
        $scope.test_types = test_type;
        $scope.test_types2 = test_type2;
        
        $scope.current;
        $scope.setSelected = function (v) {
            $scope.current = v;
        }
    });
</script>
@endsection
