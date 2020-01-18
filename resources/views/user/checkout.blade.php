@extends('layouts.welcome-app')
@section('content')
    <script src="https://www.paypal.com/sdk/js?client-id=Aa9JWIkM1QD0SFtnKgXOS7KQi2LAAQBjecM7LZUijf7KDjKc33dI8F_DFEQWTIJuGMW-gVHkzhnEMahA"></script>
    {{-- checkout section --}}
    <div id="checkout-section">
        <section class="section-event-single-header" v-if="event" v-cloak>
            <div class="container">
                <h1 class="entry-title">Checkout</h1>
                <ul class="ticket-purchase">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#selectticket" v-if="maxPrice" v-cloak>
                            <i v-if="maxPrice > 0 && minPrice != maxPrice" style="font-style: normal!important;">$ @{{
                                minPrice }} - $ @{{ maxPrice }}</i>
                            <i v-if="maxPrice > 0 && minPrice > 0 && minPrice == maxPrice"
                               style="font-style: normal!important;">$ @{{ minPrice }}</i>
                            <i v-if="minPrice == 0 && maxPrice == 0" style="font-style: normal!important;">RSVP</i>
                        </a>
                    </li>
                </ul>
                <!-- Modal -->
                <div class="modal fade" id="selectticket" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center">Select Tix</h4>
                            </div>
                            <div class="modal-body">
                                <div v-if="event.r_e_l_event_ticket" v-for="ticket in allTicketDetails" v-cloak>
                                    <div class="row ticket-type">
                                        <div class="col-sm-8">
                                            <h4 v-if="ticket.event_type == 'Free'">RSVP</h4>
                                            <h4 v-if="ticket.event_type == 'Paid'">PAID</h4>
                                            <h4 v-if="ticket.event_type == 'Donation'">DONATE</h4>
                                            <p>@{{ ticket.ticket_type }}</p>
                                            <p>$@{{ ticket.price }}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" v-if="ticket.quantity <= 0">
                                                <h4 style="color: #ff6600;">SOLD OUT</h4>
                                            </div>
                                            <div class="form-group" v-if="ticket.quantity > 0">
                                                <select class="form-control btn-ticket" id="sel1"
                                                        v-model="ticket.selected">
                                                    <option v-if="ticket.quantity >= 10"
                                                            v-for="(value, index) in 10"
                                                            :value="value">
                                                        @{{ value }}
                                                    </option>
                                                    <option v-if="ticket.quantity < 10"
                                                            v-for="(value, index) in ticket.quantity"
                                                            :value="value">
                                                        @{{ value }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 show-hide-wrapper" v-if="ticket.description">
                                            <hr>
                                            <a data-toggle="collapse" data-target="#demo" id="show-hide">Show Info</a>
                                            <div id="demo" class="collapse">
                                                @{{ ticket.description }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="row">
                                    <div class="col-sm-4 text-left"></div>
                                    <div class="col-sm-4 text-left"></div>
                                    <div class="col-sm-4 text-right">
                                        <a class="checkout-custom"
                                           href="#" data-dismiss="modal"
                                           @click="updateCheckout(allTicketDetails)">Update
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="checkout-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <img class="img-responsive" :src="eventImgUrl + event.r_e_l__event__image[0].image_name">
                    </div>
                    <div class="col-sm-10 heading-wrapper">
                        <h1 class="event-heading">@{{ event.event_title }}</h1>
                        <p>@{{ event.start_date | eventFullDate }} from @{{ event.start_time | eventStartTime }}</p>
                        <p>@{{ event.event_location }}, @{{ event.address }}</p>
                        <p>@{{ event.address_2 }}</p>
                        <p>
                            <b>Brought to you by</b>
                            <a href="Javascript:void(0)">
                                @{{ event.r_e_l__event__organizer.first_name | capitalize}}
                                @{{ event.r_e_l__event__organizer.last_name | capitalize}}
                            </a> &nbsp;
                        </p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-sm-12 order-table">
                        <p>Order Summary</p>
                        <div class="table-responsive">
                            <table class="table checkout-table">
                                <thead>
                                <tr>
                                    <th>Ticket Type</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="ticket in ticketDetails" v-if="ticketDetails && ticket.selected > 0" v-cloak>
                                    <td>@{{ ticket.ticket_type }}</td>
                                    <td>$@{{ ticket.price }}</td>
                                    <td>x @{{ ticket.selected }}</td>
                                    <td>$@{{ ticket.price * ticket.selected }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td colspan="3">$@{{ total }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <h3 class="text-center">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            <span id="demo"></span>
                        </h3>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row checkout-form">
                    <div class="col-sm-8 padding-0 border">
                        <div class="col-sm-12" v-if="!hideInputFields" v-cloak>
                            <p class="form-heading-p"> Purchaser Information</p>
                        </div>
                        <form class="form-section" v-if="!hideInputFields" v-cloak>
                            <div class="col-sm-6 form-group">
                                <input type="text" v-model="buyer.first_name"
                                       class="form-control" placeholder="First Name *" :disabled="savedInDB == 1">
                                <p class="error" v-if="error.buyer.first_name" v-cloak>
                                    @{{ error.buyer.first_name }}</p>
                            </div>
                            <div class="col-sm-6 form-group">
                                <input type="text" v-model="buyer.last_name"
                                       class="form-control" placeholder="Last Name *" :disabled="savedInDB == 1">
                                <p class="error" v-if="error.buyer.show" v-cloak>@{{ error.buyer.last_name }}</p>
                            </div>
                            <div class="col-sm-6 form-group">
                                <input type="text" v-model="buyer.email"
                                       class="form-control" placeholder="Email *" :disabled="savedInDB == 1">
                                <p class="error" v-if="error.buyer.show" v-cloak>@{{ error.buyer.email }}</p>
                            </div>
                            <div class="col-sm-6 form-group">
                                <input type="text" v-model="buyer.confirm_email"
                                       class="form-control" placeholder="Confirm Email *" :disabled="savedInDB == 1">
                                <p class="error" v-if="error.buyer.show" v-cloak>@{{ error.buyer.confirm_email }}</p>
                            </div>
                            <div class="col-sm-6 form-group">
                                <input type="text" v-model="buyer.phone" value=""
                                       class="form-control" placeholder="Phone" :disabled="savedInDB == 1">
                                <p class="error" v-if="error.buyer.show" v-cloak>@{{ error.buyer.phone }}</p>
                            </div>
                        </form>
                        <div class="col-sm-12" v-if="!hideInputFields" v-cloak>
                            <p class="form-heading-p"> Billing Details</p>
                        </div>
                        <form class="form-section" v-if="!hideInputFields" v-cloak>
                            <div class="col-sm-12 form-group">
                                <input type="text" v-model="buyer.billing_address"
                                       class="form-control" placeholder="Address *" :disabled="savedInDB == 1">
                                <p class="error" v-if="error.buyer.show" v-cloak>@{{ error.buyer.billing_address }}</p>
                            </div>
                            {{--<div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" v-model="buyer.billing_address_2"
                                           class="form-control" placeholder="Address...">
                                </div>
                            </div>--}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select v-model="buyer.billing_country"
                                            @change="getStates()"
                                            class="form-control">
                                        <option value="">Select your country</option>
                                        <option v-for="country in countries" :value="country.id"
                                                :disabled="savedInDB == 1">@{{ country.name }}</option>
                                    </select>
                                    <p class="error" v-if="error.buyer.show" v-cloak>@{{ error.buyer.billing_country }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <select v-model="buyer.billing_state" class="form-control">
                                    <option value="">Select your state</option>
                                    <option v-for="state in states" :value="state.id">@{{ state.name }}</option>
                                </select>
                                <p class="error" v-if="error.buyer.show" v-cloak>@{{ error.buyer.billing_state }}</p>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="number" v-model="buyer.billing_zip"
                                           class="form-control" placeholder="Zip Code *" :disabled="savedInDB == 1">
                                    <p class="error" v-if="error.buyer.show" v-cloak>@{{ error.buyer.billing_zip }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <input type="text" v-model="buyer.billing_city"
                                       class="form-control" placeholder="City *" :disabled="savedInDB == 1">
                                <p class="error" v-if="error.buyer.show" v-cloak>@{{ error.buyer.billing_city }}</p>
                            </div>
                            {{--<div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" v-model="buyer.billing_landmark"
                                           class="form-control" placeholder="Landmark" :disabled="savedInDB == 1">
                                </div>
                            </div>--}}
                        </form>

                        <div class="col-sm-12"  v-for="(ticket, index) in ticketDetails" v-if="!hideInputFields" v-cloak>
                            <p class="form-heading-p" v-if="ticket.event_type === 'Free' && ticket.attendees.length">
                                Ticket Holder for RSVP Tickets</p>
                            <p class="form-heading-p" v-if="ticket.event_type !== 'Free' && ticket.attendees.length">
                                {{--Ticket Holder for @{{ ticket.ticket_type }} Tickets</p>--}}
                                Name of Ticket hold @{{ index+1 }}</p>
                            <div class="row" v-for="attendee in ticket.attendees">
                                <div class="col-sm-4 form-group">
                                    <input type="text" class="form-control"
                                           v-model="attendee.first_name"
                                           placeholder="First Name" :disabled="savedInDB == 1">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <input type="text" class="form-control"
                                           v-model="attendee.last_name"
                                           placeholder="Last Name" :disabled="savedInDB == 1">
                                </div>
                                <div class="col-sm-4 form-group">
                                    <input type="text" class="form-control"
                                           v-model="attendee.email"
                                           placeholder="Email" :disabled="savedInDB == 1">
                                </div>
                            </div>
                        </div>
                        <form class="form-section">
                            <div class="col-sm-12 form-group"  v-if="!hideInputFields" v-cloak>
                                <div class="checkbox">
                                    <input id="category2" class="styled"
                                           v-model="isAgreeToTerms"
                                           type="checkbox" :disabled="savedInDB == 1">
                                    <label for="category2">
                                        I accept the terms of service and have read
                                        the privacy policy. I agree that Ibuy Tix
                                        may share my information with event organizer.
                                    </label>
                                    <p class="error" v-if="error.buyer.show" v-cloak>
                                        @{{ error.buyer.isAgreeToTerms }}</p>
                                </div>
                            </div>
                            <div class="col-sm-12 form-group" v-if="total>0" v-show="showPaymentOptions" v-cloak>
                                <div class="radio paypal-payment-section">
                                    <input type="radio" name="payment_type" value="paypal"
                                           id="paypal-payment" v-model="payment_type">
                                    <label for="paypal-payment">PayPal</label>
                                    <div v-if="total > 0 && payment_type == 'paypal'" class="paypal-container">
                                        <div id="paypal-button-container"></div>
                                    </div>
                                </div>
                                <div class="radio payzee-payment-section">
                                    <input type="radio" name="payment_type" value="payzee"
                                           id="payzee-payment" v-model="payment_type">
                                    <label for="payzee-payment">PayZee</label>
                                    <button class="btn btn-success" v-if="total > 0 && payment_type == 'payzee'"
                                            v-cloak>this is for PayZee</button>
                                </div>
                                <div class="radio paystack-payment-section">
                                    <input type="radio" name="payment_type" value="paystack"
                                           id="paystack-payment" v-model="payment_type">
                                    <label for="paystack-payment">PayStack</label>
                                    <button class="btn btn-success" v-if="total > 0 && payment_type == 'paystack'"
                                            v-cloak>this is for PayStack</button>
                                </div>
                            </div>
                            <div class="col-sm-12 form-group">
                                <!-- Set up a container element for the button -->
                                <a href="#" class="checkout-custom pull-left"
                                   @click.prevent="buyFreeTickets" v-if="total == 0"
                                   v-show="bookNow"
                                   v-cloak>Book Now</a>
                                <a href="#" class="checkout-custom pull-left"
                                   @click.prevent="proceedToPay" v-if="total > 0"
                                   v-show="showProceedToPay" v-cloak>Proceed To Pay</a>
                                <div class="clearfix"></div>
                                <div  class="visa-img" v-show="showProceedToPay">
                                    <img :src="imgUrl + 'visa.jpg'" width="200">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <div class="checkout-right">
                            <h4>Tickets</h4>
                            <hr/>
                            <span v-if="ticketDetails" v-for="ticket in ticketDetails">
                                <h4 v-if="ticket.selected>0" v-cloak>@{{ ticket.ticket_type }}
                                    <span style="float: right;">
                                        @{{ ticket.selected }} x $@{{ ticket.price }}
                                    </span>
                                </h4>
                            </span>
                            <hr/>
                            <h4>Total: <span class="pull-right" v-cloak>$@{{ total }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- //checkout section --}}
@endsection