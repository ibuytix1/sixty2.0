<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ config('app.name') }}</title>
    <!-- Latest compiled and minified CSS -->
    @include('layouts.include.css')
    <style>
        .show-on-mobile-only {
            display: none;
        }
        .landing-page-all-events{
            font-size: 10px;
            color: #ff6600;
            padding: 10px 15px;
            background: none;
            text-transform: uppercase;
            font-family: 'Open Sans', sans-serif;
            border: 1px solid #ff6600;
            border-radius: 20px;
            font-weight: 700;
            display: inline-block;
            pointer-events: none;
            cursor: default;
        }
        /* Smartphone Portrait and Landscape */
        @media only screen
        and (min-device-width: 320px)
        and (max-device-width: 480px) {
            .show-on-mobile-only {
                display: block;
            }
            .hide-on-mobile {
                display: none !important;
            }
        }
    </style>
</head>

<body>
<header id="masthead" @if(Route::getCurrentRoute()->uri() == '/') class="site-header fix-header header-1" @endif>
    <div class="top-header top-header-bg">
        <div class="container">
            <div class="row">
                <div class="top-left">
                    <ul>
                        <li>
                            <a href="#">
                                <i class="fa fa-phone"></i>
                                +62274 889767
                            </a>
                        </li>
                        <li>
                            <a href="mailto:hello@myticket.com">
                                <i class="fa fa-envelope-o"></i>
                                hello@myticket.com
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="top-right">
                    <ul>
                        @if (auth()->check())
                            <li>
                                <a href="{{ route('home') }}">My Account</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}">Logout</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}">Sign In</a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}">Sign Up</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div @if(Route::getCurrentRoute()->uri() == '/') class="main-header"
         @else class="main-header main-header-bg" @endif>
        <div class="container">
            <div class="row">
                <div class="site-branding col-md-3">
                    <h1 class="site-title">
                        <a href="{{ route('welcome') }}" title="Home">
                            <img src="{{ asset('public/images/logo-2.png') }}" alt="logo"></a>
                    </h1>
                </div>

                <div class="col-md-9">
                    <nav id="site-navigation" class="navbar">
                        <div class="navbar-header">
                            {{--<div class="mobile-cart" ><a href="#">0</a></div>--}}
                            <button type="button" class="navbar-toggle offcanvas-toggle pull-right"
                                    data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-offcanvas navbar-offcanvas-touch navbar-offcanvas-right"
                             id="js-bootstrap-offcanvas">
                            <button type="button" class="offcanvas-toggle closecanvas"
                                    data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas">
                                <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                            </button>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="active"><a href="{{ url('/search') }}" id="browse-event-button">
                                        Browse Event</a></li>
                                <li><a href="#">Help</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li class="crete-event-btn hide-on-mobile">
                                    <a href="{{ route('event-create') }}">Create Event</a></li>
                            </ul>
                            <div class="show-on-mobile-only">
                                <ul class="nav navbar-nav navbar-right">
                                    @if (auth()->check())
                                        <li>
                                            <a href="{{ route('home') }}">My Account</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}">Logout</a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ route('login') }}">Sign In</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('login') }}">Sign Up</a>
                                        </li>
                                    @endif
                                    <li class="crete-event-btn">
                                        <a href="{{ route('event-create') }}">Create Event</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')

<footer id="colophon" class="site-footer">
    <div class="top-footer">
        <div class="container">
            <div class="row">

                <div class="col-md-8">
                    <a href="{{ route('welcome') }}"><img src="{{ asset('public/images/logo-2.png') }}" alt="logo"></a>
                </div>
                <div class="col-md-4">

                    <p>&copy; 2016 MYTICKET.COM. ALL RIGHTS RESEVED</p>
                </div>
            </div>

        </div>
    </div>
    <div class="main-footer">
        <div class="container">
            <div class="row">
                <div class="footer-1 col-md-9">
                    <div class="about clearfix">
                        <h3>About</h3>
                        <ul>
                            <li><a href="#">Our Company</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Advertising</a></li>
                            <li><a href="#">Press Room</a></li>
                            <li><a href="#">Trademarks</a></li>
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="support clearfix">
                        <h3>Support and Contact</h3>
                        <ul>
                            <li><a href="#">Customer Support Contacts</a></li>
                            <li><a href="#">Feedback</a></li>
                            <li><a href="#">Help</a></li>
                            <li><a href="#">Sitemap</a></li>
                        </ul>
                    </div>
                    <div class="social clearfix">
                        <h3>Stay Connected</h3>
                        <ul>
                            <li class="facebook">
                                <a href="#">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                    Facebook
                                </a>
                            </li>
                            <li class="twitter">
                                <a href="#">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                    Twitter
                                </a>
                            </li>
                            <li class="linkedin">
                                <a href="#">
                                    <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                                    LinkedIn
                                </a>
                            </li>
                            <li class="google">
                                <a href="#">
                                    <i class="fa fa-google-plus-square" aria-hidden="true"></i>
                                    Google+
                                </a>
                            </li>
                            <li class="rss">
                                <a href="#">
                                    <i class="fa fa-rss-square" aria-hidden="true"></i>
                                    RSS
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="footer-2 col-md-3">
                    <div class="footer-dashboard">
                        <h3>MyTicket Dashboard</h3>
                        <ul>
                            <li><a href="#">Professional</a></li>
                            <li><a href="#">Subscriber Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@include('layouts.include.scripts')
<script>
    $("#browse-event-button").on('click', function (e) {
        e.preventDefault();
        localStorage.setItem('category_id', '');
        localStorage.setItem('search_event', '');
        window.location = weburl + 'search';
    });
</script>
@yield('after-script')
</body>
</html>