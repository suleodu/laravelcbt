
@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Assessments Management</h3>
                <ul class="panel-controls">
                    
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                
                <p>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group in">
                            <span class="input-group-addon"><span class="fa fa-search"></span> Search</span>
                            <input type="text" ng-model="search" class="form-control" placeholder="Search" />
                        </div>
                    </div> 
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <div class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#create_assessment_modal">Add New Assessment</button>
                        </div>
                    </div>
                </div>
                </p>
                <table id="customers" class="table table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Course Code</th>
                            <th width="40%">Course Title</th>
                            <th width="10%">Total Student</th>
                            <th width="10%">Total Question</th>
                            <th width="5%">CA Score</th>
                            <th width="5%">Exam. Score</th>
                            <th width="5%">Status</th>
                            <th width="15%">Created At</th>
                            <th width="5%">Actions</th>
                            <th width="10%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody ng-cloak>
                        <tr ng-repeat="as in assessments|filter:search | limitTo: 10 | orderBy:csid">
                            <td>{{$index + 1}}</td>
                            <td>{{as.csid}}</td>
                            <td>{{as.course.csname}}</td>
                            <td>Todo</td>
                            <td>Todo</td>
                            <td>{{as.ca_score}}</td>
                            <td>{{as.ex_score}}</td>
                            <td>
                                <span ng-if="as.status == 'active'" class="badge" ng-class="(as.status == 'active')? 'badge-success' : 'badge-danger' ">{{as.status}}</span>
                            </td>
                            <td>{{as.created_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn  dropdown-toggle " type="button" data-toggle="dropdown">Actions
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="[[url('/admin/assessment/')]]/{{as.assid}}/report">Report</a></li>
                                        <li><a ng-click="setSelected(as)" data-toggle="modal" data-target="#edit_assessment_modal">Edit</a></li>
                                        <li><a ng-click="setSelected(as)" data-toggle="modal" data-target="#delete_assessment_modal">Delete</a></li>
                                    </ul>
                                </div> 
                            </td>
                            <td>
                                <a href="[[url('/admin/assessment')]]/{{as.assid}}" class="btn btn-info">Manage</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Create new Assessment -->        
<div class="modal animated fade in" id="create_assessment_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Create New Assessment for [[$active_session->sesname]]</h4>
            </div>
            <form action="[[ url('/admin/assessments/create') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Course</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-stumbleupon"></span></span>
                                <select class="form-control" required name="csid">
                                    <option>-- Choose --</option>
                                    <option ng-repeat="cs in courses" value="{{cs.csid}}">{{cs.csid +' - '+ cs.csname}}</option>
                                </select>
                            </div>                                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">C.A Score</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="number" required="" name="ca_score" class="form-control" placeholder="Obtainable C.A Score" value="[[ old('ca_score') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Exam Score</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                  <input type="number" required name="ex_score" class="form-control" placeholder="Obtainable Exam Score" value="[[ old('ex_score') ]]"/>
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
                <input type="hidden" name="sesid" value="[[$active_session->sesid]]">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" >Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Assessment -->        
<div class="modal animated fade in" id="edit_assessment_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Update Assessment </h4>
            </div>
            <form action="[[ url('/admin/assessments/update') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Course</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-stumbleupon"></span></span>
                                <select class="form-control" required name="csid">
                                    <option>-- Choose --</option>
                                    <option ng-repeat="cs in courses" value="{{cs.csid}}" ng-selected="cs.csid == current.csid">{{cs.csid +' - '+ cs.csname}}</option>
                                </select>
                            </div>                                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">C.A Score</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="number" required="" name="ca_score" class="form-control" placeholder="Obtainable C.A Score" value="{{current.ca_score}}"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Exam Score</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="number" required name="ex_score" class="form-control" placeholder="Obtainable Exam Score" value="{{current.ex_score}}"/>
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
                <input type="hidden" name="sesid" value="{{current.sesid}}">
                <input type="hidden" name="edit_id" value="{{current.assid}}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" >Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Delete Assessment--> 
<div class="modal animated fade in" id="delete_assessment_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Delete Assessment  {{current.assid}} </h4>
            </div>
            <form action="[[ url('/admin/assessments/delete') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <p>You have chose to delete assessment  {{current.assid}} please not that by proceeding with this action 
                            will delete all associated record to the assessment i.e.</p>
                        <ul>
                            <li>All test Record of  {{current.assid}} will be automatically deleted </li>
                            <li>All test question loaded for the above test will be automatically deleted </li>
                            <li>All question answered by student for {{current.assid}} will be automatically deleted </li>
                        </ul>
                        <p>
                            Are you sure you still want to delete the session ? 
                        </p>
                    </div>

                    <input type="hidden" name="edit_id" value="{{current.assid}}">
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

    var assessments = <?= $assessments ;?>;
    var courses = <?= json_encode($courses);?>;
    
    
    cbt.controller('PageController', function ($scope) {
        $scope.assessments = assessments;
        $scope.courses = courses;
        
        $scope.current;
        $scope.setSelected = function (v) {
            $scope.current = v;
        }
    });
</script>
@endsection
