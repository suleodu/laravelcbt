
@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <p>&nbsp;</p>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <div class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#upload_course_modal">Upload Courses</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#create_course_modal">Add Single Course</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="col-md-3">
                    <div class="input-group in">
                        <span class="input-group-addon"><span class="fa fa-search"></span> Search</span>
                        <input type="text" ng-model="search" class="form-control" placeholder="Search" />
                    </div>
                </div>  
                <ul class="panel-controls">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                </ul>
            </div>
            <div class="panel-body panel-body-table">
                <div class="table-responsive">
                    <table id="customers" class="table table-striped">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Course Code </th>
                                <th width="55%">Course Title</th>
                                <th width="10%">Status</th>
                                <th width="15%">Created At</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody ng-cloak>
                            <tr ng-repeat="cs in courses|filter:search | orderBy:csid | limitTo:10">
                                <td>{{$index + 1}}</td>
                                <td>{{cs.csid}}</td>
                                <td>{{cs.csname}}</td>
                                <td>
                                    <span ng-if="cs.status == 'active'" class="badge badge-success">{{cs.status}}</span>
                                    <span ng-if="cs.status == 'inactive'" class="badge badge-danger">{{cs.status}}</span>
                                </td>
                                <td>{{cs.created_at}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn  dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a ng-click="setSelected(cs)" data-toggle="modal" data-target="#edit_course_modal">Edit</a></li>
                                            <li><a ng-click="setSelected(cs)" data-toggle="modal" data-target="#delete_course_modal">Delete</a></li>
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
</div>


<!-- Create new Course -->        
<div class="modal animated fade in" id="create_course_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Add New Course</h4>
            </div>
            <form action="[[ url('/admin/courses/create') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Course Code</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="csid" class="form-control" placeholder="Course Code" value="[[ old('csid') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Course Title</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" required="" name="csname" class="form-control" placeholder="Course Title" value="[[ old('csname') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Status</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-saved"></span></span>
                                <select class="form-control" name="status">
                                    <option>--choose--</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>                                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" >Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Course -->        
<div class="modal animated fade in" id="edit_course_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Update Course</h4>
            </div>
            <form action="[[ url('/admin/courses/update') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Course Code</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="csid" class="form-control" placeholder="Course Code" value="{{current.csid}}"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Course Title</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" required="" name="csname" class="form-control" placeholder="Course Title" value="{{current.csname}}"/>
                            </div>                                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Status</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-saved"></span></span>
                                <select class="form-control" name="status">
                                    <option>--choose--</option>
                                    <option value="active" ng-selected="current.status == 'active'">Active</option>
                                    <option value="inactive" ng-selected="current.status == 'inactive'">Inactive</option>
                                </select>
                            </div>                                            
                        </div>
                    </div>
                    <input type="hidden" name="edit_id" value="{{current.csid}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" >Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Delete Course--> 
<div class="modal animated fade in" id="delete_course_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Delete User </h4>
            </div>
            <form action="[[ url('/admin/courses/delete') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <p>You have chose to delete Coourse  {{current.csid}} please not that by proceeding with this action 
                           you will delete all associated record to the Course i.e.</p>
                        <ul>
                            <li>All assessment Associated with  {{current.csid}} will be automatically deleted </li>
                            <li>All test and question created under  {{current.userid}} will be automatically deleted </li>
                            <li>All student answered choice connected to {{current.csid}} will be automatically deleted </li>
                        </ul>
                        <p>
                            Are you sure you still want to delete the session ? 
                        </p>
                    </div>
                    <input type="hidden" name="edit_id" value="{{current.csid}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" >Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Upload Course-->
<div class="modal animated fade in" id="upload_course_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Upload Multiple Course </h4>
            </div>
            <form action="[[ url('/admin/courses/upload') ]]" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <p>This Upload function can only support CSV file upload the format to upload is described below </p>
                        <table class="table table-condensed table-bordered">
                            <tr>
                                <td>CSC111</td>
                                <td>Introduction to computer I</td>
                            </tr>
                            <tr>
                                <td>CSC112</td>
                                <td>Introduction to computer II</td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Attche Excel or CSV file </label>
                        <div class="col-md-6 col-xs-12"> 
                            <input type="file" name="csvfile" >                                          
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" >Upload</button>
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
    var courses = <?= json_encode($courses)?>;
    

    // Define the `PhoneListController` controller on the `phonecatApp` module
    cbt.controller('PageController', function ($scope) {
        
        $scope.courses = courses;
        
        $scope.current;
        $scope.setSelected = function (v) {
            $scope.current = v;
        }
    });
</script>
@endsection
