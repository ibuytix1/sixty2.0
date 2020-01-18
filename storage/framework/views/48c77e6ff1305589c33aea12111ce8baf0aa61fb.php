<?php $adminURL = config('constants.ADMIN_URL'); ?>

<?php echo $__env->make('admin.include.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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
						<img class="profile-user-img img-circle" src="<?php echo e(URL::asset('public/assets/images/avatar5.png')); ?>" alt="User profile picture">
						<h3 class="profile-username text-center"><?php echo e($organizerData->full_name); ?></h3>
						<p class="text-muted text-center"><?php echo e($organizerData->about_organizer); ?></p>
					</div>
				</div>
				<div class="card">
                    <div class="card-body">
						<div class="basic-form">
    						<div class="form-row">
    							<div class="form-group col-md-6">
        							<b>Full Name</b> : <?php echo e($organizerData->full_name); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>First Name</b> : <?php echo e($organizerData->first_name); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Last Name</b> : <?php echo e($organizerData->last_name); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Email</b> : <?php echo e($organizerData->email); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Mobile Number</b> : <?php echo e($organizerData->mobile_number); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Address</b> : <?php echo e($organizerData->location); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Unique Url</b> : <?php echo e($organizerData->unique_url); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Website</b> : <?php echo e($organizerData->website); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Facebook</b> : <?php echo e($organizerData->fb_url); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Instagram</b> : <?php echo e($organizerData->insta_url); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Twitter</b> : <?php echo e($organizerData->twitter); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Snapchat</b> : <?php echo e($organizerData->snapchat); ?>

        						</div>
        						<div class="form-group col-md-6 mb-0">
    								<b>Status</b> : <small class="label bg-<?php echo e($organizerData->status?'green':'red'); ?>"><?php echo e($organizerData->status?'Active':'Inactive'); ?></small>
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

<?php echo $__env->make('admin.include.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>