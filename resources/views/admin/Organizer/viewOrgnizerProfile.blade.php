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
                    <span class="ml-1">Edit Organizer</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Organizer</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Organizer</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xl-12 col-xxl-12">
				<div class="box box-primary">
					<div class="text-center">
						<img class="profile-user-img img-circle" src="{{URL::asset('public/assets/images/avatar5.png')}}" alt="User profile picture">
						<h3 class="profile-username text-center">{{$organizerData->full_name}}</h3>
						<p class="text-muted text-center">{{$organizerData->about_organizer}}</p>
					</div>
				</div>
				<div class="card">
                    <div class="card-body">
						<div class="basic-form">
    						<div class="form-row">
    							<div class="form-group col-md-6">
        							<b>Full Name</b> : {{$organizerData->full_name}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>First Name</b> : {{$organizerData->first_name}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Last Name</b> : {{$organizerData->last_name}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Email</b> : {{$organizerData->email}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Mobile Number</b> : {{$organizerData->mobile_number}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Address</b> : {{$organizerData->location}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Unique Url</b> : {{$organizerData->unique_url}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Website</b> : {{$organizerData->website}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Facebook</b> : {{$organizerData->fb_url}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Instagram</b> : {{$organizerData->insta_url}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Twitter</b> : {{$organizerData->twitter}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Snapchat</b> : {{$organizerData->snapchat}}
        						</div>
        						<div class="form-group col-md-6 mb-0">
    								<b>Status</b> : <small class="label bg-{{$organizerData->status?'green':'red'}}">{{$organizerData->status?'Active':'Inactive'}}</small>
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