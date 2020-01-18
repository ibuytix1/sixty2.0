@extends('user.include.app')

@section('content')
    <div id="user-profile">
        <div id="my-profile" v-if="profile">
            <div class="content-body">
                <div class="container">
                    <div class="my_account_details">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="edit_profile">
                                    <h3>@{{ my.first_name }} @{{ my.last_name }}</h3>
                                    <h5>Fan since @{{ my.created_at | eventStartDate }}</h5>
                                    <button class="edit_profile_btn"
                                            @click.prevent="editProfile = true; profile = false;
                                             error.show = false">
                                        Edit Profile
                                    </button>
                                    <div class="clearfix"></div>
                                    <div class="email_panel">
                                        <p>Email Address<span>@{{ my.email }}</span></p>
                                    </div>
                                    <div class="email_panel no_border">
                                        <p>Phone Number<span>@{{ my.mobile_number }}</span></p>
                                        <button class="edit_text"
                                                @click.prevent="editProfile = true; profile = false;
                                                error.show = false">
                                            Edit Phone Number
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="acount_health_div">
                                            <div class="icon_div">
                                                <img src="{{ asset('public/images/account_health_checkup.jpg') }}"
                                                     alt="">
                                            </div>
                                            <div class="content_div">
                                                <h3>Account Health Check-Up</h3>
                                                <p>Been a while? Consider changing your password to protect your
                                                    account.</p>
                                                <button class="update_pass_btn"
                                                        @click.prevent="editProfile = true; profile = false;
                                                        error.show = false">
                                                    Update Password
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="acount_health_div">
                                            <div class="icon_div">
                                                <img src="{{ asset('public/images/fast_and_easy_checkup.jpg') }}"
                                                     alt="">
                                            </div>
                                            <div class="content_div">
                                                <h3>Account Health Check-Up</h3>
                                                <p>Been a while? Consider changing your password to protect your
                                                    account.</p>
                                                <a href="{{ route('user-manage-accounts') }}" class="update_pass_btn">
                                                    Update Payment
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="acount_health_div">
                                            <div class="icon_div">
                                                <img src="{{ asset('public/images/heart_icon.png') }}" alt="">
                                            </div>
                                            <div class="content_div">
                                                <h3>Account Health Check-Up</h3>
                                                <p>Been a while? Consider changing your password to protect your
                                                    account.</p>
                                                <button class="update_pass_btn">
                                                    View Events
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="acount_health_div_events_new">
                                            <div class="icon_div">
                                                <img src="{{ asset('public/images/email_icon.png') }}" alt="">
                                            </div>
                                            <div class="content_div">
                                                <h3>Get Event News You Want</h3>
                                                <p>Been a while? Consider changing your password to protect your
                                                    account.Been a
                                                    while? Consider changing your password to protect your account.Been
                                                    a while?
                                                    Consider changing your password to protect your account.</p>

                                            </div>
                                            <button class="update_pass_btn">
                                                View Subscriptions
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="edit-my-profile" v-if="editProfile">
            <div class="content-body">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="setting-personal">
                                <form action="#">
                                    <div id="success" v-if="success.show" v-cloak>
                                        <div class="alert alert-success">
                                            <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                                        </div>
                                    </div>

                                    <div id="error" v-if="error.show" v-cloak>
                                        <div class="alert alert-danger">
                                            <h4><i class="icon fa fa-close"></i> @{{ error.message }}</h4>
                                        </div>
                                    </div>
                                    <div class="list-group">
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label" for="username">PROMOTER
                                                    NAME</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="username"
                                                           :value="my.first_name + ' ' + my.last_name" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label" for="val-username">FIRST
                                                    NAME</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="val-username"
                                                           name="first_name"
                                                           placeholder="" v-model="my.first_name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label" for="val-username-last">LAST
                                                    NAME</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="val-username-last"
                                                           name="last_name"
                                                           placeholder="" v-model="my.last_name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">WEBSITE</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="website"
                                                           placeholder="www.yoursite.com" v-model="my.website">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="cityLat" name="cityLat"/>
                                        <input type="hidden" id="cityLng" name="cityLng"/>
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">MOBILE</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="mobile_number"
                                                           placeholder="Mobile no" v-model="my.mobile_number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">ABOUT</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="about_organizer"
                                                           placeholder="Describe your self here..."
                                                           v-model="my.about_organizer" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">LOCATION</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control b-r-0"
                                                               v-model="my.location" id="searchTextField"
                                                               name="location">
                                                        <span class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-crosshairs"></i>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label" for="old_password">
                                                    Old Password</label>
                                                <div class="col-lg-6">
                                                    <input type="password" class="form-control"
                                                           id="old_password"
                                                           name="last_name"
                                                           placeholder="" v-model="my.old_password" required>
                                                    <p class="error" v-if="error.my.show">
                                                        @{{ error.my.old_password }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label" for="new_password">
                                                    New Password</label>
                                                <div class="col-lg-6">
                                                    <input type="password" class="form-control"
                                                           id="new_password"
                                                           name="new_password"
                                                           placeholder="" v-model="my.new_password" required>
                                                    <p class="error" v-if="error.my.show">
                                                        @{{ error.my.new_password }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label" for="confirm_new_password">
                                                    Repeat New Password</label>
                                                <div class="col-lg-6">
                                                    <input type="password" class="form-control"
                                                           id="confirm_new_password"
                                                           name="confirm_new_password"
                                                           placeholder="" v-model="my.new_password_confirmation"
                                                           required>
                                                    <p class="error" v-if="error.my.show">
                                                        @{{ error.my.new_password_confirmation }}
                                                    </p>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button @click.prevent="updatePassword"
                                                            class="btn btn-info">Update Password</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item text-center">
                                            <a href="#"
                                               @click.prevent="editProfile = false; profile = true; error.show = false"
                                               class="btn btn-secondary"
                                               style="background-color: #e53632; color: #fff; border-color: #e53632;"
                                            >
                                                BACK
                                            </a>
                                            <button class="btn btn-secondary" @click.prevent="saveProfileDetails">SAVE
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="event-sideber">
                                <h4>ADD SOCIAL ACCOUNT</h4>
                                <form action="#">
                                    <div class="row form-material m-b-30">
                                        <div class="col-md-12">
                                            <label class="col-lg-3 col-form-label">FACEBOOK</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Http://www.facebook.com/"
                                                   v-model="my.fb_url" name="fb_url">
                                        </div>
                                    </div>
                                    <div class="row form-material m-b-30">
                                        <div class="col-md-12">
                                            <label class="col-lg-3 col-form-label">TWITTER</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Http://www.twitter.com/"
                                                   v-model="my.twitter" name="twitter">
                                        </div>
                                    </div>
                                    <div class="row form-material m-b-30">
                                        <div class="col-md-12">
                                            <label class="col-lg-3 col-form-label">INSTAGRAM</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Http://www.instagram.com/"
                                                   v-model="my.insta_url" name="insta_url">
                                        </div>
                                    </div>
                                    <div class="row form-material m-b-30">
                                        <div class="col-md-12">
                                            <label class="col-lg-3 col-form-label">SNAPCHAT</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Http://www.snapchat.com/"
                                                   v-model="my.snapchat" name="snapchat">
                                        </div>
                                    </div>
                                    <button class="btn btn-secondary" @click.prevent="saveSocialDetails" type="submit">
                                        SAVE
                                    </button>
                                </form>
                                <div class="sideber-social">
                                    <h4 class=" m-t-30">ADDED -</h4>
                                    <a :href="my.fb_url"><i class="fa fa-facebook"></i></a>
                                    <a :href="my.twitter"><i class="fa fa-twitter"></i></a>
                                    <a :href="my.insta_url"><i class="fa fa-instagram"></i></a>
                                    <a :href="my.snapchat"><i class="fa fa-snapchat"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection