@extends('organizer.include.app')
@section('content')
    <div class="container" id="organizer-dashboard">
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Net Sales</h4>
                        <div class="row" v-if="recentSells.total">
                            <div class="col-xl-4">
                                <h6>This Week</h6>
                                <h4 class="color-primary">$@{{ recentSells.total.thisWeek }}</h4>
                            </div>
                            <div class="col-xl-4">
                                <h6>Previous Week</h6>
                                <h4 class="color-primary">$@{{ recentSells.total.lastWeek }}</h4>
                            </div>
                        </div>
                        <div id="simple-line-chart" class="ct-chart ct-golden-section m-t-15"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title m-b-15">TICKETS</h4>
                        <div class="tickets text-center m-t-50">
                            <div class="position-relative d-inline-block  m-b-50">
                                <div id="circle"></div>
                                <div class="seat-content">
                                    <h2>@{{ ticketSales.sold_tickets }}</h2>
                                    <span>Sold Tickets</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h6>Sold Tickets</h6>
                                    <h4 class="color-primary">$@{{ ticketSales.total_sales }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title m-b-15">UPCOMING EVENTS</h4>
                        <div class="upcoming-events">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr v-for="event in events.data">
                                        <td>
                                            <img :src="'{{ asset('public/upload/event_image') }}/'
                                            + event.r_e_l__event__image[0].image_name" :alt="event.event_title">
                                        </td>
                                        <td>@{{ event.event_title }}
                                            <a :href="'{{ url('/event/') }}/' + event.event_url" target="_blank">
                                                <i class="icofont icofont-social-google-map"></i> Location
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title m-b-15">RECENT SELLS</h4>
                        <div class="upcoming-events">
                            <div class="row" v-if="recentSells.total">
                                <div class="col-xl-4">
                                    <h6>This Week</h6>
                                    <h4 class="color-primary">
                                        $@{{ recentSells.total.thisWeek }}</h4>
                                </div>
                                <div class="col-xl-4">
                                    <h6>Previous Week</h6>
                                    <h4 class="color-primary">
                                        $@{{ recentSells.total.lastWeek }}
                                    </h4>
                                </div>
                            </div>
                            <div class="table-responsive m-t-15">
                                <table class="table">
                                    <tr v-for="order in recentSells.thisWeek">
                                        <td v-if="order.user">@{{ order.user.first_name }} @{{ order.user.last_name }}
                                            <a :href="'{{ url('event') }}/' + order.event.event_url" target="_blank">
                                                @{{ order.event.event_title }}
                                            </a>
                                        </td>
                                        <td>X @{{ order.total_quantity }}</td>
                                        <td>$@{{ order.total_amount }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title m-b-15">Total Seats</h4>
                        <div class="total-seats text-center m-t-50">
                            <div class="position-relative d-inline-block m-b-50">
                                <div id="circle1"></div>
                                <div class="seat-content">
                                    <h2>@{{ ticketSales.sold_tickets }}</h2>
                                    <span>Total Sells</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h6>Sold Tickets</h6>
                                    <h4 class="color-primary">$@{{ ticketSales.total_sales }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /# content body -->
@endsection