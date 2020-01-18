@extends('organizer.include.app')

@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Order Details </h1>
                </div>
                <div class="col-7">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('org-home') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" id="orders-list">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-sm-4 space-bottom-15">
                        <div class="input-group custom-search">
                            <input type="text" class="form-control" placeholder="Search order by order #"
                                   v-model="searchOrder">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <div class="col-sm-2 space-bottom-15">
                        <input placeholder="Date From" class="textbox-n form-control" type="text"
                               id="order_from_date">
                    </div>
                    <div class="col-sm-2 space-bottom-15">
                        <input placeholder="Date To" class="textbox-n form-control" type="text"
                               id="order_to_date">
                    </div>
                </div>
                <br>
                <div class="table-wrapper table-responsive col-sm-12">
                    <!--Table-->
                    <table class="table table-hover mb-0">
                        <thead class="">
                        <tr>
                            <th scope="col">Order #</th>
                            <th scope="col">Ticket Buyer</th>
                            <th scope="col">Date</th>
                            <th scope="col">Type</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Coupon</th>
                            <th scope="col">Fees</th>
                            <th scope="col">Total</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="orders.data" v-for="order in orders.data" v-cloak>
                            <th scope="row"><a href="JavaScript:void(0)">@{{ order.id }}</a></th>
                            <td>@{{ order.purchaser_first_name }} @{{ order.purchaser_last_name }}</td>
                            <td>@{{ order.created_at | eventCreatedDate }}</td>
                            <td>
                                <span v-for="(ticket, index) in order.order_tickets">
                                    @{{ ticket.ticket_type }}
                                    @{{ ticket.length }}
                                    <span v-if="index+1 < order.order_tickets.length">, </span>
                                </span>
                            </td>
                            <td>@{{ order.purchaser_email }}</td>
                            <td>
                                <span v-if="order.coupon">
                                    @{{ order.coupon.amount }}
                                    <span v-if="order.coupon.type == '%'">%</span>
                                    <span v-if="order.coupon.type == 'amt'">$</span>
                                </span>
                                <span v-if="!order.coupon">None</span>
                            </td>
                            <td><a href="JavaScript:void(0)">$2.45 (static for now)</a></td>
                            <td><a href="JavaScript:void(0)">$ @{{ order.total_amount }}</a></td>
                            <td>@{{ order.status }}</td>
                            <td>
                                <button type="button" data-toggle="modal" data-target="#details"
                                        class="btn btn-sm btn-danger" @click="singleOrder(order)">Details
                                </button>
                            </td>
                        </tr>
                        <tr v-if="orders.code === 0" class="text-center">
                            <td colspan="9">@{{ orders.message }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <pagination :data="orders" @pagination-change-page="getOrders"
                            style="float: right; margin-top: 10px;"></pagination>
            </div>
            {{--<div class="col-sm-12 text-center">
                <button type="button" class="btn btn-danger">Download CSV</button>
            </div>--}}
        </div>


        <!-- Modal -->
        <div id="details" class="modal fade" role="dialog">
            <div class="modal-dialog" style="max-width: 1000px;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Order Information</h4>
                    </div>
                    <div class="modal-body order_detail_model">
                        <div class="row">
                            <div class="col-md-6 order-details-left">
                                <p class="m-t-15 m-b-5">Barcode:<span class="pull-right">@{{ order.barcode }}</span></p>
                                <p class="m-t-15 m-b-5">Date of Purchase:
                                    <span class="pull-right">@{{ order.created_at | eventCreatedDate }}</span>
                                </p>
                                <p class="m-t-15 m-b-5">Buyers Name:
                                    <span class="pull-right">@{{ order.purchaser_first_name }} @{{ order.purchaser_last_name }}</span>
                                </p>
                                <p class="m-t-15 m-b-5">Email Address:<span class="pull-right">@{{ order.purchaser_email }}</span></p>
                                <p class="m-t-15 m-b-5">Buyer Address:
                                    <span class="pull-right">@{{ order.billing_address }}</span><br>
                                    <span class="pull-right">@{{ order.billing_address_2 }}</span>
                                    <br v-if="order.billing_address_2">
                                </p>
                                <p class="m-t-15 m-b 5">
                                    Buyer Country:
                                    <span class="pull-right">@{{ order.billing_country }}</span><br>
                                </p>
                                <p class="m-t-15 m-b 5">
                                    Buyer State:
                                    <span class="pull-right">@{{ order.billing_state }}</span><br>
                                </p>
                                <p class="m-t-15 m-b 5">
                                    Buyer City:
                                    <span class="pull-right">@{{ order.billing_city }}</span><br>
                                </p>
                                <p class="m-t-15 m-b 5">
                                    Buyer Zip code:
                                    <span class="pull-right">@{{ order.billing_zip }}</span><br>
                                </p>
                                <p class="m-t-15 m-b-5">Coupon Used:
                                    <span v-if="order.coupon" class="pull-right">
                                    @{{ order.coupon.amount }}
                                    <span v-if="order.coupon.type == '%'" class="pull-right">%</span>
                                    <span v-if="order.coupon.type == 'amt'" class="pull-right">$</span>
                                </span>
                                    <span class="pull-right" v-if="!order.coupon">None</span>
                                </p>
                                {{--<p class="m-t-15 m-b-5">Refunds:<span class="pull-right">No</span></p>--}}
                            </div>
                            <div class="col-md-6 order-details-right">
                                <div v-for="(ticket, index) in order.order_tickets">
                                    <hr v-if="index == 0" style="margin-top: 0"/>
                                    <hr v-if="index > 0"/>
                                    <p class="m-t-15 m-b-5"><strong>Attendees @{{ ticket.event_type }} Ticket: </strong></p>
                                    <hr/>
                                    <p class="m-t-15 m-b-5">Ticket Type:
                                        <span class="pull-right">@{{ ticket.ticket_type }} $@{{ ticket.price }}</span>
                                    </p>
                                    <p class="m-t-15 m-b-5">Quantity:<span class="pull-right">@{{ ticket.quantity }}</span></p>
                                    <p class="m-t-15 m-b-5">Total:
                                        <span class="pull-right">$@{{ ticket.total_price }}</span>
                                    </p>
                                    <div class="m-t-15 m-b-5">Attendees:
                                        <table style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>first name</th>
                                                <th>last name</th>
                                                <th>email name</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(attendee, index) in ticket.attendees"
                                                v-if="ticket.attendees">
                                                <td>@{{ attendee.first_name }}</td>
                                                <td>@{{ attendee.last_name }}</td>
                                                <td>@{{ attendee.email }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger">Refund</button>
                        <button type="button" class="btn btn-danger">View Receipt</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection