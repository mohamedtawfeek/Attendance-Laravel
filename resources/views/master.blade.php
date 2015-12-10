<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- BEGIN PLUGIN CSS -->
        <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <!-- END PLUGIN CSS -->
        <!-- BEGIN CORE CSS FRAMEWORK -->
        <link href="assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- END CORE CSS FRAMEWORK -->
        <!-- BEGIN CSS TEMPLATE -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
        @yield('css')
        <!-- END CSS TEMPLATE -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class="">
        <!-- BEGIN HEADER -->
        <div class="header navbar navbar-inverse "> 
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="navbar-inner">
                <div class="header-seperation"> 
                    <ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">	
                        <li class="dropdown"> <a id="main-menu-toggle" href="#main-menu"  class="" > <div class="iconset top-menu-toggle-white"></div> </a> </li>		 
                    </ul>
                    <!-- BEGIN LOGO -->	
                    <a href="/home"><img src="assets/img/logo.png" class="logo" alt=""  data-src="assets/img/logo.png" data-src-retina="assets/img/logo2x.png" width="106" height="21"/></a>
                    <!-- END LOGO --> 
                  
                </div>
                <!-- END RESPONSIVE MENU TOGGLER --> 
                <div class="header-quick-nav" > 
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="pull-left"> 
                        <ul class="nav quick-section">
                            <li class="quicklinks"> <a href="#" class="" id="layout-condensed-toggle" >
                                    <div class="iconset top-menu-toggle-dark"></div>
                                </a> </li>
                        </ul>
                </div>
                    <!-- END TOP NAVIGATION MENU -->

                </div> 
                <!-- END TOP NAVIGATION MENU --> 

            </div>
            <!-- END TOP NAVIGATION BAR --> 
        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container row-fluid">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar" id="main-menu"> 
                <!-- BEGIN MINI-PROFILE -->
                <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper"> 
                    <div class="user-info-wrapper">	
                
                        <div class="user-info">
                            <div class="greeting">Welcome</div>
                            <div class="username">@yield('name')</div>

                        </div>
                    </div>
                    <!-- END MINI-PROFILE -->

                    <!-- BEGIN SIDEBAR MENU -->	
                    <div class="clearfix"></div>
                    <!-- END SIDEBAR MENU --> 
                </div>
            </div>
            <a href="#" class="scrollup">Scroll</a>
            <div class="footer-widget">		

                <div class="pull-right">
                	
                    <a href="logout"><i class="fa fa-power-off"></i></a></div>
            </div>
            <!-- END SIDEBAR --> 
            <!-- BEGIN PAGE CONTAINER-->
            <div class="page-content"> 
  
                <div class="clearfix"></div>
                <div class="content">  
                    <div class="page-title">	
                        @yield('content')		
                    </div>
                </div>
            </div>
            
        </div>
        <!-- END CONTAINER --> 

        <!-- END CONTAINER -->
        <!-- BEGIN CORE JS FRAMEWORK--> 
        <script src="assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/breakpoints.js" type="text/javascript"></script> 
        <script src="assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
        <!-- END CORE JS FRAMEWORK --> 
        <!-- BEGIN PAGE LEVEL JS --> 
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
        @yield('js')
        <!-- END PAGE LEVEL PLUGINS --> 	

        <!-- BEGIN CORE TEMPLATE JS --> 
        <script src="assets/js/core.js" type="text/javascript"></script> 
        <script src="assets/js/chat.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS --> 
    </body>
</html>