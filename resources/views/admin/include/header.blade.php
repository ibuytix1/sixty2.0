<?php $adminURL = config('constants.ADMIN_URL');?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>DeCipher - Event Admin Dashboard</title>
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('public/assets/admin/images/favicon.png')}}">
        <script src="{{URL::asset('public/assets/admin/vendor/jquery/jquery.min.js')}}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7Zmtv_DWTsyAao9OOzH6lhy1VbqnD_5o&libraries=places" type="text/javascript"></script>
        @include('admin.include.css')
    </head>
    <body>
        <!--*******************
            Preloader start
        ********************-->
        <div id="preloader">
        	<div class="spinner">
        		<div class="spinner-a"></div>
        		<div class="spinner-b"></div>
    		</div>
		</div>
        <!--*******************
            Preloader end
        ********************-->
        
        <!--**********************************
        Main wrapper start
        ***********************************-->
        <div id="main-wrapper">
    
            <!--**********************************
                Nav header start
            ***********************************-->
            <div class="nav-header">
                <a href="{{ url($adminURL.'dashboard')}}" class="brand-logo">
                    <span class="logo-abbr">D</span>
                    <span class="logo-compact">{{Session::get('user_data')['full_name']}}</span>
                    <span class="brand-title">{{Session::get('user_data')['full_name']}}</span>
                </a>
    
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
            </div>
            <!--**********************************
                Nav header end
            ***********************************-->
    
            <!--**********************************
                Header start
            ***********************************-->
            <div class="header"> 
                <div class="header-content">
                    <nav class="navbar navbar-expand">
                        <div class="header-left">
                            <div class="nav-item dropdown search_bar">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-magnify"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <form class="form-inline">
                                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse justify-content-end">
                            
                            <ul class="navbar-nav header-right">
                                <li class="nav-item border-0 d-none">
                                    <a class="btn btn-secondary create-event-btn" href="#" target="_blank">Create Event</a>
                                </li>
                                <li class="nav-item dropdown notification_dropdown d-none">
                                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-bell"></i>
                                        <span class="badge badge-primary">3</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-header">
                                            <h5 class="notification_title">Notifications</h5>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li class="media dropdown-item">
                                                <span class="text-primary"><i class="mdi mdi-chart-areaspline mr-3"></i></span>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <div class="d-flex justify-content-between">
                                                            <h5>New order has been received</h5>
                                                        </div>
                                                        <p class="m-0">2 hours ago</p>
                                                    </a>
                                                    <i class="fa fa-angle-right"></i>
                                                </div>
                                            </li>
                                            <li class="media dropdown-item">
                                                <span class="text-success"><i class="mdi mdi-chart-pie mr-3"></i></span>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <div class="d-flex justify-content-between">
                                                            <h5>New customer is registered</h5>
                                                        </div>
                                                        <p class="m-0">3 hours ago</p>
                                                    </a>
                                                    <i class="fa fa-angle-right"></i>
                                                </div>
                                            </li>
                                            <li class="media dropdown-item">
                                                <span class="text-warning"><i class="mdi mdi-file-document mr-3"></i></span>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <div class="d-flex justify-content-between">
                                                            <h5>New file has been uploaded</h5>
                                                        </div>
                                                        <p class="m-0">3 hours ago</p>
                                                    </a>
                                                    <i class="fa fa-angle-right"></i>
                                                </div>
                                            </li>
                                        </ul>
                                        <a class="all-notification" href="#">All Notifications</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown header-profile">
                                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{URL::asset('public/assets/admin/dist/img/avatar5.png')}}" alt="">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-profile-header">
                                            <img src="{{URL::asset('public/assets/admin/dist/img/avatar5.png')}}" alt="">
                                            <span class="avatar-name ml-2">{{Session::get('user_data')['full_name']}}</span>
                                        </div>
                                        <a href="#" class="dropdown-item">
                                            <i class="mdi mdi-account"></i>
                                            <span>Profile</span>
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            <i class="mdi mdi-ticket"></i>
                                            <span>Create Ticket</span>
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            <i class="mdi mdi-calendar-check"></i>
                                            <span>Calendar</span>
                                        </a>
                                        <a href="{{url($adminURL.'changePassword') }}" class="dropdown-item">
                                            <i class="mdi mdi-email"></i>
                                            <span>Change Password</span>
                                        </a>
                                        <a href="{{url($adminURL.'logout') }}" class="dropdown-item">
                                            <i class="mdi mdi-power"></i>
                                            <span>Logout</span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!--**********************************
                Header end 
            ***********************************-->
            @include('admin.include.sidebar')