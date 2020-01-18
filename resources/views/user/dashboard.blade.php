@extends('user.include.app')

@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>My Orders</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" id="my-orders">
        <div class="row">
            <div class="col-xl-12">
                <!-- Nav tabs -->
                <div class="custom-tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab"
                               href="JavaScript:void(0)" @click.prevent="showUpcoming = false">Past Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="JavaScript:void(0)"
                               @click.prevent="showUpcoming = true">Upcoming</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="past-event-tab" v-show="!showUpcoming" v-cloak>
                            <div class="p-t-15">
                                <div class="table-wrapper table-responsive col-sm-12">
                                    <!--Table-->
                                    <table class="table table-hover mb-0" id="coupon_list_table">
                                        <!--Table head-->
                                        <thead>
                                        <tr>
                                            <th scope="col">Order Number</th>
                                            <th scope="col">Order Date</th>
                                            <th scope="col">Event Date</th>
                                            <th scope="col">Event(s)</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Gross</th>
                                            <th scope="col">Where?</th>
                                        </tr>
                                        </thead>
                                        <!--Table head-->
                                        <!--Table body-->
                                        <tbody>
                                        {{-- for loop here --}}
                                        <tr class="tr-dynamic-id" v-if="pastEvents.data"
                                            v-for="order in pastEvents.data"
                                            v-cloak>
                                            <td>
                                                <a href="#" data-toggle="modal"
                                                   data-target="#view_ticket" @click="showOrderTicket(order)">
                                                    @{{ order.barcode }}
                                                </a>
                                            </td>
                                            <td>@{{ order.created_at | orderCreatedAt }}</td>
                                            <td>
                                                @{{ order.event.start_date | orderCreatedAt }}
                                                @{{ order.event.start_time | eventStartTime }}
                                            </td>
                                            <td>
                                                <a :href="'{{ url('/event/') }}/' + order.event.event_url"
                                                   target="_blank">
                                                    @{{ order.event.event_title | readMore(15, '...') }}
                                                </a>
                                            </td>
                                            <td>@{{ order.total_quantity }}</td>
                                            <td>$@{{ order.total_amount }}</td>
                                            <td>Online</td>
                                        </tr>
                                        {{-- if no record found --}}
                                        <tr v-if="!pastEvents.data" class="text-center" v-cloak>
                                            <td colspan="8">No past events found</td>
                                        </tr>
                                        {{-- //for loop --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- show upcoming events --}}
                        <div id="upcoming-tab" v-show="showUpcoming" v-cloak>
                            <div class="p-t-15">
                                <div class="table-wrapper table-responsive col-sm-12">
                                    <!--Table-->
                                    <table class="table table-hover mb-0" id="coupon_list_table">
                                        <!--Table head-->
                                        <thead>
                                        <tr>
                                            <th scope="col">Order Number</th>
                                            <th scope="col">Order Date</th>
                                            <th scope="col">Event Date</th>
                                            <th scope="col">Event(s)</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Gross</th>
                                            <th scope="col">Where?</th>
                                        </tr>
                                        </thead>
                                        <!--Table head-->
                                        <!--Table body-->
                                        <tbody>
                                        {{-- for loop here --}}
                                        <tr class="tr-dynamic-id" v-if="upcoming.data"
                                            v-for="order in upcoming.data"
                                            v-cloak>
                                            <td>
                                                <a href="#" data-toggle="modal"
                                                   data-target="#view_ticket" @click="showOrderTicket(order)">
                                                    @{{ order.barcode }}</a>
                                            </td>
                                            <td>@{{ order.created_at | orderCreatedAt }}</td>
                                            <td>
                                                @{{ order.event.start_date | orderCreatedAt }}
                                                @{{ order.event.start_time | eventStartTime }}
                                            </td>
                                            <td>
                                                <a :href="'{{ url('/event/') }}/' + order.event.event_url"
                                                   target="_blank">
                                                    @{{ order.event.event_title | readMore(15, '...') }}
                                                </a>
                                            </td>
                                            <td>@{{ order.total_quantity }}</td>
                                            <td>$@{{ order.total_amount }}</td>
                                            <td>Online</td>
                                        </tr>
                                        {{-- if no record found --}}
                                        <tr v-if="!upcoming.data" class="text-center" v-cloak>
                                            <td colspan="8">No upcoming events found</td>
                                        </tr>
                                        {{-- //for loop --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- //show upcoming events --}}
                    </div>
                </div>
                <div>
                    <span v-if="showUpcoming">
                        <pagination2 :data="upcoming" @pagination-change-page="getUpcomingEvents"
                                     style="float: right; margin-top: 10px;"></pagination2>
                    </span>
                    <span v-if="!showUpcoming">
                        <pagination2 :data="pastEvents" @pagination-change-page="getPastEvents"
                                     style="float: right; margin-top: 10px;"></pagination2>
                    </span>
                </div>
            </div>
        </div>


        {{-- view ticket --}}
        <div class="modal fade creat-event" role="dialog" id="view_ticket" v-if="show_order" v-cloak>
            <div class="modal-dialog">
                Modal content
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" style="margin-top: 0;">Order Details</h2>
                        <button type="button" class="close" id="close_add_coupon" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <br><br>
                    <div class="modal-body">
                        <div class="setting-billing" v-if="show_order.event">
                            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                <tbody>
                                <tr>
                                    <td align="center">
                                        <table style="max-width: 800px; border:4px solid #d2d6df; margin: 40px 0;"
                                               cellspacing="0" cellpadding="0"
                                               width="100%" border="0">
                                            <tbody>
                                            <tr>
                                                <td colspan="2" valign="top"
                                                    style="padding: 0 10px 0 10px; border-bottom:4px solid #d2d6df;">
                                                    <label style="color: #ccc; font-size: 16px; font-weight: normal; text-align: left;">Event:</label>
                                                    <p style="line-height: 36px; text-align: right; font-family: 'Source Sans Pro',sans-serif;
                        color: #000; margin: 0px; font-weight: bold; font-size: 26px;">
                                                        @{{ show_order.event.event_title }}
                                                    </p>
                                                </td>
                                                <td valign="top" style="padding: 10px; border-left:4px solid #d2d6df;">
                                                    <div style="text-align: center; position: relative;top: 0px;">
                                                        <img style="max-width: 150px;"
                                                             src="{{ asset('/public/images/logo-2.jpg') }}"
                                                             alt="iBuyTix">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"
                                                    style="font-family: 'Source Sans Pro',sans-serif;padding: 0 10px 0 10px;border-right:4px solid #d2d6df;">
                                                    <label style="color: #ccc; font-size: 16px; font-weight: normal; text-align: left;">
                                                        Time:</label>
                                                    <p style="text-align: right; line-height: 26px; color: #000; margin: 0px;">
                                                        @{{ show_order.event.start_date | eventStartDate }}
                                                        <br>@{{ show_order.event.start_time | eventStartTime }} -
                                                        @{{ show_order.event.end_date | eventStartDate }}
                                                        <br>@{{ show_order.event.end_time | eventStartTime }}
                                                    </p>
                                                </td>
                                                <td valign="top"
                                                    style="padding: 0 10px 0 10px;font-family: 'Source Sans Pro',sans-serif;">
                                                    <label style="color: #ccc; font-size: 16px; font-weight: normal; text-align: left;">
                                                        Venue:</label>
                                                    <p style="text-align: right; line-height: 26px; color: #000; margin: 0px;">
                                                        @{{ show_order.event.address }}
                                                        @{{ show_order.event.address_2 }}
                                                        @{{ show_order.event.location }}
                                                    </p>
                                                </td>
                                                <td valign="bottom"
                                                    style="padding: 10px; border-left:4px solid #d2d6df;">
                                                    <div style="vertical-align: bottom;"><label
                                                                style="color: #ccc; font-size: 16px; font-weight: normal; text-align: left;">
                                                            Code:</label>
                                                        <p style="text-align: right; line-height: 26px; color: #000; margin: 0px;">
                                                            #@{{ show_order.id }}
                                                        </p></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" valign="top"
                                                    style="font-family: 'Source Sans Pro',sans-serif;padding: 0 10px 0 10px;border-top:4px solid #d2d6df;
                                                        border-bottom:4px solid #d2d6df;">
                                                    <label style="color: #ccc; font-size: 16px; font-weight: normal; text-align: left;">Order
                                                        Info:</label>
                                                    <p style="text-align: right;line-height: 26px; color: #000; margin: 0px;">
                                                        Order @{{ show_order.id }} Ordered By
                                                        @{{ show_order.name }} on
                                                        @{{ show_order.created_at | orderCreatedFull }}
                                                    </p>
                                                </td>
                                                <td align="center" rowspan="2" valign="middle"
                                                    style="padding: 5px;border-top:4px solid #d2d6df;border-left:4px solid #d2d6df;">
                                                    <img :src="'{{ asset('public/ticket/barcode/') }}/'
                                                        + show_order.barcode + '.png'"
                                                         alt="barcode"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" valign="top"
                                                    style="padding: 10px;font-family: 'Source Sans Pro',sans-serif; text-align: center">
                                                    <img :src="'{{ asset('public/ticket/barcode/c39') }}/'
                                                        + show_order.barcode + '.png'">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //view ticket --}}


    </div>
@endsection