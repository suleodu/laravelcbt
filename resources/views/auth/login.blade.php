@extends('layouts.main1')

@section('content')
<div class="login-container">

    <div class="login-box ">
        <div class="login-logo"></div>
        <div class="login-body">
            <div class="login-title"><strong>Welcome</strong>, Please login</div>
            <form action="[[ url('/login') ]]" role="form" class="form-horizontal" method="post" >
                [[ csrf_field() ]]
                @if (Auth::user())
                    [[ Auth::user()->fname ]]
                @endif
                <div class="form-group[[ $errors->has('userid') ? ' has-error' : '' ]]" >
                    <div class="col-md-12">
                        <input type="text" name="userid" class="form-control" placeholder="student ID" value="[[ old('userid') ]]"/>
                        
                        @if ($errors->has('userid'))
                        <span class="help-block">
                            <strong>[[ $errors->first('userid') ]]</strong>
                        </span>
                        @endif
                    </div>
                    
                </div>
                <div class="form-group[[ $errors->has('password') ? ' has-error' : '' ]]">
                    <div class="col-md-12">
                        <input type="password"  name="password" class="form-control" placeholder="Password"/>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>[[ $errors->first('password') ]]</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-info btn-block" >Log In</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                &copy; 2014 AppName
            </div>
            <div class="pull-right">
                <a href="#">About</a> |
                <a href="#">Privacy</a> |
                <a href="#">Contact Us</a>
            </div>
        </div>
    </div>



<!--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
@endsection


