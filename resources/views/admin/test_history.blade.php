
@extends('layouts.main')

@section('content')
<p>&nbsp;</p>
<div class="row-fluid">
    <div class="col-md-6 well">
        <div></div>
        <table class="table table-bordered">
            <tr>
                <td rowspan="4">
                    <img src="<?= asset('/')?>{{submitted[0].image_capture}}">
                </td>
                <td>Total Question</td>
                <td><?= $param['pass'] + $param['fail'] + $param['Unanswered']?></td>
            </tr>
            <tr>
                <td>Total Correct</td>
                <td><?= $param['pass'] ?> </td>
            </tr>
            <tr>
                <td>Total Incorrect</td>
                <td><?= $param['fail']?></td>
            </tr>
            <tr>
                <td>Total Correct</td>
                <td><?= $param['Unanswered']?></td>
            </tr>
        </table>
    </div>
</div>
<div class="row-fluid">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Submission Details</h3>
                <ul class="panel-controls">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div ng-repeat="sub in submitted" ng-cloak="">
                    <div class="row">
                        <div class="col-sm-1">{{$index+1}}</div>
                        <div class="col-md-9">
                            <table width='100%'>
                                <tr>
                                    <td colspan="2">
                                        <div ng-if="sub.instruction != ''">
                                            <span style="color: blue">{{sub.instruction}}</span>
                                            <hr/>
                                        </div>
                                        <h3 ><div ng-bind-html="renderHTML(sub.question)"></div></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td><h4><div ng-class="(sub.my_choice == '1')? 'badge': ''" ng-bind-html="renderHTML(sub.option1)"></div></h4></td>
                                    <td><h4><div ng-class="(sub.my_choice == '2')? 'badge': ''" ng-bind-html="renderHTML(sub.option2)"></div></h4></td>
                                </tr>
                                <tr>
                                    <td><h4><div ng-class="(sub.my_choice == '3')? 'badge': ''" ng-bind-html="renderHTML(sub.option3)"></div></h4></td>
                                    <td><h4><div ng-class="(sub.my_choice == '4')? 'badge': ''" ng-bind-html="renderHTML(sub.option4)"></div></h4></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <i class="fa fa-check fa-5x" ng-if="sub.answer == sub.my_choice" style="color: green"></i>
                            <i class="fa fa-times fa-5x" ng-if="sub.answer != sub.my_choice" style="color: red"></i>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <hr/>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="[[asset('js/angular/angular-sanitize.min.js')]]"></script>
<script type="text/javascript">
    // Define the `phonecatApp` module
    var cbt = angular.module('cbt', ['ngSanitize']);

    
    
    cbt.controller('PageController', function ($scope, $sce) {
        $scope.submitted = <?= json_encode($rs)?>;

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
