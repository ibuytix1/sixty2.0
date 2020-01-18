@extends('organizer.include.app')

@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Live Events</h1>
                </div>
                <div class="col-7">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Live Events</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCX76RWTDMQxUEfW0xtiQmjVELZwBA-o6A&libraries=places"></script>
    <div class="container" id="live-events">
        <div class="row justify-content-between" v-if="!edit && !insight" v-cloak>
            <div class="col-xl-8">
                <div class="alert alert-warning text-center" v-cloak v-if="error.show">
                    <h4><i class="fa fa-warning"></i> @{{ error.message }}</h4>
                </div>
                <div class="row">
                    {{-- events loop --}}
                    <div class="col-lg-6" v-for="event in events.data" v-if="events.data" v-cloak>
                        <div class="card event-card">
                            <div class="card-header">
                                <div class="media">
                                    <img class="mr-3 img-fluid"
                                         src="{{ asset('public/assets/admin/dist/img/avatar_image.png') }}"
                                         alt="placeholder image">
                                    <div class="media-body">
                                        <h3 class="mt-0">@{{ event.r_e_l__event__organizer.first_name }} @{{
                                            event.r_e_l__event__organizer.last_name }}</h3>
                                        <p>@{{ event.event_date | eventCreatedDate }}</p>
                                    </div>
                                    <div class="dropdown custom-dropdown">
                                        <div data-toggle="dropdown">
                                            {{--<i class="fa fa-ellipsis-v"></i>--}}
                                            <i class="fa fa-navicon" style="font-size: 20px"></i>
                                            {{--<i class="fa fa-caret-square-o-down" style="font-size: 20px"></i>--}}
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                               href="#" @click.prevent="editEvent(event)">Edit</a>
                                            <a class="dropdown-item" href="#"
                                               @click.prevent="deleteEvent(event.id)">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="event-card-img">
                                <a :href="'{{ url('/event') }}/' + event.event_url" target="_blank">
                                    <img class="img-fluid event_view"
                                         :src="imageUrl + event.r_e_l__event__image[0].image_name"
                                         alt="placeholder image" v-if="event.r_e_l__event__image[0]" />
                                    <img class="img-fluid event_view"
                                         src="{{ asset('public/assets/images/events/event-main2.jpg') }}"
                                         alt="placeholder image" v-if="!event.r_e_l__event__image[0]" />
                                    <h4>@{{ event.event_title }}</h4>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <h5>Start Date</h5>
                                        <p>@{{ event.start_date | eventStartDate }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <h5>End Date</h5>
                                        <p>@{{ event.end_date | eventStartDate }}</p>
                                    </div>
                                    <div class="col-auto">
                                        <h5>Location</h5>
                                        <p>@{{ event.event_location }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li><a href="#"><i class="fa fa-money"></i>$20</a></li>
                                    <li><a href="#"><i class="fa fa-eye"></i>20</a></li>
                                    <li><a href="#"><i class="fa fa-cart-plus" aria-hidden="true"></i>50</a></li>
                                </ul>
                                <div class="pull-right">
                                    <a href="#" @click.prevent="showInsight(event)">
                                        <i class="fa fa-bar-chart"></i>Insight</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- // end events loop --}}
                </div>
                <div class="pagination">
                    <pagination :data="events" @pagination-change-page="getLiveEvents"
                                style="margin: 0 auto;"></pagination>
                </div>
            </div>
            <div class="col-xl-3 left-line">
                <div class="event-sideber m-l-15">
                    <div class="event-sideber-category">
                        <h4 class="text-center">Contact Attendees</h4>
                        <ul class="contact_attendees">
                            {{-- link compose.html --}}
                            <li><a href="#">Eminem in Delhi</a></li>
                            <li><a href="#">Rihanna in Mumbai</a></li>
                            <li><a href="#">Holi Celebration</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- edit event section --}}
        <div class="row justify-content-between" v-if="edit" v-cloak>
            <div class="col-xl-12">
                <h3><b>Basic Information</b></h3>
                <div class="setting-billing">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="alert alert-danger text-center" v-if="error.dev" v-cloak>
                                <i class="icon fa fa-close"></i>
                                {{--@{{ error.message }}--}}
                                <li v-for="message in error.message">
                                    <span v-for="index in message">@{{ index }}</span>
                                </li>
                            </div>
                            <div class="alert alert-success" v-cloak v-if="success.show">
                                <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                            </div>

                            <form action="#" enctype='multipart/form-data' @keydown.prevent.enter=""
                                  id="create-event-form">
                                <div class="clearfix"></div>
                                @include('organizer.events.edit')
                                <div class="text-center">
                                    <button class="btn btn-danger" @click.prevent="editLiveEvent">Update Event</button>
                                    <a href="#" class="btn btn-secondary" @click.prevent="cancelEdit" >Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //edit event section --}}

        {{-- event insight section --}}
        <div class="row justify-content-between" v-if="insight" v-cloak>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">@{{ event.event_title }}</h4>
                        <span v-html="event.event_description">
                            @{{ event.event_description }}
                        </span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="four-icon">
                                    <span class="fa fa-usd green-circle-icon"></span>
                                    <span class="pull-right" v-if="insights.basic">$ @{{ insights.basic.net_revenue }} <br>
                                        <span class="span-heading">net Revenue</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="four-icon">
                                    <span class="fa fa-bar-chart red-circle-icon"></span>
                                    <span class="pull-right" v-if="insights.basic">@{{ insights.basic.tix_sold }} <br>
                                        <span class="span-heading">Tix Sold</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="four-icon">
                                    <span class="fa fa-eye red-circle-icon"></span>
                                    <span class="pull-right">... <br>
                                        <span class="span-heading">Event Clicks</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="four-icon">
                                    <span class="fa fa-envelope red-circle-icon"></span>
                                    <span class="pull-right" v-if="insights.basic">@{{ insights.basic.contacts }}<br>
                                        <span class="span-heading">Contacts</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row three-circle">
                    <div class="col-sm-12">
                        <h4 class="card-title">Tix Sale by Type</h4>
                    </div>
                    <div class="col-sm-4" v-for="sale in insights.sales" v-if="insights.sales">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title m-b-15 text-center">@{{ sale.ticket_type }}</h4>
                                <div class="tickets text-center m-t-50">
                                    <div class="position-relative d-inline-block  m-b-50">
                                        <div id="circle">
                                            <canvas width="130" height="130"></canvas>
                                        </div>
                                        <div class="seat-content">
                                            <h2>@{{ sale.quantity }}</h2>
                                            <span>&nbsp;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row insight_table">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <h4>Recent Orders
                                    <span class="pull-right">
                                        <a href="#">
                                            <span class="fa fa-repeat"></span>
                                        </a> &nbsp;
                                        <a href="#">
                                            <span class="fa fa-times"></span>
                                        </a> &nbsp;
                                    </span>
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Number</th>
                                            <th>Payment</th>
                                            <th>Account</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="order in insights.orders" v-if="insights.orders">
                                            <td>#@{{ order.id }}</td>
                                            <td>@{{ order.purchaser_first_name }} @{{ order.purchaser_last_name }}</td>
                                            <td>@{{ order.purchaser_email }}</td>
                                            <td>@{{ order.purchaser_phone }}</td>
                                            <td>@{{ order.status }}</td>
                                            <td>@{{ order.total_amount }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 left-line">
                <div class="event-sideber m-l-15">
                    <div class="event-sideber-category">
                        <a href="#" class="btn btn-secondary" @click.prevent="cancelInsight" >Back</a>
                        <h4 class="text-center">Reports</h4>
                        <ul class="contact_attendees">
                            <li><a href="{{ route('sales') }}">Sales Report</a></li>
                            <li><a href="{{ route('attendees-list') }}">Event Attendees</a></li>
                            <li><a href="{{ route('org-contact-list') }}">Contacts</a></li>
                            <li><a href="{{ route('orders') }}">Discount</a></li>
                            <li><a href="#">Check-In</a></li>
                        </ul>
                        <br><br>
                        <h4 class="text-center">Add Attendee</h4>
                        <div class="form-group text-center">
                            <button type="button" data-toggle="modal"
                                    data-target="#add_attendee" class="form-contorl btn btn-danger">
                                <span class="fa fa-plus"></span> Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- add attendee to selected event, modal --}}
            <div class="modal fade" role="dialog" id="add_attendee">
                <div class="modal-dialog">
                    {{-- Modal content--}}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Attendee</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label"
                                       for="attendee_first_name">First Name*</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="attendee_first_name"
                                           placeholder="First Name" v-model="attendee.first_name" required>
                                    <p class="error" v-if="error.attendee.show" v-cloak>
                                        @{{ error.attendee.first_name }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="attendee_last_name">Last Name*</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="attendee_last_name"
                                           placeholder="Last Name" v-model="attendee.last_name" required>
                                    <p class="error" v-if="error.attendee.show" v-cloak>
                                        @{{ error.attendee.last_name }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="attendee_email">Email*</label>
                                <div class="col-lg-8">
                                    <input type="email" class="form-control" id="attendee_email"
                                           placeholder="Email" required v-model="attendee.email">
                                    <p class="error" v-if="error.attendee.show" v-cloak>
                                        @{{ error.attendee.email }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="attendee_amount">Amount*</label>
                                <div class="col-lg-8">
                                    <input type="number" class="form-control" id="attendee_amount"
                                           placeholder="USD" v-model="attendee.amount" required>
                                    <p class="error" v-if="error.attendee.show" v-cloak>
                                        @{{ error.attendee.amount }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="attendee_ticket_type"
                                >Ticket Type*</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="attendee_ticket_type"
                                            v-model="attendee.ticket_type">
                                        <option value="" disabled="">Select One</option>
                                        <option value="General Admission">General Admission</option>
                                        <option value="VIP">VIP</option>
                                        <option value="V.VIP">V.VIP</option>
                                    </select>
                                    <p class="error" v-if="error.attendee.show" v-cloak>
                                        @{{ error.attendee.ticket_type }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="attendee_quantity">Quantity*</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="attendee_quantity"
                                            v-model="attendee.quantity">
                                        <option value="" disabled>Select</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <p class="error" v-if="error.attendee.show" v-cloak>
                                        @{{ error.attendee.quantity }}</p>
                                </div>
                            </div>

                            <br>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="attendee_payment_type"
                                >Payment Type*</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="attendee_payment_type"
                                            v-model="attendee.payment_type">
                                        <option value="" disabled>Select One</option>
                                        <option value="Cash Payment">Cash Payment</option>
                                        <option value="Bank Deposit">Bank Deposit</option>
                                        <option value="Credit/Debit Card">Credit/Debit Card</option>
                                        <option value="Complimentary">Complimentary</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <p class="error" v-if="error.attendee.show" v-cloak>
                                        @{{ error.attendee.payment_type }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                    @click.prevent="addAttendee">Continue</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- //add attendee to selected event, modal --}}
        </div>
        {{-- //event insight section --}}
    </div>
@endsection
