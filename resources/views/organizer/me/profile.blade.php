@extends('organizer.include.app')

@section('content')
    <div id="org-profile">
        <div id="my-profile" v-if="profile">
            <div class="page-title">
                <div class="container">
                    <div class="row">
                        <div class="col-5">
                            <h1>Organizers Profile</h1>
                        </div>
                        <div class="col-7">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('org-home') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="container">
                    <div class="event-modal event-profile">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="row">
                                    <div class="col-xl-8 p-r-0">
                                        <div class="modal-right">
                                            <div class="media personal-profile">
                                                <img class="m-r-30 img-fluid"
                                                     src="{{URL::asset('public/assets/images/peoples/ppl.png')}}"
                                                     alt="placeholder image">
                                                <div class="media-body">
                                                    <h3 class="mt-0">@{{ my.first_name }} @{{ my.last_name }}</h3>
                                                    <p class="denger"><i
                                                                class="fa fa-map-marker"></i>@{{ my.location }}
                                                    </p>
                                                    <p class="">@{{ my.website }}</p>
                                                    <p class="">@{{ my.email }}</p>
                                                    <p class="">@{{ my.unique_url }}</p>
                                                </div>
                                                <a href="#"
                                                   @click.prevent="editProfile = true; profile = false; error.show = false"
                                                   class="btn btn-secondary">EDIT</a>
                                            </div>

                                            <div class="modal-about-area">
                                                <h3>ABOUT ORGANIZER</h3>
                                                <p>@{{ my.about_organizer }}</p>

                                                <a :href="my.fb_url"
                                                   class="fa fa-facebook fa-2x"></a> &nbsp;
                                                <a :href="my.twitter"
                                                   class="fa fa-twitter fa-2x"></a> &nbsp;
                                                <a :href="my.insta_url"
                                                   class="fa fa-instagram fa-2x"></a> &nbsp;
                                                <a :href="my.snapchat"
                                                   class="fa fa-snapchat fa-2x"></a>
                                            </div>

                                            <div class="modal-tags">
                                                <h3>EVENT INTEREST</h3>
                                                <button class="btn btn-outline-secondary btn-rounded">Conferences
                                                </button>
                                                <button class="btn btn-outline-secondary btn-rounded">Music</button>
                                                <button class="btn btn-outline-secondary btn-rounded">Concert</button>
                                                <button class="btn btn-outline-secondary btn-rounded">Summer Jamz
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 p-l-0">
                                        <div class="modal-left">
                                            <!-- Nav tabs -->

                                            <ul class="nav nav-tabs" role="tablist">

                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#profile">EVENT
                                                        CREATED</a>
                                                </li>

                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="home" role="tabpanel">
                                                    {{-- DISPLAY EVENT SECTION --}}
                                                    <div class="media" v-for="event in events.data">

                                                        <img v-if="event.r_e_l__event__image != ''"
                                                             class="m-r-15 img-fluid profile-event-image"
                                                             :src="imagePath + event.r_e_l__event__image[0].image_name"
                                                             alt="placeholder image">
                                                        <img v-if="event.r_e_l__event__image == ''"
                                                             class="m-r-15 img-fluid"
                                                             src="{{URL::asset('public/assets/images/peoples/modl-ryt.jpg')}}"
                                                             alt="placeholder image">
                                                        <div class="media-body">
                                                            <a href="#" class="mt-0">@{{ event.event_title }}</a>
                                                            <p>
                                                                <i class="fa fa-map-marker">@{{ event.address }}</i></p>
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                    <pagination :data="events" :offset="3"
                                                                @pagination-change-page="getMyEvents"></pagination>
                                                    {{-- //DISPLAY EVENT SECTION --}}
                                                </div>
                                            </div>
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
            <div class="page-title">
                <div class="container">
                    <div class="row">
                        <div class="col-5">
                            <h1>Profile Settings</h1>
                        </div>
                        <div class="col-7">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('org-home') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

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
                                                <label class="col-lg-3 col-form-label" for="username">ORGANIZER
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
                                                <label class="col-lg-3 col-form-label" for="val-username">LAST
                                                    NAME</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="val-username"
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
                                                <label class="col-lg-3 col-form-label">iBuyTix URL</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="unique_url"
                                                           placeholder="www.ibuytix.com/organizername"
                                                           v-model="my.unique_url">
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
                                <h4>ADD EVENT INTEREST</h4>
                                <div class="sideber-meta">
                                    <button class="btn btn-outline-secondary">Conferences</button>
                                    <button class="btn btn-outline-secondary">Music</button>
                                    <button class="btn btn-outline-secondary">Concert</button>
                                    <button class="btn btn-outline-secondary">Summer Jamz</button>
                                    <button class="btn btn-secondary">Add</button>
                                </div>
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






@endsection