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
                    <span class="ml-1">Promoter Profile</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Promoter</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xl-12 col-xxl-12">
				<div class="box box-primary">
					<div class="text-center">
						<img class="profile-user-img img-circle" src="{{URL::asset('public/assets/images/avatar5.png')}}" alt="User profile picture">
						<h3 class="profile-username text-center">{{$promoterData->full_name}}</h3>
						<p class="text-muted text-center">{!!html_entity_decode($promoterData->about_promoter)!!}</p>
					</div>
				</div>
				<div class="card">
                    <div class="card-body">
						<div class="basic-form">
    						<div class="form-row">
    							<div class="form-group col-md-6">
        							<b>First Name</b> : {{$promoterData->first_name}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Last Name</b> : {{$promoterData->last_name}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Email</b> : {{$promoterData->email}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Mobile Number</b> : {{$promoterData->mobile_number}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Address</b> : {{$promoterData->location}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Unique Url</b> : {{$promoterData->unique_url}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Website</b> : {{$promoterData->website}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Facebook</b> : {{$promoterData->fb_url}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Instagram</b> : {{$promoterData->insta_url}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Twitter</b> : {{$promoterData->twitter}}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Snapchat</b> : {{$promoterData->snapchat}}
        						</div>
        						<div class="form-group col-md-6 mb-0">
    								<b>Status</b> : <small class="label bg-{{$promoterData->status?'green':'red'}}">{{$promoterData->status?'Active':'Inactive'}}</small>
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