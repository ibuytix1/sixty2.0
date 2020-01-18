@extends('organizer.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Incoming Promotion Requests</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container" id="promotion-requests-list">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <br>
                <div class="table-wrapper table-responsive col-sm-12">
                    <!--Table-->
                    <table class="table table-hover mb-0">
                        <!--Table head-->
                        <thead>
                        <tr>
                            <th scope="col">Event Name</th>
                            <th scope="col">Promoters Name</th>
                            <th scope="col">Promoters Email</th>
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
                        <tr v-if="promoRequests.data" v-for="promo in promoRequests.data" v-cloak>
                            <td>
                                <a :href="'{{ url('/event') }}/'+promo.event.event_url"
                                   target="_blank" title="view event">
                                    @{{ promo.event.event_title }}
                                </a>
                            </td>
                            <td>@{{ promo.promoter.first_name }} @{{ promo.promoter.last_name }}</td>
                            <td><a :href="'mailto:' + promo.promoter.email">@{{ promo.promoter.email }}</a></td>
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
                                <a href="#" title="accept" @click.prevent="updatePromoStatus(promo.id, 'accept')">
                                    <i class="fa fa-check" style="color: green;"></i>
                                </a>
                                <a href="#" title="reject" @click.prevent="updatePromoStatus(promo.id, 'reject')">
                                    <i class="fa fa-remove" style="color: red;"></i>
                                </a>
                            </td>
                        </tr>

                        <tr v-if="promoRequests.code == 0" v-cloak>
                            <td colspan="9" class="text-center">@{{ promoRequests.message }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <pagination :data="promoRequests" @pagination-change-page="getMyPromoRequests"
                            style="float: right; margin-top: 10px;"></pagination>
            </div>
        </div>
    </div>
@endsection