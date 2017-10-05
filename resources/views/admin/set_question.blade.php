
@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Set Question</h3>
                <div class="pull-right">
                    <a href="[[url('/admin/test/question')]]/[[$test_id]]"><span class="badge badge-success">[[$tot_quest]]</span> Question Added</a>
                </div>
            </div>
            <div class="panel-body panel-body-table">
                <form action="[[url('/admin/test/question')]]" role="form" class="form-horizontal" method="POST" >
                [[ csrf_field() ]]
                
                <div class="block">
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <h4>Instruction</h4>
                            <input type="text" name="instruction" class="form-control">
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="row-fluid">
                        <div class="col-md-12">
                            <h4>Question</h4>
                            <textarea name="question" class="summernote"></textarea>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="row-fluid">
                        <div class="col-md-6">
                            <h4>Option 1</h4>
                            <textarea name="option1" class="summernote"></textarea>
                        </div>
                        <div class="col-md-6">
                            <h4>Option 2</h4>
                            <textarea name="option2" class="summernote"></textarea>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="row-fluid">
                        <div class="col-md-6">
                            <h4>Option 3</h4>
                            <textarea name="option3" class="summernote"></textarea>
                        </div>
                        <div class="col-md-6">
                            <h4>Option 4</h4>
                            <textarea name="option4" class="summernote"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Correct Answer</label>
                    <div class="col-md-6 col-xs-12">                                                                                                                                                        
                        <select name="choice" class="form-control" required="">
                            <option value="">--Choose Answer --</option>
                            <option value="1">Option1</option>
                            <option value="2">Option2</option>
                            <option value="3">Option3</option>
                            <option value="4">Option4</option>
                        </select>                                                  
                    </div>
                </div>
                <p>&nbsp;</p>
                <div class="panel-footer">
                    <button class="btn btn-primary" type="submit">Save and Continue</button>
                </div>
                <input type="hidden" name="test_id" value="[[$test_id]]">
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript" src="[[asset('js/plugins/summernote/summernote.js')]]"></script>
<script type="text/javascript">
    // Define the `phonecatApp` module
    var cbt = angular.module('cbt', []);
    


    // Define the `PhoneListController` controller on the `phonecatApp` module
    cbt.controller('PageController', function ($scope) {
        $scope.current;
        $scope.setSelected = function (v) {
            $scope.test_type = v;
            $scope.current = v;
        }
    });
</script>

@endsection
