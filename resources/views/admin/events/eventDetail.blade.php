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
						<h3 class="profile-username text-center">{{ $event->event_title }}</h3>
						<p class="text-muted text-center">{!!html_entity_decode($event->event_description)!!}</p>
					</div>
				</div>
				<div class="card">
                    <div class="card-body">
						<div class="basic-form">
    						<div class="form-row">
    							<div class="form-group col-md-12 text-center"> <h3>Event Details</h3> </div>
    							<div class="form-group col-md-6">
        							<b>Created At</b> : {{ $event->created_at }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Start Date</b> : {{ $event->start_date }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Start Time</b> : {{ $event->start_time }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>End Date</b> : {{ $event->end_date }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>End Time</b> : {{ $event->end_time }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>URL</b> : <a href="{{ url('/event/' . $event->event_url) }}"> {{ url('/event/' . $event->event_url) }} </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Location</b> : {{ $event->event_location }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Category</b> : {{ $event->REL_Event_Category->category_name }}
        						</div>
        						@if($event->REL_event_subcategory)
            						<div class="form-group col-md-6">
            							<b>Sub Category</b> : {{ $event->REL_event_subcategory->subcategory_name }}
            						</div>
        						@endif
    						</div>
    						
    						@if($event->is_recurring)
	    						<div class="form-group col-md-12 text-center"> <h3>Event Occurrence Details</h3> </div>
            						<div class="form-group col-md-6">
            							<b>Occurrence Start Time</b> : {{ $event->occurrence_start_time }}
            						</div>
            						<div class="form-group col-md-6">
            							<b>Occurrence End Time</b> : {{ $event->occurrence_end_time }}
            						</div>
            						<div class="form-group col-md-6">
            							<b>Occurrence From</b> : {{ $event->occurrence_from_date }}
            						</div>
            						<div class="form-group col-md-6 mb-0">
        								<b>Occurrence To</b> : {{ $event->occurence_to_date }}
            						</div>
    							</div>
							@endif
							
							@foreach($event->REL_Event_Image as $image)
								<div class="form-group col-md-12"> <h3>Event Images</h3> </div>
                                <div class="form-group col-md-6">
                                    <img src="{{ asset('/public/upload/event_image/' . $image->image_name) }}" style="width: 100%; height: auto; margin-bottom: 20px;">
                                </div>
                            @endforeach
                            
                            <div class="form-row">
    							<div class="form-group col-md-12 text-center"> <h3>Other Information</h3> </div>
    							<div class="form-group col-md-6">
        							<b>Information</b> : {{ $event->other_information }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Parking</b> : {{ $event->parking }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Wheel Chair</b> : {{ $event->wheelchair }}
        						</div>
        					</div>
        						
        					<div class="form-row">	
        						<div class="form-group col-md-12 text-center">
                                    <h3>Organizer Details</h3>
                                </div>
        						<div class="form-group col-md-6">
        							<b>Organizer Name</b> : {{ $event->organizer->first_name }} {{ $event->organizer->last_name }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Email</b> : {{ $event->organizer->email }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer mobile number</b> : {{ $event->organizer->mobile_number }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer about</b> : {{ $event->organizer->about_organizer }}
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Website</b> : <a href="{{ $event->organizer->website }}" target="_blank"> {{ $event->organizer->website }} </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Unique Url</b> : <a href="{{ $event->organizer->unique_url }}" target="_blank"> {{ $event->organizer->unique_url }} </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Facebook</b> : <a href="{{ $event->organizer->fb_url }}" target="_blank"> {{ $event->organizer->fb_url }} </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Instagram:</b> : <a href="{{ $event->organizer->insta_url }}" target="_blank"> {{ $event->organizer->insta_url }} </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer SnapChat</b> : <a href="{{ $event->organizer->snapchat }}" target="_blank"> {{ $event->organizer->snapchat }} </a>
        						</div>
        						<div class="form-group col-md-6">
        							<b>Organizer Twitter</b> : <a href="{{ $event->organizer->twitter }}" target="_blank"> {{ $event->organizer->twitter }} </a>
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
                                        	@if( COUNT( $event->REL_event_ticket ) >0 )
                                                @foreach($event->REL_event_ticket as $ticket)
                                                    <tr>
                                                        <td>
                                                            @if($ticket->event_type == 1)
                                                                Free
                                                            @elseif($ticket->event_type == 2)
                                                                Paid
                                                            @elseif($ticket->evnet_type == 3)
                                                                Donation
                                                            @endif
                                                        </td>
                                                        <td>{{ $ticket->ticket_type }}</td>
                                                        <td>{{ $ticket->description }}</td>
                                                        <td>{{ $ticket->original_quantity }}</td>
                                                        <td>{{ $ticket->quantity }}</td>
                                                        <td>${{ $ticket->price }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            	<tr> <td colspan="6" class="text-center"> No Result Found </td> </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{ url('Admin/eventList') }}" class="btn btn-info" style="float: right">Back</a>
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