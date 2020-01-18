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
                    <span class="ml-1">CMS Pages</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">CMS Pages</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit CMS Pages</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body">
						<?php echo e(Form::open(array('url' => config('constants.ADMIN_URL').'save-cms-pages','method' => 'post', 'id' => 'm_form_saveCmsPages', 'files' => false))); ?>

							<input type="hidden" name="pageId" value="<?php echo e($data->id); ?>">
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
                                    <div class="form-group col-md-12">
                                        <label for="title">title</label>
                                		<input type="text" class="form-control" id="title" name="title" value="<?php echo e($data->title); ?>" placeholder="Title">
                                    </div>
                                    
                                    <div class="form-group col-md-12">
    	                                <label for="page_description">Description</label>
                                		<textarea class="form-control" rows="20" placeholder="Page Content ....." cols="30" id="description" required name="page_description"><?php echo e($data->page_description); ?></textarea>
	                                </div>
                                
                                    <div class="form-group col-md-12">
                                        <label for="page_title">Page Title</label>
                                		<textarea class="form-control" rows="3" id="page_title" name="page_title" placeholder="Page Title."><?php echo e($data->page_title); ?></textarea>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
    	                                <label for="page_keyword">Page Keyword</label>
                                		<textarea class="form-control" rows="3" id="page_title" name="page_keyword" placeholder="Page Keyword."><?php echo e($data->page_keyword); ?></textarea>
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
<script>
    $(function () 
    {
    	CKEDITOR.replace('description')
    	$('.textarea').wysihtml5()
    });
</script>
<?php echo $__env->make('admin.include.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>