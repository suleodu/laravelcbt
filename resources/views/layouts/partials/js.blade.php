<!-- START PLUGINS -->
<script type="text/javascript" src="[[asset("js/plugins/jquery/jquery.min.js")]]"></script>
<script type="text/javascript" src="[[asset("js/plugins/jquery/jquery-ui.min.js")]]"></script>
<script type="text/javascript" src="[[asset("js/plugins/bootstrap/bootstrap.min.js")]]"></script>        
<!-- END PLUGINS -->


<!-- THIS PAGE PLUGINS -->
<!-- START THIS PAGE PLUGINS-->        
<script type="text/javascript" src="[[asset("js/plugins/icheck/icheck.min.js")]]"></script>        
<script type="text/javascript" src="[[asset("js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js")]]"></script>
<script type="text/javascript" src="[[asset("js/plugins/scrolltotop/scrolltopcontrol.js")]]"></script>

<script type="text/javascript" src="[[asset("js/plugins/morris/raphael-min.js")]]"></script>
<script type="text/javascript" src="[[asset("js/plugins/morris/morris.min.js")]]"></script>       
<!--<script type="text/javascript" src="[[asset("js/plugins/rickshaw/d3.v3.js")]]"></script>
<script type="text/javascript" src="[[asset("js/plugins/rickshaw/rickshaw.min.js")]]"></script>-->
<script type="text/javascript" src="[[asset("js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")]]"></script>
<script type="text/javascript" src="[[asset("js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")]]"></script>                
<script type="text/javascript" src="[[asset("js/plugins/bootstrap/bootstrap-datepicker.js")]]"></script>                
<script type="text/javascript" src="[[asset("js/plugins/owl/owl.carousel.min.js")]]"></script>                 

<script type="text/javascript" src="[[asset("js/plugins/moment.min.js")]]"></script>
<script type="text/javascript" src="[[asset("js/plugins/daterangepicker/daterangepicker.js")]]"></script>
<!-- END THIS PAGE PLUGINS-->  

<!-- END PAGE PLUGINS -->         
<script type="text/javascript" src="[[asset("js/plugins.js")]]"></script>        
<script type="text/javascript" src="[[asset("js/actions.js")]]"></script>



<!-- START TEMPLATE -->
<!--<script type="text/javascript" src="[[asset("js/settings.js")]]"></script>-->

<script type="text/javascript" src="[[asset("js/plugins/notify.js")]]"></script> 

<!-- END TEMPLATE -->

<!--<script>
    $.notify("I'm over here !");
</script>-->

@if(Session::has("message"))
    <script type="text/javascript" > $.notify("<?= $message ?>")</script>
@endif



@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    <script type="text/javascript" > $.notify("<?= $error ?>", "'error'")</script>
    @endforeach
@endif


@if (Session::has("flash_message"))
    <script type="text/javascript" > $.notify("<?= session("flash_message")?>", "<?= session("status")?>")</script>
@endif

<script type="text/javascript" src="[[asset('js/demo_dashboard.js')]]"></script>
<script type="text/javascript" src="[[asset('js/angular/angular.js')]]"></script>

@yield('script');

