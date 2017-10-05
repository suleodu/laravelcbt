<!-- START X-NAVIGATION VERTICAL -->
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <!-- TOGGLE NAVIGATION -->
    <li class="xn-icon-button">
        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
    </li>
    @if(isset($active_ses))
    <li class="">
        <a href="#" class=""><span style="font-size: 20pt">[[$active_ses->sesname]]</span></a>
    </li>
    @endif
     
    <li class="xn-icon-button pull-right">
        <a href="[[url('/logout') ]]"><span class="fa fa-sign-out"></span></a>                        
    </li> 
    <li class="pull-right" ng-if="start_test" ng-cloak="">
        <a href="#"><span  id="worked" style="font-size: 20pt; color: green" >{{time1}}</span></a>                        
    </li>
    <!-- END TOGGLE NAVIGATION -->                    
</ul>
<!-- END X-NAVIGATION VERTICAL -->                     

<!-- START BREADCRUMB -->
<!--<ul class="breadcrumb">
    <li><a href="#">Link</a></li>                    
    <li class="active">Active</li>
</ul>-->
<!-- END BREADCRUMB -->  
