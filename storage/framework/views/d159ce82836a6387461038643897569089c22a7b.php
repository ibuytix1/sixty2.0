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
                    <span class="ml-1">Add Promoter</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Promoter</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Promoter</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body">
						<?php echo e(Form::open(array('url' => config('constants.ADMIN_URL').'saveOrganizer','method' => 'post', 'id' => 'm_form_addOrganizer', 'files' => false))); ?>

							<?php if(session('success_msg')): ?>
								<div class="alert alert-success alert-dismissible col-md-12 mb-0">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h4><i class="icon fa fa-check"></i> Alert!</h4>
									<?php echo e(session('success_msg')); ?>

								</div>
							<?php endif; ?>
							
							<?php if(count($errors) > 0): ?>
								<div class="alert alert-danger alert-dismissible col-md-12 mb-0">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h4><i class="icon fa fa-ban"></i> Alert!</h4>
									<ul>
										<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li><?php echo e($error); ?></li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								</div>
							<?php endif; ?>
                            <div class="basic-form">
                            	<div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="full_name">First Name</label>
                                <input type="text" class="form-control" id="full-name" placeholder="Enter full name" name="first_name" required value="<?php echo e(old('first_name')); ?>">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
    	                                <label for="full_name">Last Name</label>
                                <input type="text" class="form-control" id="full-name" placeholder="Enter full name" name="last_name" required value="<?php echo e(old('last_name')); ?>">
	                                </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                		<input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required onblur="duplicateEmail(this)" value="<?php echo e(old('email')); ?>">
                                		<div id="success"></div>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
    	                                <label for="mobile_number">Mobile No</label>
                                <input type="text" class="form-control" id="mobile_number" placeholder="Enter mobile no" name="mobile_number" value="<?php echo e(old('mobile_number')); ?>">
	                                </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="website">Website</label>
										<input type="text" class="form-control" id="website" placeholder="Web site URL" name="website" value="<?php echo e(old('website')); ?>">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
    	                                <label for="password">Password</label>
		                                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required value="<?php echo e(old('password')); ?>">
	                                </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="searchTextField">Address</label>
										<input type="text" class="form-control" id="searchTextField" placeholder="Enter Address" name="location" value="<?php echo e(old('location')); ?>">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
    	                                <label for="fb_url">Facebook</label>
		                                <input type="text" class="form-control" id="fb_url" placeholder="Facebook account " name="fb_url" value="<?php echo e(old('fb_url')); ?>">
	                                </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="unique_url">Unique Url</label>
										<input type="text" class="form-control" id="unique_url" placeholder="Enter Snapchat account" name="unique_url" value="<?php echo e(old('unique_url')); ?>">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
    	                                <label for="insta_url">Instagram</label>
		                                <input type="text" class="form-control" id="insta_url" placeholder="Enter Instagram account" name="insta_url" value="<?php echo e(old('insta_url')); ?>">
	                                </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="snapchat">Snapchat</label>
										<input type="text" class="form-control" id="snapchat" placeholder="Enter Snapchat account" name="snapchat" value="<?php echo e(old('snapchat')); ?>">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
    	                                <label for="twitter">Twitter</label>
		                                <input type="text" class="form-control" id="twitter" placeholder="Enter twitter account" name="twitter" value="<?php echo e(old('twitter')); ?>">
	                                </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="about_Organizer">About Organizer</label>
										<textarea class="form-control" rows="3" id="about_Organizer" placeholder="About organizer..." name="about_Organizer"><?php echo e(old('about_Organizer')); ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 pl-0">
                                	<button type="submit" class="btn btn-primary">Submit</button>
                            	</div>
                            </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<!--**********************************
    Content body end
***********************************-->
<script type="text/javascript">

    function duplicateEmail(element) 
    {
        var email = $(element).val();
        $.ajax({
            type: "get",
            url: "<?php echo e(url('Organizer/checkemail')); ?>",
            data: { email: email },
            dataType: "json",
            success: function (res) {
                if (res == 1) 
                {
                    $('#success').html('Already exist please enter diffrent').css("color", 'red');
                    $('#m_login_signin_submit').prop("disabled", true);
                } 
                else 
                {
                    $('#success').html('')
                    $('#m_login_signin_submit').prop("disabled", false);
                }
            },
            error: function (jqXHR, exception) {}
        });
    }

    function initialize() 
    {
        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById('cityLat').value = place.geometry.location.lat();
            document.getElementById('cityLng').value = place.geometry.location.lng();
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<?php echo $__env->make('admin.include.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>