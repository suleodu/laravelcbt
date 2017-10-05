@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Image Capture </h3>
            </div>
            <form method="post" action="[[url('/student/sheet')]]">
            [[ csrf_field() ]]
                <div class="panel-body">
                    <div class="alert alert-info">
                        You are required to take a facial 
                        capture of yourself before proceeding with this test 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="my_camera" style="width:320px; height:240px;"></div>
                            <p>&nbsp;</p>
                            <button type="button" ng-click="takeSnam()" class="btn btn-primary"><i class="fa fa-camera"></i> Take Snapshot</button>
                        </div>
                        <div class="col-md-6">
                            <div id="my_result"style="width:320px; height:240px;"></div>
                            <p>&nbsp;</p>
                            <div class="alert alert-warning">
                                Please be sure you capture the right image else you shall be logged out
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="pull-left">
                       <a href="[[url('/student')]]" class="btn btn-default"><i class="fa fa-backward"></i> Cancel</a> 
                    </div>
                    <input type="hidden" id="snaped_img" name="snaped_img">
                    <input type="hidden" name="test_id" value="<?= $test_id?>">
                    <div class="pull-right">
                        <button type="submit" ng-if="captured" class="btn btn-success"><i class="fa fa-upload"></i> Submit And proceed</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
<script type="text/javascript" src="{{asset('js/demo_dashboard.js')}}"></script>
@endsection

@section('script')
<script type="text/javascript" src="[[asset('webcamjs/webcam.js')]]"></script>

<script type="text/javascript">
    // Define the `phonecatApp` module
    var cbt = angular.module('cbt', []);

    cbt.controller('PageController', function ($scope) {
        $scope.captured = false;
        Webcam.attach( '#my_camera' );
        
        $scope.takeSnam = function(){
            Webcam.snap( function(data_uri) {
                document.getElementById('my_result').innerHTML = '<img src="'+data_uri+'"/>';
                document.getElementById('snaped_img').value = data_uri ;
                $scope.captured = true;
            } );
        };
    
        $scope.current;
        $scope.setSelected = function (v) {
            $scope.current = v;
        }
    });
</script>
@endsection