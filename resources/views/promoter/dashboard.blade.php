@extends('promoter.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Promotion List </h1>
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
                        <tr v-if="myPromotions.data" v-for="promo in myPromotions.data">
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
                                {{--<a href="#" title="Edit Promotion Request" data-toggle="modal"
                                   data-target="#edit-promotion-request">
                                    <i class="fa fa-pencil" style="font-size:20px"></i>
                                </a>--}}
                            </td>
                        </tr>

                        <tr v-if="!myPromotions.data">
                            <td colspan="9" class="text-center">data not available</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <pagination :data="myPromotions" @pagination-change-page="getMyPromotions"
                            style="float: right; margin-top: 10px;"></pagination>
            </div>
        </div>
        {{-- promotion modal --}}

        <!-- Modal -->
        {{--<div class="modal fade" id="edit-promotion-request" role="dialog">
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
                                <h4>Edit Message</h4>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="text" v-model="promotion.message" class="form-control">
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.promoterMessage }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-sm-4 text-right" style="float: right;">
                                <a class="checkout-custom" href="JavaScript:void(0)"
                                   @click.prevent="updateMessage(promotion.id)">Update</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
        {{-- //promotion modal --}}

    </div>
@endsection