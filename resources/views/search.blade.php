@extends('layouts.welcome-app')

@section('content')
    <div id="search-event">
        <section class="section-refine-search">
            <div class="container">
                <div class="row">
                    <form>
                        <div class="keyword col-sm-6 col-md-4">
                            <label for="search_keyword">Search Keyword</label>
                            <input type="text" class="form-control hasclear" id="search_keyword"
                                   placeholder="Search" v-model="keyword">
                        </div>
                        <div class="location col-sm-6 col-md-3">
                            <label for="search_location">Location</label>
                            <select id="search_location" class="selectpicker dropdown"
                                    v-model="searchLocation">
                                <option value="">Select Location</option>
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Nigeria">Nigeria</option>
                            </select>
                        </div>
                        <div class="event-date col-sm-6 col-md-3">
                            <label for="search_event_date">Event Date</label>
                            <input type="text" id="search_event_date"
                                   class="form-control hasclear">
                        </div>
                        <div class="col-sm-6 col-md-2">
                            {{--<input type="submit" value="Search">--}}
                            <button class="search-button" @click.prevent="searchEvents">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="section-search-content">
            <div class="container">
                <div class="row">
                    <div id="primary" class="col-md-12 col-lg-12">

                        <div class="search-result-header">
                            <div class="row">
                                <div class="col-sm-7">
                                    <h2 v-if="keyword">@{{ keyword }}</h2>
                                    <h2 v-if="!keyword">All Events</h2>
                                    <span>Showing @{{ events.from }}-@{{ events.to }} of @{{ events.total }} Results</span>
                                </div>
                                <div class="col-sm-5">
                                    <label for="sort_by_price">Sort By</label>
                                    <select class="select_for_category"
                                            id="sort_by_price" v-model="selectCategory">
                                        <option value="">Select Category</option>
                                        <option v-for="category in categories"
                                                :value="category.id">@{{ category.category_name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div :class="'search-result-item ' + event.isSoldOut" v-for="event in events.data">
                            <div class="row">
                                <div class="search-result-item-info col-sm-9">
                                    <h3>@{{ event.event_title }}</h3>
                                    <ul class="row">
                                        <li class="col-sm-5 col-lg-6">
                                            <span>@{{ event.location }}</span>
                                            @{{ event.address }}
                                        </li>
                                        <li class="col-sm-4 col-lg-3">
                                            <span>@{{ event.start_date | eventStartDateFullDay }}</span>
                                            @{{ event.start_date | eventStartDateSearchEvent }}
                                        </li>
                                        <li class="col-sm-3">
                                            <span>Time</span>
                                            @{{ event.start_time | eventStartTime }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="search-result-item-price col-sm-3">
                                    <span>Price From</span>
                                    <div class="text-center">
                                        <i v-if="event.minPrice > 0 && event.minPrice != event.maxPrice" style="font-style: normal!important;">
                                            $ @{{ event.minPrice }} -
                                        </i>
                                        <i v-if="event.maxPrice > 0 && event.minPrice != event.maxPrice" style="font-style: normal!important;">
                                            $ @{{ event.maxPrice }}
                                        </i>
                                        <i v-if="event.maxPrice > 0 && event.minPrice > 0 && event.minPrice == event.maxPrice"
                                           style="font-style: normal!important;">$ @{{ event.minPrice }}</i>
                                        <i v-if="event.minPrice == 0" style="font-style: normal!important;">RSVP</i>
                                    </div>
                                    <a :href="'{{ url('/event') }}/' + event.event_url"
                                       v-if="event.totalQuantity > 0">Book Now</a>
                                    <a href="JavaScript:void(0)"
                                       v-if="event.totalQuantity <= 0">Sold Out</a>
                                </div>
                            </div>
                        </div>
                        <div class="search-result-item" v-if="events.message">
                            <div class="row">
                                <div class="col-sm-9">
                                    <h3>No Event Found</h3>
                                </div>
                            </div>
                        </div>
                        <div class="search-result-footer">
                            <pagination :data="events" @pagination-change-page="searchEvents"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection