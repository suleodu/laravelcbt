
@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <div class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#create_center_modal">Add Center</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Session</h3>
                <div class="col-md-3">
                    <div class="input-group in">
                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                        <input type="text" ng-model="search" class="form-control" placeholder="Search" />
                    </div>
                </div>  
                <ul class="panel-controls">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                </ul>
            </div>
            <div class="panel-body panel-body-table">
                <table id="customers" class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="35%">Center Name</th>
                            <th width="30%">Center IP Address</th>
                            <th width="15%">Status</th>
                            <th width="15%">Date Created</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody ng-cloak>
                        <tr ng-repeat="c in exam_center|filter:search">
                            <td>{{$index + 1}}</td>
                            <td>{{c.center_name}}</td>
                            <td>{{c.ip}}</td>
                            <td>
                                <span ng-if="c.status == 'active'" class="badge badge-success">{{c.status}}</span>
                                <span ng-if="c.status == 'inactive'" class="badge badge-danger">{{c.status}}</span>
                            </td>
                            <td>{{c.created_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn  dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a ng-click="setSelected(c)" data-toggle="modal" data-target="#edit_test_type_modal">Edit</a></li>
                                        <li><a ng-click="setSelected(c)" data-toggle="modal" data-target="#delete_test_type_modal">Delete</a></li>
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

<!-- Create new Test Type -->        
<div class="modal animated fade in" id="create_center_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Add Center</h4>
            </div>
            <form action="[[ url('/admin/center/create') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Center ID</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="centerid" class="form-control" placeholder="Center ID (uniq)" value="[[ old('centerid') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Center Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="center_name" class="form-control" placeholder="Center Name" value="[[ old('center_name') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Center IP</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="ip" class="form-control" placeholder="IP Address" value="[[ old('ip') ]]"/>
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
                                    <option value="active" <?= (old('status') == 'active')? 'selected': '' ?>>Active</option>
                                    <option value="inactive" <?= (old('status') == 'inactive')? 'selected': '' ?>>Inactive</option>
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

<!-- Edit Test Type  -->        
<div class="modal animated fade in" id="edit_test_type_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Update Test Type </h4>
            </div>
            <form action="[[ url('/admin/center/update') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Center ID</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="centerid" class="form-control" placeholder="Center ID (uniq)" value="[[ old('centerid') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Center Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="center_name" class="form-control" placeholder="Center Name" value="[[ old('center_name') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Center IP</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="ip" class="form-control" placeholder="IP Address" value="[[ old('ip') ]]"/>
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
                                    <option value="active" <?= (old('status') == 'active')? 'selected': '' ?>>Active</option>
                                    <option value="inactive" <?= (old('status') == 'inactive')? 'selected': '' ?>>Inactive</option>
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

<!--Delete Course--> 
<div class="modal animated fade in" id="delete_test_type_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Delete Test Type </h4>
            </div>
            <form action="[[ url('/admin/test_type/delete') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <p>You have chose to delete Coourse  {{current.ttypname}} please not that by proceeding with this action 
                            you will delete all associated record to the Course i.e.</p>
                        <ul>
                            <li>All assessment Associated with  {{current.ttypname}} will be automatically deleted </li>
                            <li>All test and question created under  {{current.ttypname}} will be automatically deleted </li>
                            <li>All student answered choice connected to {{current.ttypname}} will be automatically deleted </li>
                        </ul>
                        <p>
                            Are you sure you still want to delete the session ? 
                        </p>
                    </div>
                    <input type="hidden" name="edit_id" value="{{current.ttypid}}">
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
    var exam_center = <?= json_encode($center) ?>;


    // Define the `PhoneListController` controller on the `phonecatApp` module
    cbt.controller('PageController', function ($scope) {

        $scope.exam_center = exam_center;

        $scope.current;
        $scope.setSelected = function (v) {
            $scope.test_type = v;
            $scope.current = v;
        }
    });
</script>
@endsection