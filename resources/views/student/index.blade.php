@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">My Registered Assessments</h3>
            </div>
            <div class="panel-body">
                <div ng-if="active_tests.length > 0">
                    <h4>You are allowed to participate in the following tests. Please Click on a tests to continue:</h4>
                    <form method="post" action="[[url('/student/test_instruction')]]">
                        [[ csrf_field() ]]
                        <div class="list-group border-bottom" ng-cloak="">
                            <button ng-repeat="tst in active_tests" class="list-group-item btn  btn-block" ng-class="(tst.response_status == 'end_test')? 'btn-success' : 'btn-primary'" type="submit" name="test" value="{{tst.tid}}" ng-disabled="tst.status == 'inactive'">
                               <i class="fa fa-hand-o-right"></i> {{tst.sesname +' || '+ tst.csid +' - '+ tst.csname + ' || '+ tst.ttypname + ''}}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="alert alert-warning" ng-if="active_tests.length == 0">
                    There are NO active Assessment for you at the moment
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
<script type="text/javascript" src="{{asset('js/demo_dashboard.js')}}"></script>
@endsection

@section('script')
<script type="text/javascript">
    // Define the `phonecatApp` module
    var cbt = angular.module('cbt', []);

    var active_tests = <?= $active_tests ;?>;
    
    
    
    cbt.controller('PageController', function ($scope) {
        $scope.active_tests = active_tests;
        
        
        $scope.current;
        $scope.setSelected = function (v) {
            $scope.current = v;
        }
    });
</script>
@endsection
