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
                    <span class="ml-1">Event Detail <small>Preview</small></span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Event</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Preview</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xl-12 col-xxl-12">
				<div class="box box-primary">
					<div class="text-center">
						<h3 class="profile-username text-center"><?php echo e($event->event_title); ?></h3>
						<p class="text-muted text-center"><?php echo html_entity_decode($event->event_description); ?></p>
					</div>
				</div>
				<div class="card">
                    <div class="card-body">
						<div class="basic-form">
    						<div class="form-row">
    							<div class="form-group col-md-12 text-center"> <h3>Event Details</h3> </div>
    							<div class="form-group col-md-6">
        							<b>Created At</b> : <?php echo e($event->created_at); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Start Date</b> : <?php echo e($event->start_date); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Start Time</b> : <?php echo e($event->start_time); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>End Date</b> : <?php echo e($event->end_date); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>End Time</b> : <?php echo e($event->end_time); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>URL</b> : <a href="<?php echo e(url('/event/' . $event->event_url)); ?>"> <?php echo e(url('/event/' . $event->event_url)); ?> </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Location</b> : <?php echo e($event->event_location); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Category</b> : <?php echo e($event->REL_Event_Category->category_name); ?>

        						</div>
        						<?php if($event->REL_event_subcategory): ?>
            						<div class="form-group col-md-6">
            							<b>Sub Category</b> : <?php echo e($event->REL_event_subcategory->subcategory_name); ?>

            						</div>
        						<?php endif; ?>
    						</div>
    						
    						<?php if($event->is_recurring): ?>
	    						<div class="form-group col-md-12 text-center"> <h3>Event Occurrence Details</h3> </div>
            						<div class="form-group col-md-6">
            							<b>Occurrence Start Time</b> : <?php echo e($event->occurrence_start_time); ?>

            						</div>
            						<div class="form-group col-md-6">
            							<b>Occurrence End Time</b> : <?php echo e($event->occurrence_end_time); ?>

            						</div>
            						<div class="form-group col-md-6">
            							<b>Occurrence From</b> : <?php echo e($event->occurrence_from_date); ?>

            						</div>
            						<div class="form-group col-md-6 mb-0">
        								<b>Occurrence To</b> : <?php echo e($event->occurence_to_date); ?>

            						</div>
    							</div>
							<?php endif; ?>
							
							<?php $__currentLoopData = $event->REL_Event_Image; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="form-group col-md-12"> <h3>Event Images</h3> </div>
                                <div class="form-group col-md-6">
                                    <img src="<?php echo e(asset('/public/upload/event_image/' . $image->image_name)); ?>" style="width: 100%; height: auto; margin-bottom: 20px;">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <div class="form-row">
    							<div class="form-group col-md-12 text-center"> <h3>Other Information</h3> </div>
    							<div class="form-group col-md-6">
        							<b>Information</b> : <?php echo e($event->other_information); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Parking</b> : <?php echo e($event->parking); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Wheel Chair</b> : <?php echo e($event->wheelchair); ?>

        						</div>
        					</div>
        						
        					<div class="form-row">	
        						<div class="form-group col-md-12 text-center">
                                    <h3>Organizer Details</h3>
                                </div>
        						<div class="form-group col-md-6">
        							<b>Organizer Name</b> : <?php echo e($event->organizer->first_name); ?> <?php echo e($event->organizer->last_name); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Email</b> : <?php echo e($event->organizer->email); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer mobile number</b> : <?php echo e($event->organizer->mobile_number); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer about</b> : <?php echo e($event->organizer->about_organizer); ?>

        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Website</b> : <a href="<?php echo e($event->organizer->website); ?>" target="_blank"> <?php echo e($event->organizer->website); ?> </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Unique Url</b> : <a href="<?php echo e($event->organizer->unique_url); ?>" target="_blank"> <?php echo e($event->organizer->unique_url); ?> </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Facebook</b> : <a href="<?php echo e($event->organizer->fb_url); ?>" target="_blank"> <?php echo e($event->organizer->fb_url); ?> </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Instagram:</b> : <a href="<?php echo e($event->organizer->insta_url); ?>" target="_blank"> <?php echo e($event->organizer->insta_url); ?> </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer SnapChat</b> : <a href="<?php echo e($event->organizer->snapchat); ?>" target="_blank"> <?php echo e($event->organizer->snapchat); ?> </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Twitter</b> : <a href="<?php echo e($event->organizer->twitter); ?>" target="_blank"> <?php echo e($event->organizer->twitter); ?> </a>
        						</div>
    						</div>
    						
    						<div class="form-row">	
        						<div class="form-group col-md-12 text-center">
                                    <h3>Ticket Information</h3>
                                </div>
                                <div class="form-group col-md-12">
                                	<table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Event Type</th>
                                                <th>Ticket Type</th>
                                                <th>Ticket Description</th>
                                                <th>Ticket Quantity</th>
                                                <th>Remaining Tickets</th>
                                                <th>Ticket Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php if( COUNT( $event->REL_event_ticket ) >0 ): ?>
                                                <?php $__currentLoopData = $event->REL_event_ticket; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <?php if($ticket->event_type == 1): ?>
                                                                Free
                                                            <?php elseif($ticket->event_type == 2): ?>
                                                                Paid
                                                            <?php elseif($ticket->evnet_type == 3): ?>
                                                                Donation
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo e($ticket->ticket_type); ?></td>
                                                        <td><?php echo e($ticket->description); ?></td>
                                                        <td><?php echo e($ticket->original_quantity); ?></td>
                                                        <td><?php echo e($ticket->quantity); ?></td>
                                                        <td>$<?php echo e($ticket->price); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            	<tr> <td colspan="6" class="text-center"> No Result Found </td> </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="<?php echo e(url('Admin/eventList')); ?>" class="btn btn-info" style="float: right">Back</a>
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