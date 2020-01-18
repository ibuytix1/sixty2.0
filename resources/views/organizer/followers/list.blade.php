@extends('organizer.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Following</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container" id="my-followers-list">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group custom-search">
                            <label style="width: 100%">
                                <input type="text" class="form-control" placeholder="Search Followers"
                                       v-model="searchFollowers">
                            </label>
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-wrapper table-responsive col-sm-12">
                    <!--Table-->
                    <table class="table table-hover mb-0">
                        <!--Table head-->
                        <thead>
                        <tr>
                            <th scope="col">User First Name</th>
                            <th scope="col">User Last Name</th>
                            <th scope="col">User Email</th>
                            <th scope="col">User Type</th>
                            <th scope="col">Following From</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <!-- //Table head-->
                        <!--Table body-->
                        <tbody>
                        <tr v-if="followers.data" v-for="follower in followers.data">
                            <td>@{{ follower.user.first_name }}</td>
                            <td>@{{ follower.user.last_name }}</td>
                            <td><a :href="'mailto:' + follower.user.email">@{{ follower.user.email }}</a></td>
                            <td v-show="follower.user.user_type == 1">User</td>
                            <td v-show="follower.user.user_type == 3">Promoter</td>
                            <td v-show="follower.user.user_type == 2">Organizer</td>
                            <td>@{{ follower.created_at | eventStartDate }}</td>
                            <td>
                                <a href="#" title="View User's Details"
                                   data-toggle="modal" data-target="#user-modal"
                                   @click="showUserDetails(follower.user)">
                                    <i class="fa fa-eye" style="font-size:20px"></i>
                                </a>
                            </td>
                        </tr>

                        <tr v-if="followers.code == 0">
                            <td colspan="9" class="text-center">@{{ followers.message }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <pagination :data="followers" @pagination-change-page="getFollowers"
                            style="float: right; margin-top: 10px;"></pagination>
            </div>
        </div>

        {{-- view coupon details --}}
        <div class="modal fade" role="dialog" id="user-modal">
            <div class="modal-dialog">
                 Modal content
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" style="margin-top: 0;">Organizer Details</h2>
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
                                    <label class="col-lg-4">User Name: </label>
                                    <div class="col-lg-8">
                                        @{{ user.first_name }} @{{ user.last_name }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">About user: </label>
                                    <div class="col-sm-8">
                                        @{{ user.about_organizer }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">User Email: </label>
                                    <div class="col-lg-8">
                                        @{{ user.email }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">User Url: </label>
                                    <div class="col-sm-8">
                                        @{{ user.unique_url }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Facebook: </label>
                                    <div class="col-lg-8">
                                        @{{ user.fb_url }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4">Twitter: </label>
                                    <div class="col-lg-8">
                                        @{{ user.twitter }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4">Snapchat: </label>
                                    <div class="col-lg-8">
                                        @{{ user.snapchat }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4">Instagram: </label>
                                    <div class="col-lg-8">
                                        @{{ user.insta_url }}
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
@endsection