@extends('organizer.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h1>My promotion request send to other organizers</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container" id="my-promotion-list">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <div class="col-sm-4">
                    <select v-model="requestType" class="form-control custom-dropdown">
                        <option value="">All</option>
                        <option value="accepted">Accepted</option>
                        <option value="rejected">Rejected</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <br>
                <div class="table-wrapper table-responsive col-sm-12">
                    <!--Table-->
                    <table class="table table-hover mb-0">
                        <!--Table head-->
                        <thead>
                        <tr>
                            <th scope="col">Event Name</th>
                            <th scope="col">Organizer Name</th>
                            <th scope="col">Organizer Email</th>
                            <th scope="col">Message</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Request Date</th>
                            <th scope="col">Request Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <!-- //Table head-->
                        <!--Table body-->
                        <tbody>
                        <tr v-if="myPromotions.data" v-for="promo in myPromotions.data" v-cloak>
                            <td>@{{ promo.event.event_title }}</td>
                            <td>@{{ promo.organizer.first_name }} @{{ promo.organizer.last_name }}</td>
                            <td><a :href="'mailto:' + promo.organizer.email">@{{ promo.organizer.email }}</a></td>
                            <td>@{{ promo.request_type }}</td>
                            <td>
                                @{{ promo.event.start_date | eventStartDate }}
                                @{{ promo.event.start_time | eventStartTime }}
                            </td>
                            <td>
                                @{{ promo.event.end_date | eventStartDate }}
                                @{{ promo.event.end_time | eventStartTime }}
                            </td>
                            <td>@{{ promo.created_at | eventCreatedDate }}</td>
                            <td v-if="promo.request_status === 'pending'"
                                class="alert-warning">@{{ promo.request_status }}</td>
                            <td v-else-if="promo.request_status === 'accepted'"
                                class="alert-success">@{{ promo.request_status }}</td>
                            <td v-else-if="promo.request_status === 'rejected'"
                                class="alert-danger">@{{ promo.request_status }}</td>
                            <td v-else>@{{ promo.request_status }}</td>
                            <td>
                                <a :href="'{{ url('/event') }}/'+promo.event.event_url"
                                   target="_blank" title="view event">
                                    <i class="fa fa-eye" style="font-size:20px"></i>
                                </a>
                            </td>
                        </tr>

                        <tr v-if="myPromotions.code === 0" v-cloak>
                            <td colspan="9" class="text-center">@{{ myPromotions.message }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <pagination :data="myPromotions" @pagination-change-page="getMyPromotions"
                            style="float: right; margin-top: 10px;"></pagination>
            </div>
        </div>
    </div>
@endsection