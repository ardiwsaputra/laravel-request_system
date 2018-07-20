<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if(!Auth::user())
                <a class="navbar-brand" href="{{ url('/') }}">SB Admin v2.0</a>
            @else
                <a class="navbar-brand" href="{{ route('home') }}">SB Admin v2.0</a>
            @endif
        </div>
        <!-- /.navbar-header -->
        <!--
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                           <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                           </li>
                           <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                           </li>
                           <li class="divider"></li>
                           <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                           </li>
                       </ul>
                    </li>
                </ul>
                 /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!-- Ini untuk Admin -->
                    <li>
                        @if(!Auth::user())
                            <a href="{{ url('/') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        @else
                            <a href="{{ route('home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        @endif
                    </li>
                    <li>
                    @if (!Auth::user())
                    <li>
                        <a href="#"><i class="fa fa-inbox fa-fw"></i> Request <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{action('RequestsController@index')}}"><i class="fa fa-list-alt fa-fw"></i> All Request </a>
                            </li>
                            <li>
                                <a href="{{action('RequestsController@create')}}"><i class="fa fa-plus-square fa-fw"></i> Add Request </a>
                            </li>
                        </ul>
                    </li>
                    @elseif(Auth::user()->role == 'admin')
                        <a href="#"><i class="fa fa-building fa-fw"></i> Department <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{route('department.index')}}"><i class="fa fa-list-alt fa-fw"></i> All Departments </a>
                            </li>
                            <li>
                                <a href="{{route('department.create')}}"><i class="fa fa-plus-square fa-fw"></i> Add Department </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i> User <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{action('UsersController@index')}}"><i class="fa fa-list-alt fa-fw"></i> All User </a>
                            </li>
                            <li>
                                <a href="{{action('UsersController@create')}}"><i class="fa fa-plus-square fa-fw"></i> Add User </a>
                            </li>
                        </ul>
                    </li>
                    @elseif(Auth::user()->role == 'operator')
                    <li>
                        <a href="#"><i class="fa fa-briefcase fa-fw"></i> Service <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{action('ServicesController@index')}}"><i class="fa fa-list-alt fa-fw"></i> All Services </a>
                            </li>
                            <li>
                                <a href="{{action('ServicesController@create')}}"><i class="fa fa-plus-square fa-fw"></i> Add Service </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i> Agent <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{action('UsersController@index')}}"><i class="fa fa-list-alt fa-fw"></i> All Agent </a>
                            </li>
                            <li>
                                <a href="{{action('UsersController@create')}}"><i class="fa fa-plus-square fa-fw"></i> Add Agent </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-inbox fa-fw"></i> Request <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{action('RequestsController@index')}}"><i class="fa fa-list-alt fa-fw"></i> All Request </a>
                            </li>
                        </ul>
                    </li>
                    @elseif(Auth::user()->role == 'agent')
                    <li>
                        <a href="#"><i class="fa fa-inbox fa-fw"></i> Request <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{action('RequestsController@index')}}"><i class="fa fa-list-alt fa-fw"></i> All Request </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::check())
                        <li>
                            <a href="{{route('logout')}}"><i class="fa fa-sign-out fa-fw"></i> Sign Out </a>
                        </li>
                    @else
                        <li>
                            <a href="{{route('login')}}"><i class="fa fa-sign-in fa-fw"></i> Sign In </a>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>
    @yield('content')
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('/vendor/metisMenu/metisMenu.min.js') }}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ asset('') }}/dist/js/sb-admin-2.js"></script>

</body>

</html>

