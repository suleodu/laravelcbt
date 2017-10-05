<!DOCTYPE html>
<html lang="en" ng-app="cbt">
    <head>        
        <!-- META SECTION -->
        <title>CBT </title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @include('layouts.partials.head')
    </head>
    <body ng-controller="PageController">
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top-fixed">
            <!-- START PAGE SIDEBAR -->
            @include('layouts.partials.side_nav')
            <!-- END PAGE SIDEBAR -->

            <!-- PAGE CONTENT -->
            <div class="page-content ">
                
                @include('layouts.partials.top_nav')              

<!--                <div class="page-title">                    
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Page Title</h2>
                </div>                   -->

                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap" style="height: 100%;">
                    <!-- PAGE TITLE -->
<!--                    <div class="page-title">                    
                        <h2><span class="fa fa-arrow-circle-o-left"></span> Basic Tables</h2>
                    </div>-->
                    <!-- END PAGE TITLE -->  
                    @yield('content')  
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
           

        <!-- START SCRIPTS -->
        @include('layouts.partials.js')
       
        <!-- END SCRIPTS -->         
    </body>
</html>






