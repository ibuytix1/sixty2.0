@extends('organizer.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Create Coupon</h1>
                    <h3>Enter your Event Coupon Details</h3>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('content')
    {{--<div class="container" id="create-coupon">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <h3><b>Basic Information</b></h3>
                <div class="alert alert-danger" v-cloak v-if="error.events.show">
                    <h4><i class="icon fa fa-close"></i> @{{ error.events.message }}</h4>
                </div>
                <div class="alert alert-danger" v-cloak v-if="error.message.show">
                    <h4>
                        <i class="icon fa fa-close"></i> @{{ error.message.text }}
                        <span v-for="(value, index) in error.message.dev">@{{ value[0] }}</span>
                    </h4>
                </div>
                <div class="alert alert-success" v-cloak v-if="success.show">
                    <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                </div>
                <div class="setting-billing">
                    <form action="#">
                        <div class="list-group">
                            <div class="list-group-item">
                                --}}{{--<a class="btn btn-secondary" href="{{ route('org-coupon-list') }}" style="float: right; margin-bottom: 20px;">Coupons</a>--}}{{--
                                <div class="clearfix"></div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Coupon/Discount Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" v-model="coupon.coupon_code"
                                               placeholder="Coupon/Discount Name">
                                        <p class="error" v-if="error.show" v-cloak>@{{ error.coupon_code }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Coupon Description</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" v-model="coupon.description"
                                               placeholder="Brief Description about Coupon">
                                        <p class="error" v-if="error.show" v-cloak>@{{ error.description }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xl-4">&nbsp;</div>
                                    <label class="col-sm-2 col-form-label">Start Date</label>
                                    <div class="col-sm-2">
                                        <input type="text" id="start_date" placeholder="YYYY-MM-DD"
                                               class="form-control" v-model="coupon.start_date">
                                        <p class="error" v-if="error.show" v-cloak>@{{ error.start_date}}</p>
                                    </div>
                                    <label class="col-sm-2 col-form-label">From</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" id="start_time"
                                               placeholder="HH:MM"
                                               v-model="coupon.start_time">
                                        <p class="error" v-if="error.show" v-cloak>@{{ error.start_time }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-xl-4">&nbsp;</div>
                                    <label class="col-sm-2 col-form-label">End Date</label>
                                    <div class="col-sm-2">
                                        <input type="text" id="end_date" placeholder="YYYY-MM-DD"
                                               class="form-control" v-model="coupon.end_date">
                                        <p class="error" v-if="error.show" v-cloak>@{{ error.end_date }}</p>
                                    </div>
                                    <label class="col-sm-2 col-form-label">To</label>
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
                                    <label class="col-lg-4 col-form-label">Redeemable On</label>
                                    <div class="col-lg-8 toggle-btn">
                                        <select class="form-control" v-model="coupon.redeem_on">
                                            <option value="">select</option>
                                            <option v-for="(value, index) in events" :value="index">@{{ value }}</option>
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
                                            <input type="radio" id="type-amt" value="amt" v-model="coupon.type" class="Off-type">
                                            Amount Off</label>
                                        <label class="checkbox-inline" id="type-percent">
                                            <input type="radio" id="type-percent" value="%" v-model="coupon.type" class="Off-type">
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
                            </div>
                        </div>
                    </form>
                    --}}{{--{{Form::close()}}--}}{{--
                </div>
            </div>
        </div>
    </div>--}}

@endsection
@section('after-script')

@endsection