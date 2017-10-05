@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Welcome</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info"><h5>Welcome to CBT Solution </h5></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">                        
                                              
                    </div>
                    <div class="col-md-2">                        
                                                
                    </div>  
                    @if(Auth::user()->isAdmin() == 'false')
                    <div class="col-md-2">                        
                        <a href="[[url('student')]]" class="tile tile-warning tile-valign"><span class="fa fa-users"></span>
                            <div class="informer informer-default dir-bl"> Student</div>
                        </a>
                    </div>  
                    @else
                    <div class="col-md-2">                        
                        <a href="[[url('/admin/sessions')]]" class="tile tile-warning tile-valign"><span class="fa fa-laptop"></span>
                            <div class="informer informer-default dir-bl"> Management</div>
                        </a>                        
                    </div>
                    @endif
                    <div class="col-md-2">                        
                                              
                    </div>
                    <div class="col-md-2">                        
                                              
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
