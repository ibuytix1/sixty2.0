@extends('promoter.include.app')
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
    <div class="container" id="my-following-list">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <br>
                <div class="table-wrapper table-responsive col-sm-12">
                    <!--Table-->
                    <table class="table table-hover mb-0">
                        <!--Table head-->
                        <thead>
                        <tr>
                            <th scope="col">Organizer First Name</th>
                            <th scope="col">Organizer Last Name</th>
                            <th scope="col">Organizer Email</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <!-- //Table head-->
                        <!--Table body-->
                        <tbody>
                        <tr v-if="following.data" v-for="follow in following.data">
                            <td>@{{ follow.organizer.first_name }}</td>
                            <td>@{{ follow.organizer.last_name }}</td>
                            <td><a :href="'mailto:' + follow.organizer.email">@{{ follow.organizer.email }}</a></td>
                            <td>
                                <a href="#" title="View Organizer's Details"
                                   data-toggle="modal" data-target="#organizer-modal"
                                   @click="showOrgDetails(follow.organizer)">
                                    <i class="fa fa-eye" style="font-size:20px"></i>
                                </a>
                                <a href="#" title="Unfollow Organizer"
                                   @click="unfollowOrganizer(follow.organizer)">
                                    <i class="fa fa-user-times" style="font-size:20px"></i>
                                </a>
                            </td>
                        </tr>

                        <tr v-if="!following.data">
                            <td colspan="9" class="text-center">data not available</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <pagination :data="following" @pagination-change-page="getFollowing"
                            style="float: right; margin-top: 10px;"></pagination>
            </div>
        </div>

        {{-- view coupon details --}}
        <div class="modal fade" role="dialog" id="organizer-modal">
            <div class="modal-dialog">
                {{-- Modal content--}}
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
                                    <label class="col-lg-4">Organizer Name: </label>
                                    <div class="col-lg-8">
                                        @{{ organizer.first_name }} @{{ organizer.last_name }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">About Organizer: </label>
                                    <div class="col-sm-8">
                                        @{{ organizer.about_organizer }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Organizer Email: </label>
                                    <div class="col-lg-8">
                                        @{{ organizer.email }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Organizer Url: </label>
                                    <div class="col-sm-8">
                                        @{{ organizer.unique_url }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Facebook: </label>
                                    <div class="col-lg-8">
                                        @{{ organizer.fb_url }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4">Twitter: </label>
                                    <div class="col-lg-8">
                                        @{{ organizer.twitter }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4">Snapchat: </label>
                                    <div class="col-lg-8">
                                        @{{ organizer.snapchat }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4">Instagram: </label>
                                    <div class="col-lg-8">
                                        @{{ organizer.insta_url }}
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