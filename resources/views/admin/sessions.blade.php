
@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">

        <!-- START WIDGET SLIDER -->
        <div class="widget widget-default widget-carousel">
            <div class="owl-carousel" id="owl-example">
                <div>                                    
                    <div class="widget-title">Active Session </div>                                                                        
                    @if($activeses)
                    <div class="widget-int">[[$activeses->sesname]]</div>
                    @else
                    <div class="widget-int">NULL</div>
                    @endif
                </div>
                <div>                                    
                    <div class="widget-title">Total Session</div>
                    <div class="widget-int">[[ $sessions->count()]]</div>
                </div>
            </div>                            
            <div class="widget-controls">                                
                <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
            </div>                             
        </div>         
        <!-- END WIDGET SLIDER -->
    </div>
    <div class="col-md-3"></div>    
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Session</h3>
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
                                <button class="btn btn-primary" data-toggle="modal" data-target="#create_session_modal">Add New Session</button> 
                            </div>
                        </div>
                    </div>
                </p>
                <table id="customers" class="table table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="70%">Session Name</th>
                            <th width="10%">Passmark</th>
                            <th width="10%">Status</th>
                            <th width="5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody ng-cloak="">
                        <tr ng-repeat="ses in sessions | filter : search |limitTo:10">
                            <td>{{$index + 1}}</td>
                            <td>{{ses.sesname}}</td>
                            <td>{{ses.passmark}}</td>
                            <td><span class="badge badge-success">{{ses.status}}</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn  dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a ng-click="setSelected(ses)" data-toggle="modal" data-target="#edit_session_modal">Edit</a></li>
                                        <li><a <a ng-click="setSelected(ses)" data-toggle="modal" data-target="#delete_session_modal">Delete</a></li>
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

<!-- Create new session -->        
<div class="modal animated fade in" id="create_session_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Create New Session</h4>
            </div>
            <form action="[[ url('/admin/sessions/create') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Session Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" required="" name="sesname" class="form-control" placeholder="Session Name" value="[[ old('sesname') ]]"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Pass Mark</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-saved"></span></span>
                                <input type="number" required="" name="passmark" class="form-control" placeholder="Passmark" value="[[ old('passmark') ]]"/>
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

<!-- Edit new session -->        
<div class="modal animated fade in" id="edit_session_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Update Session</h4>
            </div>
            <form action="[[ url('/admin/sessions/update') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Session Name</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                <input type="text" required="" name="sesname" class="form-control" placeholder="Session Name" value="{{current.sesname}}"/>
                            </div>                                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Pass Mark</label>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-saved"></span></span>
                                <input type="number" required="" name="passmark" class="form-control" placeholder="Passmark" value="{{current.passmark}}"/>
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
                    <input type="hidden" name="edit_id" value="{{current.sesid}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning" >Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Delete session--> 
<div class="modal animated fade in" id="delete_session_modal" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Update Session</h4>
            </div>
            <form action="[[ url('/admin/sessions/delete') ]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <p>You have chose to delete session {{current.sesname}} please not that by proceeding with this action 
                            will delete all associated record to the sesion i.e.</p>
                        <ul>
                            <li>All assessment created under the session {{current.sessname}} will be automatically deleted </li>
                            <li>All test associated to the above assessment will automatically be deleted </li>
                            <li>All question associated to the above test will automatically be deleted </li>
                            <li>All user associated to the above test will automatically be deleted </li>
                            <li>All user and answered choice  associated to the above test will automatically be deleted </li>
                        </ul>
                        <p>
                            Are you sure you still want to delete the session ? 
                        </p>
                        <p>
                            HMM THINK AM WELL OOO !! 
                        </p>
                    </div>
                    
                    <input type="hidden" name="edit_id" value="{{current.sesid}}">
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
        
        var sessions = <?= json_encode($sessions)?>;

        // Define the `PhoneListController` controller on the `phonecatApp` module
        cbt.controller('PageController', function ($scope) {
            
            $scope.sessions = sessions;
            
            $scope.current;
            $scope.setSelected = function(v){
                $scope.current = v;
            }
        });
    </script>
@endsection
