@extends('layouts.main')

@section('content')

<div class="row-fluid">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Terms And Condition </h3>
            </div>
            
            <div class="panel-body" ng-cloak="">
                <h4>PLEASE READ THE FOLLOWING INSTRUCTIONS FOR THE E-EXAMINATION</h4>
                
                <p>
                    <b>Assessment Title :</b>  {{my_test.csid +' || '+ my_test.csname}} <br/>
                    <b>Test Title : </b> {{my_test.ttypname}} <br/>
                    <b>Number of questions :</b> {{my_test.noq}}<br/>
                    <b>Exam time length :</b> {{my_test.time}} <br/>
                    <b>Questions are random : </b> {{my_test.rand_question }}<br/>
                    <b>Image Capture is Enable :</b> {{my_test.image_capture}} <br/><br/>
                    <b><b><u>System Instructions</u></b></b><br/>
                    <div ng-bind-html="renderHTML(my_test.start_message)"></div>
                </p>
                
            </div>
            <form method="post" action="[[url('/student/sheet')]]">
                [[ csrf_field() ]]
                <div class="panel-footer">
                    <div class="pull-left">
                        <a href="[[url('/student')]]" class="btn btn-warning" >Cancel</a>
                    </div>
                    <input type="hidden" name="test_id" value="{{my_test.tid}}">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary" >Start Exam</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
<script type="text/javascript" src="[[asset('js/demo_dashboard.js')]]"></script>
@endsection

@section('script')
<script type="text/javascript">
    // Define the `phonecatApp` module
    var cbt = angular.module('cbt', []);
    var my_test = <?= json_encode($my_test)?>;
    
    cbt.controller('PageController', function ($scope,$sce) {
        $scope.my_test = my_test;
        
        $scope.current;
        $scope.setSelected = function (v) {
            $scope.current = v;
        };
        
        /**
        * Render 
        * 
        * @param {type} html_code
        * @return {unresolved}
        */
       $scope.renderHTML = function(html_code){
           var decoded = angular.element('<textarea />').html(html_code).text();
           return $sce.trustAsHtml(decoded);
            };
       });
</script>

@endsection
