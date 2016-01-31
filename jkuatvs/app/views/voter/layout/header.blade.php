<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>JKUAT VOTING SYSTEM | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        {{HTML::style('css/bootstrap.min.css')}}
        <!-- font Awesome -->
        {{HTML::style('css/font-awesome.min.css')}}
        <!-- Ionicons -->
        {{HTML::style('css/ionicons.min.css')}}
        <!-- Morris chart -->
        {{HTML::style('css/morris/morris.css')}}
        <!-- jvectormap -->
        {{HTML::style('css/jvectormap/jquery-jvectormap-1.2.2.css')}}
        <!-- Date Picker -->
        {{HTML::style('css/datepicker/datepicker3.css')}}
        <!-- Daterange picker -->
        {{HTML::style('css/daterangepicker/daterangepicker-bs3.css')}}
        <!-- bootstrap wysihtml5 - text editor -->
        {{HTML::style('css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}
        <!-- Theme style -->
        {{HTML::style('css/AdminLTE.css')}}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                JKUAT-VS
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
               
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/logo-jkuat.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, Francis</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="{{URL::route('voter-home-get')}}">
                                <i class="fa fa-dashboard"></i> <span>Voter Home</span>
                            </a>
                        </li>
                   		
                   		<li class="active">
                            <a href="{{URL::route('voter-guide-get')}}">
                                <i class="glyphicon glyphicon-info-sign"></i> <span>Voters' Guide</span>
                            </a>
                        </li>
                   
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Elections</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{URL::route('voter-vote-get')}}"><i class="fa fa-angle-double-right"></i>Vote</a></li>
                                <li><a href="{{URL::route('voter-results-get')}}"><i class="fa fa-angle-double-right"></i> View Results</a></li>
                            </ul>
                        </li>
                         <li class="active">
                            <a href="{{URL::route('user-logout')}}">
                                <i class="glyphicon glyphicon-log-out"></i> <span>Logout</span>
                            </a>
                        </li>   
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>