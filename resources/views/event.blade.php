@extends('layouts.welcome-app')
@section('content')
    <div id="single-event">
        {{-- single event section --}}
        <section class="section-event-single-header" v-if="event" v-cloak>
            <div class="container">
                <h1>@{{ event.event_title }}</h1>
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
                <div class="modal fade" id="selectticket" role="dialog" style="z-index: 99999999;">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center">Select Tix</h4>
                            </div>
                            <div class="modal-body">
                                <div v-if="event.r_e_l_event_ticket" v-for="ticket in ticketDetails">
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
                                    <div class="col-sm-4 text-left">
                                        {{--<p><b>QTY:</b> 2</p>--}}
                                    </div>
                                    <div class="col-sm-4 text-left">
                                        {{--<p>FREE</p>--}}
                                    </div>
                                    <div class="col-sm-4 text-right">
                                        <a class="checkout-custom"
                                           href="#" data-dismiss="modal"
                                           @click="showCheckout(ticketDetails)">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-event-single-content" v-if="event" v-cloak>
            <div class="container">
                <div class="row">
                    <div id="primary" class="col-sm-12 col-md-12">
                        <div class="event-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="event-info-img">
                                        <div id="slider" class="flexslider">
                                            <ul class="slides">
                                                <li v-for="image in event.r_e_l__event__image">
                                                    <img :src="eventImgUrl + image.image_name" alt="image"/>
                                                </li>
                                            </ul>
                                        </div>
                                        <div id="carousel" class="flexslider">
                                            <ul class="slides">
                                                <li v-for="image in event.r_e_l__event__image">
                                                    <img :src="eventImgUrl + image.image_name" alt="image"/>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="event-info-about">
                                        <h2>Event Location</h2>
                                        <p>@{{ event.event_location }}</p>
                                        <p>@{{ event.address }}</p>
                                        <p>@{{ event.address_2 }}</p>
                                        <h2>Event Details</h2>
                                        <p><b>Date/Time: </b> @{{ event.start_date | eventStartDate }}
                                            | @{{ event.start_time | eventStartTime }}
                                            <br><b>Refund Policy</b>
                                            <span v-if="event.refund_policy">Refundable</span>
                                            <span v-if="!event.refund_policy">No Refund</span>
                                        </p>
                                        <p>
                                            <!-- Button code -->
                                            <div title="Add to Calendar" class="addeventatc">
                                                Add to Calendar
                                                <span class="start">@{{ event.start_date | eventStartDate }} @{{ event.start_time | eventStartTime }}</span>
                                                <span class="end">@{{ event.end_date | eventStartDate }} @{{ event.end_time | eventStartTime }}</span>
                                                <span class="title">@{{ event.event_title }}</span>
                                                <span class="description">@{{ event.event_description }}</span>
                                                <span class="location">@{{ event.address }}</span>
                                            </div>
                                        </p>
                                        <h2>Tags</h2>
                                        <p>
                                            <span class="details-tags" v-for="tag in event.tags">@{{ tag.tag }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div id="map" style="width: 100%; height: 300px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="event-highlights">
                                    <h2>Event Description</h2>
                                    <span v-html="event.event_description">
                                        @{{ event.event_description }}
                                    </span>
                                </div>
                            {{-- share on social media --}}
                            <!-- Sharingbutton Facebook -->
                                <a class="resp-sharing-button__link"
                                   :href="'https://facebook.com/sharer/sharer.php?u='+baseHomeUrl+event.event_url"
                                   target="_blank" rel="noopener" aria-label="Share on Facebook">
                                    <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--large">
                                        <div aria-hidden="true"
                                             class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                                            </svg>
                                        </div>
                                        Share on Facebook
                                    </div>
                                </a>
                                <!-- Sharingbutton Twitter -->
                                <a class="resp-sharing-button__link"
                                   :href="'https://twitter.com/intent/tweet/?text='+event.event_title+'&amp;url='+baseHomeUrl+event.event_url"
                                   target="_blank" rel="noopener" aria-label="Share on Twitter">
                                    <div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--large">
                                        <div aria-hidden="true"
                                             class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/>
                                            </svg>
                                        </div>
                                        Share on Twitter
                                    </div>
                                </a>
                                <!-- Sharingbutton Pinterest -->
                            {{--<a class="resp-sharing-button__link" href="https://pinterest.com/pin/create/button/?url=http%3A%2F%2Fsharingbuttons.io&amp;media=http%3A%2F%2Fsharingbuttons.io&amp;description=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking." target="_blank" rel="noopener" aria-label="Share on Pinterest">
                                <div class="resp-sharing-button resp-sharing-button--pinterest resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.14.5C5.86.5 2.7 5 2.7 8.75c0 2.27.86 4.3 2.7 5.05.3.12.57 0 .66-.33l.27-1.06c.1-.32.06-.44-.2-.73-.52-.62-.86-1.44-.86-2.6 0-3.33 2.5-6.32 6.5-6.32 3.55 0 5.5 2.17 5.5 5.07 0 3.8-1.7 7.02-4.2 7.02-1.37 0-2.4-1.14-2.07-2.54.4-1.68 1.16-3.48 1.16-4.7 0-1.07-.58-1.98-1.78-1.98-1.4 0-2.55 1.47-2.55 3.42 0 1.25.43 2.1.43 2.1l-1.7 7.2c-.5 2.13-.08 4.75-.04 5 .02.17.22.2.3.1.14-.18 1.82-2.26 2.4-4.33.16-.58.93-3.63.93-3.63.45.88 1.8 1.65 3.22 1.65 4.25 0 7.13-3.87 7.13-9.05C20.5 4.15 17.18.5 12.14.5z"/></svg>
                                    </div>Share on Pinterest</div>
                            </a>--}}

                            <!-- Sharingbutton LinkedIn -->
                            {{--<a class="resp-sharing-button__link" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=http%3A%2F%2Fsharingbuttons.io&amp;title=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking.&amp;summary=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking.&amp;source=http%3A%2F%2Fsharingbuttons.io" target="_blank" rel="noopener" aria-label="Share on LinkedIn">
                                <div class="resp-sharing-button resp-sharing-button--linkedin resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.5 21.5h-5v-13h5v13zM4 6.5C2.5 6.5 1.5 5.3 1.5 4s1-2.4 2.5-2.4c1.6 0 2.5 1 2.6 2.5 0 1.4-1 2.5-2.6 2.5zm11.5 6c-1 0-2 1-2 2v7h-5v-13h5V10s1.6-1.5 4-1.5c3 0 5 2.2 5 6.3v6.7h-5v-7c0-1-1-2-2-2z"/></svg>
                                    </div>Share on LinkedIn</div>
                            </a>--}}

                            <!-- Sharingbutton Reddit -->
                                {{--<a class="resp-sharing-button__link" href="https://reddit.com/submit/?url=http%3A%2F%2Fsharingbuttons.io&amp;resubmit=true&amp;title=Super%20fast%20and%20easy%20Social%20Media%20Sharing%20Buttons.%20No%20JavaScript.%20No%20tracking." target="_blank" rel="noopener" aria-label="Share on Reddit">
                                    <div class="resp-sharing-button resp-sharing-button--reddit resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M24 11.5c0-1.65-1.35-3-3-3-.96 0-1.86.48-2.42 1.24-1.64-1-3.75-1.64-6.07-1.72.08-1.1.4-3.05 1.52-3.7.72-.4 1.73-.24 3 .5C17.2 6.3 18.46 7.5 20 7.5c1.65 0 3-1.35 3-3s-1.35-3-3-3c-1.38 0-2.54.94-2.88 2.22-1.43-.72-2.64-.8-3.6-.25-1.64.94-1.95 3.47-2 4.55-2.33.08-4.45.7-6.1 1.72C4.86 8.98 3.96 8.5 3 8.5c-1.65 0-3 1.35-3 3 0 1.32.84 2.44 2.05 2.84-.03.22-.05.44-.05.66 0 3.86 4.5 7 10 7s10-3.14 10-7c0-.22-.02-.44-.05-.66 1.2-.4 2.05-1.54 2.05-2.84zM2.3 13.37C1.5 13.07 1 12.35 1 11.5c0-1.1.9-2 2-2 .64 0 1.22.32 1.6.82-1.1.85-1.92 1.9-2.3 3.05zm3.7.13c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm9.8 4.8c-1.08.63-2.42.96-3.8.96-1.4 0-2.74-.34-3.8-.95-.24-.13-.32-.44-.2-.68.15-.24.46-.32.7-.18 1.83 1.06 4.76 1.06 6.6 0 .23-.13.53-.05.67.2.14.23.06.54-.18.67zm.2-2.8c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm5.7-2.13c-.38-1.16-1.2-2.2-2.3-3.05.38-.5.97-.82 1.6-.82 1.1 0 2 .9 2 2 0 .84-.53 1.57-1.3 1.87z"/></svg>
                                        </div>Share on Reddit</div>
                                </a>--}}
                                {{-- //share on social media --}}
                            </div>
                            <div class="col-sm-4">
                                <div class="organizer-details">
                                    <div class="row">
                                        <h4>Organizer Details</h4>
                                        <div class="col-xs-4">
                                            <img class="img-70x70" :src="imgUrl + 'order-details-img.jpg'">
                                        </div>
                                        <div class="col-xs-8">
                                            <p class="org-name" v-if="event.r_e_l__event__organizer">
                                                <a href="#" data-toggle="modal"
                                                   data-target="#organizer-details">
                                                    <b>@{{ event.r_e_l__event__organizer.first_name }}
                                                        @{{ event.r_e_l__event__organizer.last_name }}</b>
                                                </a>
                                            </p>
                                            <p v-if="event.r_e_l__event__organizer">
                                                <a :href="'mailto:' + event.r_e_l__event__organizer.email">
                                                    @{{ event.r_e_l__event__organizer.email }}
                                                </a>
                                            </p>
                                            <a href="#" @click.prevent="follow(event.r_e_l__event__organizer.id)"
                                               class="detail-follow" v-if="!isFollowing && !me" v-cloak>Follow</a>
                                            <a href="#" @click.prevent="unFollow(event.r_e_l__event__organizer.id)"
                                               class="detail-follow" v-if="isFollowing && !me"
                                               style="color: #fff !important; background-color: #ff6600;"
                                               v-cloak>Unfollow</a>
                                        </div>
                                    </div>
                                </div>
                                <p v-if="!me" v-cloak>
                                    <a href="#" data-toggle="modal"
                                       data-target="#promotion-request" class="promote_sell">
                                        <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                                        <span>Request to Promote/Sell Event</span>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="event-location">
                            <h2>Other Information</h2>
                        </div>
                        <div class="event-features">
                            <ul v-if="additional">
                                <li v-for="addi in additional">
                                    <span v-if="addi == 1">
                                        <i class="fa fa-beer fa-2x" aria-hidden="true"></i>Alcohol
                                    </span>
                                    <span v-else-if="addi == 2">
                                        <i class="fa fa-id-card fa-2x" aria-hidden="true"></i>Id Card Required
                                    </span>
                                    <span v-else-if="addi == 3">
                                        <i class="fa fa-child fa-2x" aria-hidden="true"></i>Children Allowed
                                    </span>
                                    <span v-else-if="addi == 4">
                                        <i class="fas fa-male fa-2x"></i>18+
                                    </span>
                                    <span v-else-if="addi == 5">
                                        <i class="fa fa-car fa-2x" aria-hidden="true"></i>Parking Available
                                    </span>
                                    <span v-else-if="addi == 6">
                                        <i class="fa fa-wheelchair fa-2x" aria-hidden="true"></i>Wheelchair
                                    </span>
                                    <span v-else-if="addi == 7">
                                        <i class="fas fa-tshirt fa-2x"></i>Casual Dressing
                                    </span>
                                    <span v-else-if="addi == 8">
                                        <i class="fas fa-user-tie fa-2x"></i>Corporate Dressing
                                    </span>
                                    <span v-else-if="addi == 9">
                                        <i class="fas fa-clock"></i>Early Check-in
                                    </span>
                                </li>
                            </ul>
                            {{--<ul>
                                <li>
                                    <i class="fa fa-mobile fa-3x" aria-hidden="true"></i>
                                    Smartphone <br> tickets accepted
                                </li>
                                <li>
                                    <i class="fa fa-hourglass-o fa-2x" aria-hidden="true"></i>
                                    Duration: 1 hour <br> and 30 minutes
                                </li>
                                <li>
                                    <i class="fa fa-subway fa-2x" aria-hidden="true"></i>
                                    Metro Line 3: stop Palau <br> Reial or Les Corts
                                </li>
                                <li>
                                    <i class="fa fa-car fa-2x" aria-hidden="true"></i>
                                    <span v-if="event.aditional_information">
                                    Car Parking:<br><span v-if="event.aditional_information.indexOf('5') <= -1">
                                            Not</span> Available
                                </span>
                                </li>
                            </ul>--}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- //single event section --}}

        {{-- promotion modal --}}

    <!-- Modal -->
        <div class="modal fade" id="promotion-request" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">Promotion Request</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row ticket-type">
                            <div class="col-sm-4">
                                <h4>Message To Organizer</h4>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="text" v-model="promoterMessage" class="form-control">
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.promoterMessage }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row ticket-type">
                            <div class="col-md-2">
                                <input id="category2" class="styled" v-model="promoterAcceptAgreement"
                                       type="checkbox">
                            </div>
                            <div class="col-md-10">
                                <label for="category2">
                                    I accept the terms of service and have read the
                                    <a data-toggle="collapse" data-target="#demo" id="show-hide"
                                       style="color:#ff6600; cursor: pointer;">
                                        privacy policy
                                    </a>.
                                    I agree that Ibuy Tix may share my information with event organizer.
                                </label>
                                <p class="error" v-if="error.show" v-cloak>@{{ error.promoterAcceptAgreement }}</p>
                            </div>
                            <div class="col-sm-12 show-hide-wrapper">
                                <hr>
                                <div id="demo" class="collapse">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-sm-4 text-right" style="float: right;">
                                <a class="checkout-custom" href="JavaScript:void(0)"
                                   @click.prevent="sendPromotionRequest">Send Request</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //promotion modal --}}

        {{-- Organizer details --}}

    <!-- Modal -->
        <div class="modal fade" id="organizer-details" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">Promotion Request</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row ticket-type">
                            <div class="row" v-if="organizer.first_name">
                                <div class="col-sm-3"><h5>Name: </h5></div>
                                <div class="col-sm-9">
                                    <h5>@{{ organizer.first_name }} @{{ organizer.last_name }}</h5>
                                </div>
                            </div>
                            <br>
                            <div class="row" v-if="organizer.email">
                                <div class="col-sm-3"><h5>Email: </h5></div>
                                <div class="col-sm-9"><h5>@{{ organizer.email }}</h5></div>
                            </div>
                            <br>
                            <div class="row" v-if="organizer.about_organizer">
                                <div class="col-sm-3"><h5>Bio: </h5></div>
                                <div class="col-sm-9"><h5>@{{ organizer.about_organizer }}</h5></div>
                            </div>
                            <br>
                            <div class="row" v-if="organizer.unique_url">
                                <div class="col-sm-3"><h5>Website: </h5></div>
                                <div class="col-sm-9"><h5>@{{ organizer.unique_url }}</h5></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-3"><h5>Social Icons: </h5></div>
                                <div class="col-sm-9">
                                    <h5>
                                        <a v-if="organizer.fb_url" target="_blank"
                                           :href="organizer.fb_url" style="margin-right: 10px">
                                            <i class="fa fa-facebook fa-2x" aria-hidden="true"></i>
                                        </a>
                                        <a v-if="organizer.twitter" target="_blank"
                                           :href="organizer.twitter" style="margin-right: 10px">
                                            <i class="fa fa-twitter fa-2x" aria-hidden="true"></i>
                                        </a>
                                        <a v-if="organizer.snapchat" target="_blank"
                                           :href="organizer.snapchat" style="margin-right: 10px">
                                            <i class="fa fa-snapchat fa-2x"></i>
                                        </a>
                                        <a v-if="organizer.insta_url" target="_blank"
                                           :href="organizer.insta_url" style="margin-right: 10px">
                                            <i class="fa fa-instagram fa-2x"></i>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //organizer details --}}
    </div>
@endsection
