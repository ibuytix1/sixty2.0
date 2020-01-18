@extends('organizer.include.app')
@section('before-content')
@endsection
@section('content')
    <div class="container" id="coupon-list">
        <div class="row justify-content-between" v-if="edit == false">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group custom-search">
                            <input type="text" class="form-control"
                                   placeholder="Find Coupon" v-model="keywords" @keyup.enter="searchCoupons">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-wrapper table-responsive col-sm-12">
                    <!--Table-->
                    <table class="table table-hover mb-0" id="coupon_list_table">
                        <!--Table head-->
                        <thead>
                        <tr>
                            <th scope="col">Coupon/Discount Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Total Available</th>
                            <th scope="col">Amount/Percentage</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                        {{-- for loop here --}}
                        <tr class="tr-dynamic-id" v-for="coupon in coupons.data" v-if="coupons.data" v-cloak>
                            <td>@{{ coupon.coupon }}</td>
                            <td>
                                <span v-if="coupon.description">
                                    @{{ coupon.description.substring(0, 15) + '...' }}
                                </span>
                                <span v-if="!coupon.description">@{{ coupon.description }}</span>
                            </td>
                            <td>@{{ coupon.start_date }}</td>
                            <td>@{{ coupon.end_date }}</td>
                            <td v-if="coupon.total_available != null">@{{ coupon.total_available }}</td>
                            <td v-if="coupon.total_available == null">&infin;</td>
                            <td> @{{ coupon.amount }} <span v-if="coupon.type == '%'">@{{ coupon.type }}</span></td>
                            <td v-if="coupon.status == 1"> Active </td>
                            <td v-if="coupon.status == 0"> Inactive </td>
                            <td>
                                <a href="#" data-toggle="modal"
                                   data-target="#view_coupon" @click.prevent="viewCoupon(coupon)" >
                                    <i class="fa fa-eye" style="font-size:20px"></i>
                                </a>
                                <a href="#" @click.prevent="editCoupon(coupon)">
                                    <i class="fa fa-pencil" style="font-size:20px"></i>
                                </a>
                                <a href="#" class="delete_coupon" @click.prevent="deleteCoupon(coupon)">
                                    <i class="fa fa-trash" style="font-size:20px"></i>
                                </a>
                            </td>
                        </tr>
                        {{-- if no record found --}}
                        <tr v-if="coupons.code == 0" class="text-center" v-cloak>
                            <td colspan="8">@{{ coupons.message }}</td>
                        </tr>
                        {{-- //for loop --}}
                        </tbody>
                    </table>
                </div>
                <div>
                    <span v-if="!search">
                        <pagination :data="coupons" @pagination-change-page="getCoupons"
                                    style="float: right; margin-top: 10px;"></pagination>
                    </span>
                    <span v-if="search">
                        <pagination :data="coupons" @pagination-change-page="searchCoupons"
                                    style="float: right; margin-top: 10px;"></pagination>
                    </span>
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    {{--<a href="{{ route('org-create-coupon') }}" class="btn btn-danger">Create Coupon</a>--}}
                    <a href="#" data-toggle="modal"
                       data-target="#add_coupon" class="btn btn-danger">Create Coupon</a>
                </div>
            </div>
        </div>

        {{-- edit coupon --}}
        <div class="row justify-content-between" v-if="edit" v-cloak id="edit_coupon_section">
            <div class="col-xl-12">
                <div class="alert alert-danger" v-cloak v-if="error.show">
                    <h4>
                        <i class="icon fa fa-close"></i>
                        <span v-for="(value, index) in error.message">@{{ value }}</span>
                    </h4>
                </div>
                <div class="alert alert-success" v-cloak v-if="success.show">
                    <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                </div>
                <div class="setting-billing">
                    <form action="#">
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="clearfix"></div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Coupon/Discount Name *</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" v-model="coupon.coupon"
                                               placeholder="Coupon/Discount Name">
                                        <p class="error" v-if="errors.show" v-cloak>@{{ errors.coupon_code }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Coupon Description</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control" v-model="coupon.description"
                                                  style="height: 100px"
                                                  placeholder="Brief Description about Coupon"></textarea>
                                        <p class="error" v-if="errors.show" v-cloak>@{{ errors.description }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xl-4">&nbsp;</div>
                                    <label class="col-sm-2 col-form-label">Start Date *</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="start_date_update"
                                               v-model="coupon.start_date">
                                        <p class="error" v-if="errors.show" v-cloak>@{{ errors.start_date}}</p>
                                    </div>
                                    <label class="col-sm-2 col-form-label">From *</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" id="start_time_update"
                                               v-model="coupon.start_time">
                                        <p class="error" v-if="errors.show" v-cloak>@{{ errors.start_time }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xl-4">&nbsp;</div>
                                    <label class="col-sm-2 col-form-label">End Date *</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="end_date_update"
                                               v-model="coupon.end_date">
                                        <p class="error" v-if="errors.show" v-cloak>@{{ errors.end_date }}</p>
                                    </div>
                                    <label class="col-sm-2 col-form-label">To *</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" id="end_time_update"
                                               v-model="coupon.end_time">
                                        <p class="error" v-if="errors.show" v-cloak>@{{ errors.end_time }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Total Available</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" v-model="coupon.total_available"
                                               placeholder="Leave blank if unlimited">
                                        <p class="error" v-if="errors.show" v-cloak>@{{ errors.total_available }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Redeemable On *</label>
                                    <div class="col-lg-8 toggle-btn">
                                        <select class="form-control" v-model="coupon.redeem_on">
                                            <option value="">Select</option>
                                            <option v-for="(value, index) in events" :value="index">@{{ value }}
                                            </option>
                                        </select>
                                        <p class="error" v-if="errors.show" v-cloak>@{{ errors.redeem_on }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Amount/Percentage</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" v-model="coupon.amount"
                                               placeholder="Amount">
                                        <p class="error" v-if="errors.show" v-cloak>@{{ errors.amount }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">&nbsp;</label>
                                    <div class="col-lg-8">
                                        <label class="checkbox-inline" id="type-amt">
                                            <input type="radio" id="type-amt" value="amt" v-model="coupon.type"
                                                   class="Off-type">
                                            Amount Off</label>
                                        <label class="checkbox-inline" id="type-percent">
                                            <input type="radio" id="type-percent" value="%" v-model="coupon.type"
                                                   class="Off-type">
                                            Percentage(%) Off</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Status *</label>
                                    <div class="col-lg-8 toggle-btn">
                                        <select class="form-control" v-model="coupon.status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger" @click.prevent="updateCoupon">Update
                                        Coupon
                                    </button>
                                    <a class="btn btn-secondary" href="#" @click.prevent="cancelEdit">Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- //edit coupon --}}

        {{-- view coupon details --}}
        <div class="modal fade" role="dialog" id="view_coupon">
            <div class="modal-dialog">
                {{-- Modal content--}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" style="margin-top: 0;">Coupon Details</h2>
                        <button type="button" class="close" id="close_add_coupon" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <br><br>
                    <div class="modal-body">
                        <div class="setting-billing">
                            <div class="list-group">
                                <div class="clearfix"></div>
                                <div class="form-group row">
                                    <label class="col-lg-4">Coupon/Discount Name: </label>
                                    <div class="col-lg-8">
                                        @{{ coupon.coupon }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4" for="coupon_description">
                                        Coupon Description: </label>
                                    <div class="col-lg-8">
                                        @{{ coupon.description }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Start Date: </label>
                                    <div class="col-sm-8">
                                        @{{ coupon.start_date | eventStartDate }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">From: </label>
                                    <div class="col-lg-8">
                                        @{{ coupon.start_time | eventStartTime }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">End Date: </label>
                                    <div class="col-sm-8">
                                        @{{ coupon.end_date | eventStartDate }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">To: </label>
                                    <div class="col-lg-8">
                                        @{{ coupon.end_time | eventStartTime }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4">Total Available: </label>
                                    <div class="col-lg-8">
                                        <span v-if="coupon.total_available != null">@{{ coupon.total_available }}</span>
                                        <span v-if="coupon.total_available == null">&infin;</span>
                                    </div>
                                </div>

                                {{--<div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Redeemable On ( event name ): </label>
                                    <div class="col-lg-8 toggle-btn">
                                        @{{ coupon.event.event_title }}
                                    </div>
                                </div>--}}
                                <div class="form-group row">
                                    <label class="col-lg-4">Amount/Percentage: </label>
                                    <div class="col-lg-8">
                                        @{{ coupon.amount }} <span v-if="coupon.type == '%'">@{{ coupon.type }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4">Status: </label>
                                    <div class="col-lg-8 toggle-btn">
                                        <span v-if="coupon.status == 0">Inactive</span>
                                        <span v-if="coupon.status == 1">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //view coupon details --}}
    </div>




    {{-- add coupon to selected event, modal --}}
    <div class="modal fade creat-event" role="dialog" id="add_coupon">
        <div class="modal-dialog">
            {{-- Modal content--}}
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" style="margin-top: 0;">Add Coupon</h2>
                    <button type="button" class="close" id="close_add_coupon" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <br><br>
                <div class="modal-body" id="create-coupon">
                    <div class="alert alert-danger" v-cloak v-if="error.message.show">
                        <h4>
                            <i class="icon fa fa-close"></i> @{{ error.message.text }}
                            <span v-for="(value, index) in error.message.dev">@{{ value[0] }}</span>
                        </h4>
                    </div>
                    <div class="setting-billing">
                        <form action="#">
                            <div class="list-group">
                                {{--<div class="list-group-item">--}}
                                    {{--<a class="btn btn-secondary" href="{{ route('org-coupon-list') }}"
                                    style="float: right; margin-bottom: 20px;">Coupons</a>--}}
                                    <div class="clearfix"></div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Coupon/Discount Name *</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" v-model="coupon.coupon_code"
                                                   placeholder="Coupon/Discount Name">
                                            <p class="error" v-if="error.show" v-cloak>@{{ error.coupon_code }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="coupon_description">
                                            Coupon Description</label>
                                        <div class="col-lg-8">
                                            {{--<input type="text" class="form-control" v-model="coupon.description"
                                                   placeholder="Brief Description about Coupon">--}}
                                            <textarea class="form-control" v-model="coupon.description"
                                                      id="coupon_description"
                                                      placeholder="Brief Description about Coupon"></textarea>
                                            <p class="error" v-if="error.show" v-cloak>@{{ error.description }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xl-4">&nbsp;</div>
                                        <label class="col-sm-2 col-form-label">Start Date *</label>
                                        <div class="col-sm-2">
                                            <input type="text" id="start_date" placeholder="YYYY-MM-DD"
                                                   class="form-control" v-model="coupon.start_date">
                                            <p class="error" v-if="error.show" v-cloak>@{{ error.start_date}}</p>
                                        </div>
                                        <label class="col-sm-2 col-form-label">From *</label>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control" id="start_time"
                                                   placeholder="HH:MM"
                                                   v-model="coupon.start_time">
                                            <p class="error" v-if="error.show" v-cloak>@{{ error.start_time }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xl-4">&nbsp;</div>
                                        <label class="col-sm-2 col-form-label">End Date *</label>
                                        <div class="col-sm-2">
                                            <input type="text" id="end_date" placeholder="YYYY-MM-DD"
                                                   class="form-control" v-model="coupon.end_date">
                                            <p class="error" v-if="error.show" v-cloak>@{{ error.end_date }}</p>
                                        </div>
                                        <label class="col-sm-2 col-form-label">To *</label>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control" id="end_time"
                                                   placeholder="HH:MM"
                                                   v-model="coupon.end_time">
                                            <p class="error" v-if="error.show" v-cloak>@{{ error.end_time }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Total Available</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" v-model="coupon.total_available"
                                                   placeholder="Leave blank if unlimited">
                                            <p class="error" v-if="error.show" v-cloak>@{{ error.total_available }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Redeemable On *</label>
                                        <div class="col-lg-8 toggle-btn">
                                            <select class="form-control" v-model="coupon.redeem_on">
                                                <option value="">select</option>
                                                <option v-for="(value, index) in events"
                                                        :value="index">@{{ value }}</option>
                                            </select>
                                            <p class="error" v-if="error.show" v-cloak>@{{ error.redeem_on }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Amount/Percentage</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" v-model="coupon.amount"
                                                   placeholder="Amount">
                                            <p class="error" v-if="error.show" v-cloak>@{{ error.amount }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">&nbsp;</label>
                                        <div class="col-lg-8">
                                            <label class="checkbox-inline" id="type-amt">
                                                <input type="radio" id="type-amt" value="amt"
                                                       v-model="coupon.type" class="Off-type">
                                                Amount Off</label>
                                            <label class="checkbox-inline" id="type-percent">
                                                <input type="radio" id="type-percent" value="%"
                                                       v-model="coupon.type" class="Off-type">
                                                Percentage(%) Off</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="coupon_status">Status</label>
                                        <div class="col-lg-8 toggle-btn">
                                            <select class="form-control" id="coupon_status"
                                                    v-model="coupon.status">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-danger"
                                                @click.prevent="createCoupon">Create Coupon</button>
                                    </div>
                                {{--</div>--}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- //add coupon to selected event, modal --}}

@endsection

@section('after-script')

@endsection