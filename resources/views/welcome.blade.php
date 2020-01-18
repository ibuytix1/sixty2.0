@extends('layouts.welcome-app')
@section('content')
    <div id="landing-page">
        <section class="hero-1">
            <div class="container">
                <div class="row">
                    <div class="hero-content">
                        <h1 class="hero-title">Attending Events just got better</h1>
                        <p class="hero-caption">Your next event is a click away</p>
                        <div class="hero-search">
                            <input type="text" placeholder="Search Event, Artiste, Or Organizer" v-model="search"
                                   @keyup.enter="searchEvent('')">
                        </div>
                        <div class="hero-location">
                            <p><i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span v-if="currentLocation" v-cloak>@{{ currentLocation }}</span>
                                <span v-if="!currentLocation" v-cloak class="error">@{{ currentLocationError }}</span>

                                <input type="text" id="locationInputField" placeholder="choose your location"
                                       class="form-control" v-if="changeCurrentLocation"
                                       ref="locationInputField" v-cloak>
                                <a href="#" @click.prevent="updatePlace" v-if="changeCurrentLocation" v-cloak>update</a>
                                <a href="#" @click.prevent="changeCurrentLocation = false"
                                   v-if="changeCurrentLocation" v-cloak>Cancel</a>

                                <a href="#" @click.prevent="changeCurrentLocation = true"
                                   v-if="!changeCurrentLocation">Change Location</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-todays-schedule">
            <div class="container">
                <div class="row">
                    <div class="section-header">
                        <h2>Happening This week</h2>
                        <span class="todays-date" v-if="today" v-cloak><i class="fa fa-calendar" aria-hidden="true"></i>
                            <strong>@{{ today.day }}</strong> @{{ today.month }} @{{ today.year }} </span>
                    </div>
                    <div class="section-content">
                        <ul class="clearfix">
                            <li :class="'event-'+(index+1)" v-if="events" v-for="(event, index) in events" v-cloak>
                                <span class="event-time">@{{ event.start_date | eventStartDate }},
                                    @{{ event.start_time | eventStartTime }}</span>
                                <br>
                                <strong class="event-name">@{{ event.event_title }}</strong>
                                <a :href="'{{ url('/event') }}/' + event.event_url" class="get-ticket"
                                   v-for="(ticket, index) in event.r_e_l_event_ticket"
                                   v-if="index == 0 && ticket.quantity > 0">
                                    <i v-if="event.maxPrice > 0 && event.minPrice != event.maxPrice" style="font-style: normal!important;">
                                        $ @{{ event.minPrice }} - $ @{{ event.maxPrice }}
                                    </i>
                                    <i v-if="event.maxPrice > 0 && event.minPrice > 0 && event.minPrice == event.maxPrice"
                                       style="font-style: normal!important;">$ @{{ event.minPrice }}</i>
                                    <i v-if="event.minPrice == 0 && event.maxPrice == 0" style="font-style: normal!important;">RSVP</i>
                                </a>
                                <a href="Javascript:void(0)" class="sold-ticket"
                                   v-if="event.r_e_l_event_ticket[0].quantity <= 0">Sold Out</a>
                            </li>
                        </ul>
                        <strong class="event-list-label">Full Event <span>Schedules</span></strong>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-calendar-events">
            <div class="container">
                <div class="row">
                    <div class="section-header">
                        <h2>
                            Events Near You
                            <span v-if="currentLocation" v-cloak>@{{ currentLocation }}</span>
                            <span v-if="!currentLocation" v-cloak class="error">@{{ currentLocationError }}</span>
                        </h2>
                    </div>
                    <div class="section-content">
                        <div class="tab-content">
                            <div>
                                <ul class="clearfix">
                                    <li v-if="!allEvents.data" v-cloak>
                                        <p>@{{ allEvents }}</p>
                                    </li>
                                    <li v-if="allEvents" v-for="event in allEvents.data" v-cloak>
                                        <div class="date">
                                            <a :href="'{{ url('/event') }}/' + event.event_url">
                                                <span class="day">@{{ event.start_date | eventStartDateDay }}</span>
                                                <span class="month">@{{ event.start_date | eventStartDateMonth }}</span>
                                                <span class="year">@{{ event.start_date | eventStartDateYear }}</span>
                                            </a>
                                        </div>
                                        <a :href="'{{ url('/event') }}/' + event.event_url">
                                            <img :src="eventImageUrl + event.r_e_l__event__image[0].image_name"
                                                 alt="image" class="calendar-event-image">
                                        </a>
                                        <div class="info">
                                            <p>
                                                @{{ event.event_title }}
                                                <br>
                                                @{{ event.event_location }}
                                                <span>@{{ event.address }}</span>
                                            </p>
                                            <a :href="'{{ url('/event') }}/' + event.event_url" class="get-ticket"
                                               v-for="(ticket, index) in event.r_e_l_event_ticket"
                                               v-if="index == 0 && event.r_e_l_event_ticket[0].quantity > 0">
                                                <i v-if="event.maxPrice > 0 && event.minPrice != event.maxPrice" style="font-style: normal!important;">
                                                    $ @{{ event.minPrice }} - $ @{{ event.maxPrice }}
                                                </i>
                                                <i v-if="event.maxPrice > 0 && event.minPrice > 0 && event.minPrice == event.maxPrice"
                                                   style="font-style: normal!important;">$ @{{ event.minPrice }}</i>
                                                <i v-if="event.minPrice == 0 && event.maxPrice == 0" style="font-style: normal!important;">RSVP</i>
                                            </a>
                                            <a href="Javascript:void(0)" class="landing-page-all-events"
                                               v-if="event.r_e_l_event_ticket[0].quantity <= 0">Sold Out</a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="col-sm-12 text-center">
                                    <button class="btn browse-more-btn" v-if="allEvents.next_page_url"
                                            @click.prevent="getEvents(eventsPage+1)" v-cloak>Browse more</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--  cateogry slider -->
        <section id="demos">
            <div class="container">
                <div class="large-12 columns">
                    <div class="owl-carousel owl-theme">
                        <div class="item" v-if="categories" v-for="(category, index) in categories"
                             v-cloak>
                            <a href="JavaScript:void(0)" @click.prevent="searchEvent(category.id)">
                                <img :src="imageUrl + 'categories/' + category.category_name + '.jpg'" alt="image">
                                <h4>@{{ category.category_name }}</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-newsletter">
            <div class="container">
                <div class="section-content">
                    <h2>Stay Up to date With Your Favorite Events!</h2>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                        sed diam nonummy nibh <br> euismod tincidunt ut laoreet
                        dolore magna aliquam erat volutpat.</p>
                    <div class="newsletter-form clearfix">
                        <input type="email" placeholder="Your Email Address">
                        <input type="submit" value="Subscribe">
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

