<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>iBuyTix</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('organizer.include.css')
    <style>
        .error{ color: red; }
        [v-cloak]{ display: none; }
        .active > a{ pointer-events:none; }
        .profile-event-image{
            width: 100px;
            height: 100px;
        }

        .img-wrap {
            position: relative;
            width: 100px;
            margin-left: 20px;
        }
        .img-close {
            position: absolute;
            top: 2px;
            right: 2px;
            z-index: 100;
            color: red;
            cursor: pointer;
        }
        .event-image{
            height:100px;
            width:100%;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('public/images/logo-2.png') }}" alt="LOGO">
                    </a>
                </div>
                <span class="nav-control">
                    <i class="fa fa-bars"></i>
                </span>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="header-search">
                    <form action="#">
                        <div class="form-group">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                <a href="{{ route('org-event-create') }}" class="btn btn-primary create-event-btn">Create New Event</a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                <div class="header-user-profile">
                    <div class="dropdown">
                        <div data-toggle="dropdown">
                            <p> Organizer :
                                <span>{{ auth()->user()->first_name }}</span>
                            </p>
                            <img src="{{ asset('public/assets/admin/dist/img/avatar_image.png') }}" alt="">
                        </div>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('org-my-profile') }}">My Profile</a>
                            <a class="dropdown-item" href="#">Notifications <span
                                        class="badge badge-danger">5</span></a>
                            <a class="dropdown-item" href="{{ route('org-live-events') }}">Event Created</a>
                            <a class="dropdown-item" href="{{ route('attendees-list') }}">Event Attended </a>
                            <a class="dropdown-item" href="{{ route('manage-accounts') }}">Manage Payment
                                Accounts</a>
                            <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /# header -->
<div class="menu">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <nav class="topbar-nav">
                    <ul class="metismenu" id="metismenu">
                        <li>
                            <a href="{{ route('org-home') }}">
                                <span class="fa fa-tachometer"></span> DASHBOARD
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <span class="fa fa-calendar-check-o"></span> Events
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('org-live-events') }}">Live</a></li>
                                <li><a href="{{ route('org-draft-events') }}">Draft</a></li>
                                <li><a href="{{ route('org-past-events') }}">Past</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{url('organizer/contact/list')}}">
                                <span class="fa fa-users"></span> Contact
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <span class="fa fa-envelope"></span> Messages
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="#">Inbox</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <span class="fa fa-line-chart"></span> Reports
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="{{ route('orders') }}">Order</a>
                                </li>
                                <li>
                                    <a href="{{ route('sales') }}">Sales</a>
                                </li>
                                <li><a href="{{ route('attendees-list') }}">Attendees</a></li>
                                <li><a href="{{ route('org-coupon-list') }}">Coupon</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <span class="fa fa-cog"></span> Settings
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{ url('organizer/my-profile') }}">Profile</a></li>
                                <li>
                                    <a href="{{ route('organizer-followers') }}">Followers</a>
                                </li>
                                <li>
                                    <a href="#">Check-In</a>
                                </li>
                                <li><a href="{{ route('promo-requests') }}">Promo Requests</a></li>
                                <li><a href="{{ route('sent-promo') }}">Sent Promo</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /# menu -->
@yield('before-content')
<div class="content-body">
    @yield('content')
</div>
{{-- footer --}}
<div class="footer text-center">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <p>&copy; Copyright 2019 iBuyTix. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>
{{-- /# footer --}}
@include('organizer.include.scripts')
@yield('after-script')
</body>
</html>