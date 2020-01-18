
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>iBuyTix</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Common JS -->
    <script src="../assets/plugins/common/common.min.js"></script>
    <script src="js/scripts.js"></script>


    <script src="../assets/plugins/circle-progress/circle-progress.min.js"></script>

    <!-- Morris Chart -->
    <script src="../assets/plugins/chartist/js/chartist.min.js"></script>
    <script src="../assets/plugins/chartist/js/chartist-plugin-tooltip.min.js"></script>
    <script src="../main/js/dashboard.js"></script>
    <script src="../main/js/reports.js"></script>
    <link rel="stylesheet" href="../assets/plugins/chartist/css/chartist.min.css">



      
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

   

</head>

<body>

    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="logo">
                        <a href="index.html"><img src="../assets/images/PHOTO-2018-12-14-14-47-11.jpg" alt=""></a>
                    </div>

                    <span class="nav-control">
                        <i class="fa fa-bars"></i>
                    </span>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <div class="header-search">
                        <form action="#">
                            <div class="form-group">
                                <i class="icofont icofont-search"></i>
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <a href="#" class="btn btn-primary create-event-btn" data-toggle="modal" data-target="#creat-event">Create New Event</a>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="header-user-profile">
                        <div class="dropdown">
                            <div data-toggle="dropdown">
                                <p> Revenue :
                                    <span>$2500.00</span></p>
                                <img src="../assets/images/thumb/1.png" alt="">
                            </div>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">My Profile</a>
                                <a class="dropdown-item" href="#">Notifications <span class="badge badge-danger">5</span></a>
                                <a class="dropdown-item" href="#">Event Created</a>
                                <a class="dropdown-item" href="#">Event Attended </a>
                                <a class="dropdown-item" href="#">Elements</a>
                                <a class="dropdown-item" href="#">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="menu">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <nav class="topbar-nav">
                        <ul class="metismenu" id="metismenu">
                            <li>
                                <a href="index.html">
                                    <span class="fa fa-tachometer"></span> DASHBOARD
                                </a>
                            </li>
                            <li>
                                <a class="has-arrow" href="#" aria-expanded="false">
                                    <span class="fa fa-calendar-check-o"></span> Events
                                </a>
                                <ul aria-expanded="false">
                                    <li>
                                        <a href="events-active.html">Live</a>
                                    </li>
                                    <li>
                                        <a href="events-drafts.html">Draft</a>
                                    </li>
                                    <li>
                                        <a href="my-events.html">Past</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="contact-by-event.html">
                                    <span class="fa fa-users"></span> Contacts
                                </a>
                            </li>
                            <li>
                                <a class="" href="message.html" aria-expanded="false">
                                    <span class="fa fa-envelope"></span> Messages
                                </a>
                                
                            </li>
                            <!--<li>
                                <a href="calender.html">
                                    <span class="fa fa-calendar"></span> Calender
                                </a>
                            </li> -->
                            
                            <li>
                                <a class="has-arrow" href="#" aria-expanded="false">
                                    <span class="fa fa-line-chart"></span> Reports
                                </a>
                                <ul aria-expanded="false">
                                    <li>
                                        <a href="order-details2.html">Order</a>
                                    </li>
                                     <li>
                                        <a href="sales.html">Sales</a>
                                    </li>
                                    <li>
                                        <a href="attendee.html">Attendees</a>
                                    </li>
                                    <li>
                                        <a href="coupon.html">Coupon</a>
                                    </li>
                                    
                                </ul>
                            </li>

                            <li>
                                   <a href="payout-page.php">
                                   	<span class="fa fa-money"></span>Payout
                                    </a>
                            </li>
                            <li>
                                <a class="has-arrow" href="#" aria-expanded="false">
                                    <span class="fa fa-cog"></span> Settings
                                </a>
                                <ul aria-expanded="false">
                                    <li>
                                        <a href="profile.html">Profile</a>
                                    </li>
                                    
                                    
                                    <li>
                                        <a href="followers.html">Followers</a>
                                    </li>
                                    <li>
                                        <a href="profile-settings.html">Profile Settings</a>
                                    </li>
                                    <li>
                                        <a href="check-in.html">Check-In</a>
                                    </li>
                                    <li>
                                        <a href="">Integrations</a>
                                    </li>
                                    <li>
                                        <a href="">Private API</a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>