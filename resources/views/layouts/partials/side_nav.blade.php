<div class="page-sidebar page-sidebar-fixed scroll ">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="index.html">ATLANT123</a>
            <a href="#" class="x-navigation-control"></a>
        </li>
        @if(Auth::user()->isAdmin() == 'false')
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img src="[[asset('assets/images/users/avatar.jpg')]]" alt="John Doe"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="[[asset('assets/images/users/avatar.jpg')]]" alt="John Doe"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">[[Auth::user()->userid]]</div>
                    <div class="profile-data-name">[[Auth::user()->fname]] [[Auth::user()->lname]] [[Auth::user()->mname]]</div>
                </div>
            </div>                                                                        
        </li>
        <?php if(session()->has('test_image') && session('test_image') != nullOrEmptyString()) {?>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img src="<?= asset(session('test_image'))?>" alt="John Doe"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="<?= asset(session('test_image'))?>" alt="John Doe"/>
                </div>
<!--                <div class="profile-data">
                    <div class="profile-data-name">20090204001</div>
                    <div class="profile-data-title">Sule-odu Adedayo</div>
                    <div class="profile-data-name">Sule-odu Adedayo</div>
                </div>-->
            </div>                                                                        
        </li>
        <?php } ?>
        <li>
            <a href="index.html"><span class="fa fa-table"></span> <span class="xn-text">End Exam</span></a>
        </li> 
        @else
        <!--<li class="xn-title">Navigation</li>-->
        
        
        <li class="xn-openable">
            <a href="#"><span class="fa fa-file"></span> Settings </a>
            
            <ul>
                <li><a href="[[url('/admin/sessions')]]"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Session</span></a></li>
                <li><a href="[[url('/admin/centers')]]"><span class="fa fa-desktop"></span> <span class="xn-text">Exam Centers</span></a></li>
                <li><a href="[[url('/admin/courses')]]"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Courses</span></a></li>
                <li><a href="[[url('/admin/test_type')]]"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Test Type</span></a></li>
            </ul>
        </li>
        <li>
            <a href="[[url('/admin/users')]]"><span class="fa fa-desktop"></span> <span class="xn-text">Student</span></a>
        </li> 
        <li>
            <a href="[[url('/admin/assessments')]]"><span class="fa fa-desktop"></span> <span class="xn-text">Assessment</span></a>
        </li> 
        <li>
            <a href="[[url('/admin/report')]]"><span class="fa fa-table"></span> <span class="xn-text">Report</span></a>
        </li> 
        @endif
    </ul>
    <!-- END X-NAVIGATION -->
</div>
