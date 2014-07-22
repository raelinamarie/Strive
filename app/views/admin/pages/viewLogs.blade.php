<html>
<head>
    <title>Manage Users</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- PACE LOAD BAR PLUGIN - This creates the subtle load bar effect at the top of the page. -->
    <link media="all" type="text/css" rel="stylesheet" href="http://strive.dev/assets/flex/css/plugins/pace/pace.css">
    <script src="http://strive.dev/assets/flex/js/plugins/pace/pace.js"></script>

    <!-- GLOBAL STYLES - Include these on every page. -->
    <link media="all" type="text/css" rel="stylesheet" href="http://strive.dev/assets/flex/css/plugins/bootstrap/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link media="all" type="text/css" rel="stylesheet" href="http://strive.dev/assets/flex/icons/font-awesome/css/font-awesome.min.css">

    <!-- PAGE LEVEL PLUGIN STYLES -->

    <!-- THEME STYLES - Include these on every page. -->
    <link media="all" type="text/css" rel="stylesheet" href="http://strive.dev/assets/flex/css/style.css">
    <link media="all" type="text/css" rel="stylesheet" href="http://strive.dev/assets/flex/css/plugins.css">


    <!--[if lt IE 9]>
    <script src="http://strive.dev/assets/flex/js/html5shiv.js"></script>
    <script src="http://strive.dev/assets/flex/js/respond.min.js"></script>
    <![endif]-->

    <link media="all" type="text/css" rel="stylesheet" href="http://strive.dev/assets/flex/css/custom.css">
    <style>
        #flot_chart_tooltip{
            position: absolute;
            display: none;
            border: 1px solid #ddd;
            padding: 2px;
            background-color: #eee;
            opacity: 0.80;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar-top" role="navigation"  style = "height: 60px;max-height: 60px">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse">
                <i class="fa fa-bars"></i> Menu
            </button>
            <div class="navbar-brand">
                <a href="/admin">
                    <img src="/assets/flex/img/logo.png" class="img-responsive" alt="" style="">
                </a>
            </div>
        </div>
        <div class="nav-top">
            <ul class="nav navbar-left">
                <li class="tooltip-sidebar-toggle">
                    <a href="#" id="sidebar-toggle" data-toggle="tooltip" data-placement="right" title="Sidebar Toggle">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>    </nav>
    <nav class="navbar-side" role="navigation" style="top:60px;">
        <div class="navbar-collapse sidebar-collapse collapse">
            <ul id="side" class="nav navbar-nav side-nav">
                <li>
                    <a href="/admin">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/admin/users">
                        <i class="fa fa-group"></i> Users
                    </a>
                </li>
                <li>
                    <a href="/admin/jobs">
                        <i class="fa fa-money"></i> Jobs
                    </a>
                </li>
                <!--
                <li class="panel">
                    <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#users">
                        <i class="fa fa-group"></i> Users <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="collapse nav" id="users">
                        <li>
                            <a href="/admin/users/">
                                <i class="fa fa-angle-double-right"></i> Overview
                            </a>
                        </li>
                        <li>
                            <a href="/admin/users/search">
                                <i class="fa fa-angle-double-right"></i> Search
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="panel">
                    <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#jobs">
                        <i class="fa fa-money"></i> Jobs <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="collapse nav" id="jobs">
                        <li>
                            <a href="/admin/jobs/">
                                <i class="fa fa-angle-double-right"></i> Overview
                            </a>
                        </li>
                        <li>
                            <a href="/admin/jobs/search">
                                <i class="fa fa-angle-double-right"></i> Search
                            </a>
                        </li>
                    </ul>
                </li>-->
                <li>
                    <a href="/admin/skills">
                        <i class="fa fa-flask"></i> Skills & Categories
                    </a>
                </li>
            </ul>
        </div>    </nav>
    <div id="page-wrapper">
        <div class="page-content">

            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title">
                        <h1>Manage Users                <small>
                            </small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
                            <li class="pull-right">

                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.col-lg-12 -->

            </div>
            <div class = 'row'>
                <div class = 'col-lg-4'>
                </div>
            </div>
            <div class = 'row'>
                <div class="portlet portlet-orange">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Error Log</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Level</th>
                                        <th>Message</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($errors as $error)
                                        <tr>
                                            <td>{{$error->id}}</td>
                                            <td>{{$error->level}}</td>
                                            <td>{{substr($error->message,0,1000)}}</td>
                                            <td>{{$error->created_at}}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class = 'row'>
                <div class="portlet portlet-orange">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>Access Log</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Action</th>
                                    <th>URI</th>
                                    <th>Method</th>
                                    <th>User ID</th>
                                    <th>Session ID</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($actions as $action)
                                        <tr>
                                            <td>{{$action->id}}</td>
                                            <td>{{$action->action}}</td>
                                            <td>{{$action->uri}}</td>
                                            <td>{{$action->method}}</td>
                                            <td>{{$action->user_id}}</td>
                                            <td>{{$action->session}}</td>
                                            <td>{{$action->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- GLOBAL SCRIPTS -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://strive.dev/assets/flex/js/plugins/bootstrap/bootstrap.min.js"></script>
<script src="http://strive.dev/assets/flex/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="http://strive.dev/assets/flex/js/plugins/popupoverlay/jquery.popupoverlay.js"></script>
<script src="http://strive.dev/assets/flex/js/plugins/popupoverlay/defaults.js"></script>
<!-- Logout Notification Box -->
<div id="logout">
    <div class="logout-message">
        <img class="img-circle img-logout" src="img/profile-pic.jpg" alt="">
        <h3>
            <i class="fa fa-sign-out text-green"></i> Ready to go?
        </h3>
        <p>Select "Logout" below if you are ready<br> to end your current session.</p>
        <ul class="list-inline">
            <li>
                <a href="login.html" class="btn btn-green">
                    <strong>Logout</strong>
                </a>
            </li>
            <li>
                <button class="logout_close btn btn-green">Cancel</button>
            </li>
        </ul>
    </div>
</div>
<!-- /#logout -->
<!-- Logout Notification jQuery -->
<script src="http://strive.dev/assets/flex/js/plugins/popupoverlay/logout.js"></script>
<!-- HISRC Retina Images -->
<script src="http://strive.dev/assets/flex/js/plugins/hisrc/hisrc.js"></script>

<!-- PAGE LEVEL PLUGIN SCRIPTS -->

<!-- THEME SCRIPTS -->
<script src="http://strive.dev/assets/flex/js/flex.js"></script>
</body>
</html>