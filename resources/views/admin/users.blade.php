
@extends('layouts.main')

@section('content')
<p>&nbsp;</p>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <div class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#upload_user_modal">Upload Bulk User</button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#create_user_modal">Add Individual User</button>
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
            <div class="panel-body">
                <table id="customers" class="table table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Userid</th>
                            <th width="50%">Full Name</th>
                            <th width="10%">Email</th>
                            <th width="5%">Status</th>
                            <th width="15%">Created At</th>
                            <th width="5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody ng-cloak>
                        <tr ng-repeat="us in users |filter:search | orderBy : userid | limitTo: 10">
                            <td>{{$index + 1}}</td>
                            <td>{{us.userid}}</td>
                            <td>{{us.fname +' '+ us.mname + ' '+ us.lname}}</td>
                            <td>{{us.email}}</td>
                            <td>
                                <span ng-if="us.status == 'active'" class="badge badge-success">{{us.status}}</span>
                                <span ng-if="us.status == 'inactive'" class="badge badge-danger">{{us.status}}</span>
                            </td>
                            <td>{{us.created_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn  dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a ng-click="setSelected(us)" data-toggle="modal" data-target="#edit_user_modal">Edit</a></li>
                                        <li><a ng-click="setSelected(us)" data-toggle="modal" data-target="#delete_user_modal">Delete</a></li>
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


<!-- Create new Users -->        
<div class="modal animated fade in" id="create_user_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Add new User</h4>
            </div>
            <form action="[[ url('/admin/users/create') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">User ID</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="userid" class="form-control" placeholder="User ID" value="[[ old('userid') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">First Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" required="" name="fname" class="form-control" placeholder="First Name" value="[[ old('fname') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Last Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" required="" name="lname" class="form-control" placeholder="Last Name" value="[[ old('lname') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Middle Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text"  name="mname" class="form-control" placeholder="Middle Name" value="[[ old('mname') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Email</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="email"   name="email" class="form-control" placeholder="E-mail" value="[[ old('email') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Password</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text"  name="password" class="form-control" placeholder="Password" value="[[ old('password') ]]"/>
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

<!-- Edit User -->        
<div class="modal animated fade in" id="edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Update User</h4>
            </div>
            <form action="[[ url('/admin/users/update') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">User ID</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" required="" name="userid" class="form-control" placeholder="User ID" value="{{current.userid}}"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">First Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" required="" name="fname" class="form-control" placeholder="First Name" value="{{current.fname}}"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Last Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" required="" name="lname" class="form-control" placeholder="Last Name" value="{{current.lname}}"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Middle Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text"  name="mname" class="form-control" placeholder="Middle Name" value="{{current.mname}}"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Email</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="email"   name="email" class="form-control" placeholder="E-mail" value="{{current.email}}"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Password</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text"  name="password" class="form-control" placeholder="Password" value=""/>
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
                    <input type="hidden" name="edit_id" value="{{current.userid}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" >Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Delete User--> 
<div class="modal animated fade in" id="delete_user_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Delete User </h4>
            </div>
            <form action="[[ url('/admin/users/delete') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <p>You have chose to delete user  {{current.userid}} please not that by proceeding with this action 
                            will delete all associated record to the user i.e.</p>
                        <ul>
                            <li>All test Record of  {{current.userid}} will be automatically deleted </li>
                            <li>All question answered by  {{current.userid}} will be automatically deleted </li>
                        </ul>
                        <p>
                            Are you sure you still want to delete the session ? 
                        </p>
                    </div>

                    <input type="hidden" name="edit_id" value="{{current.userid}}">
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
<div class="modal animated fade in" id="upload_user_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Upload Multiple Users </h4>
            </div>
            <form action="[[ url('/admin/users/upload') ]]" role="form" class="form-horizontal" method="POST" enctype="multipart/form-data"  >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="alert alert-info">
                        <p>This Upload function can only support CSV file is this format 
                           <br/> <b> ('Student ID','first name', 'middle name', 'last name') </b>
                            <br/>upload the format to upload is described below <br/>
                            NOTE : the last name will be set as the password by default
                        </p>
                        <table class="table table-condensed table-bordered">
                            <tr>
                                <td>20090204001</td>
                                <td>Adedayo</td>
                                <td>Lateef</td>
                                <td>Sule-odu</td>
                            </tr>
                            <tr>
                                <td>20090204002</td>
                                <td>Olawale</td>
                                <td>Ibrahim</td>
                                <td>Johnson</td>
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
<script type="text/javascript" src="[[asset('js/demo_dashboard.js')]]"></script>
@endsection

@section('script')
<script type="text/javascript">
    // Define the `phonecatApp` module
    var cbt = angular.module('cbt', []);

    var users = <?= json_encode($users)?>;

    // Define the `PhoneListController` controller on the `phonecatApp` module
    cbt.controller('PageController', function ($scope) {
        $scope.users = users;
       
        $scope.current;
        $scope.setSelected = function (v) {
            $scope.current = v;
        }
    });
</script>
@endsection
