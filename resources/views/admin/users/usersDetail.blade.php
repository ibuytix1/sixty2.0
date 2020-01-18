<?php $adminURL = config('constants.ADMIN_URL'); ?>

@include('admin.include.header')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
    	<div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="breadcrumb-range-picker">
                    <span><i class="icon-calender"></i></span>
                    <span class="ml-1">User Details</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">User Details</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xl-12 col-xxl-12">
				<div class="box box-primary">
					<div class="text-center">
						<img class="profile-user-img img-circle" src="{{URL::asset('public/assets/images/avatar5.png')}}" alt="User profile picture">
						<h3 class="profile-username text-center">{{ $user->full_name }}</h3>
						<p class="text-muted text-center">{{ $user->about_promoter }}</p>
					</div>
				</div>
				<div class="card">
                    <div class="card-body">
						<div class="basic-form">
    						<div class="form-row">
    							{{--<div class="form-group col-md-6">
        							<b>Full Name</b> : {{$user->full_name}}
        						</div>--}}
        						<div class="form-group col-md-6">
        							<b>First Name</b> : {{$user->first_name}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Last Name</b> : {{$user->last_name}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Email</b> : {{$user->email}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Mobile Number</b> : {{$user->mobile_number}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Address</b> : {{$user->location}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Unique Url</b> : {{$user->unique_url}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Website</b> : {{$user->website}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Facebook</b> : {{$user->fb_url}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Instagram</b> : {{$user->insta_url}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Twitter</b> : {{$user->twitter}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Snapchat</b> : {{$user->snapchat}}
        						</div>
        						<div class="form-group col-md-6 mb-0">
    								<b>Status</b> : <small class="label bg-{{$user->status?'green':'red'}}">{{$user->status?'Active':'Inactive'}}</small>
        						</div>
    						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--**********************************
    Content body end
***********************************-->

@include('admin.include.footer')