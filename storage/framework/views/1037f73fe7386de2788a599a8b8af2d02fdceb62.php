<?php 
$adminURL = config('constants.ADMIN_URL');
$access_role = explode(',',Session::get('user_data')['roles']);
?>
<!--**********************************
    Sidebar start
***********************************-->
<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Navigation</li>
            <li><a href="<?php echo e(url($adminURL.'dashboard')); ?>" aria-expanded="false"><i class="mdi mdi-home"></i><span class="nav-text">Dashboard</span></a></li>
			<?php if(in_array(1,$access_role) ): ?>
                <li>
                	<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-apps"></i>
                		<span class="nav-text">Category</span>
            		</a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo e(url($adminURL.'addCategory')); ?>">Add Category</a></li>
                        <li><a href="<?php echo e(url($adminURL.'listCategory')); ?>">Categories List</a></li>
                        <li><a href="<?php echo e(url($adminURL.'addSubcategory')); ?>">Add SubCategory</a></li>
                        <li><a href="<?php echo e(url($adminURL.'listSubCategory')); ?>">Subcategories List</a></li>                            
                    </ul>
                </li>
            	<li>
            		<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account"></i>
            			<span class="nav-text">Organizers</span>
        			</a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo e(url($adminURL.'listOrganizer')); ?>">Organizer List</a></li>
                        <li><a href="<?php echo e(url($adminURL.'addOrganizer')); ?>">Add Organizer</a></li>
                    </ul>
                </li>
            	<li>
            		<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-eventbrite"></i>
            			<span class="nav-text">Event</span>
        			</a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo e(url($adminURL.'eventList')); ?>">Event List</a></li>                           
                    </ul>
                </li>
            	<li>
            		<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account-star"></i>
            			<span class="nav-text">Promoter</span>
        			</a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo e(url($adminURL.'promoterList')); ?>">Promoter List</a></li>
                        <li><a href="<?php echo e(url($adminURL.'add-promoter')); ?>">Add Promoter</a></li>                            
                    </ul>
                </li>                    
                <li>
                	<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-account-multiple"></i>
                		<span class="nav-text">Users</span>
            		</a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo e(url($adminURL.'usersList')); ?>">User List</a></li>
                        <li><a href="<?php echo e(url($adminURL.'AddUser')); ?>">Add User</a></li>                            
                    </ul>
                </li>
            	<li>
            		<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-cellphone-link"></i>
            			<span class="nav-text">Contact</span>
        			</a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo e(url($adminURL.'contactList')); ?>">Contact List</a></li>                           
                    </ul>
                </li>
	            <li>
	            	<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-book-open-page-variant"></i>
	            		<span class="nav-text">Manage CMS Pages</span>
            		</a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo e(url($adminURL.'cms-pages-list')); ?>">Pages List</a></li>                            
                    </ul>
                </li>
				<li>
					<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-widgets"></i>
						<span class="nav-text">Manage Plans</span>
					</a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo e(url($adminURL.'add-plans')); ?>">Add Plan</a></li>
                        <li><a href="<?php echo e(url($adminURL.'list-plans')); ?>">Plan List</a></li>                            
                    </ul>
                </li>
            	<li>
            		<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-tag-multiple"></i>
            			<span class="nav-text">Manage Tags</span>
        			</a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo e(url($adminURL.'addTag')); ?>">Add Tags</a></li>
                        <li><a href="<?php echo e(url($adminURL.'listTags')); ?>">List Tags</a></li>                            
                    </ul>
                </li>
            <?php else: ?>
				<?php if(in_array(2,$access_role)): ?>
					<li>
    	            	<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-book-open-page-variant"></i>
    	            		<span class="nav-text">Payment Report</span>
                		</a>
                        <ul aria-expanded="false">
                            <li><a href="<?php echo e(url($adminURL.'list-payment')); ?>">Plans List</a></li>                            
                        </ul>
                    </li>
				<?php endif; ?>

				<?php if(in_array(3,$access_role)): ?>
					<li>
    	            	<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-book-open-page-variant"></i>
    	            		<span class="nav-text">Report</span>
                		</a>
                        <ul aria-expanded="false">
                            <li><a href="<?php echo e(url($adminURL.'list-payment')); ?>">Plans List</a></li>                            
                        </ul>
                    </li>
				<?php endif; ?>

				<?php if(in_array(4,$access_role)): ?>
					<li>
                		<a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-eventbrite"></i>
                			<span class="nav-text">Event</span>
            			</a>
                        <ul aria-expanded="false">
                            <li><a href="<?php echo e(url($adminURL.'eventList')); ?>">Event List</a></li>                           
                        </ul>
                    </li>
				<?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
<!--**********************************
    Sidebar end
***********************************-->