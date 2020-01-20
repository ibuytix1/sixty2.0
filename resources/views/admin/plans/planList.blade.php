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
                    <span class="ml-1">Plan List</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Plan</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Plan List</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
					@if(session('success_msg'))
                        <div class="card-header row">
							<div class="alert alert-success alert-dismissible col-md-12 mb-0">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-check"></i> Alert!</h4>
								{{session('success_msg') }}
							</div>
                        </div>
					@endif
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="plan_list" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Plan Title</th>
                                        <th>Plan Expiry Date</th>
                                        <th>Plan Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($data as $k=>$plan)
										<?php $k++;?>
    									<tr class="{{$plan->id}}">
    										<td>{{$k}}</td>
    										<td>{{$plan->plan_title}}</td>
    										<td>{{date('m/d/Y',$plan->plan_expiry_date)}}</td>
    										<td>{{$plan->plan_price}}</td>
    										<td>
    											<div class="btn-group">
    												<button type="button" class="btn btn-info btn-xs">Action</button>
    												<button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
    													<span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>
    												</button>
    												<ul class="dropdown-menu px-3 action" role="menu">
    													<li><a href="{{ url($adminURL.'update-plan/'.$plan->id) }}"><i class="fa fa-pencil pr-2"></i> Edit</a></li>
    													<li><a href="{{ url($adminURL.'view-plan/'.$plan->id) }}"><i class="fa fa-eye pr-2"></i>View</a></li>
    													<li><a href="#" class="delete_plan" data-id="{{$plan->id}}" data-type="Plan" data-name="{{$plan->plan_title}}"><i class="fa fa-trash pr-2"></i>Delete</a></li>
    												</ul>
    											</div>
											</td>
    									</tr>
									@endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Plan Title</th>
                                        <th>Plan Expiry Date</th>
                                        <th>Plan Price</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	@include('admin.include.popup-modal')
</div>
<!--**********************************
    Content body end
***********************************-->

<script type="text/javascript">

	$(function (){
    	$('#plan_list').DataTable()({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
		})
	});

	$(document).ready(function(){
		$('#modal-warning').on('click', '.deleteConfirm', function(){
			deletePopupSubmit( $(this), '{{ url("Admin/delete-plan")}}', '{{ csrf_token() }}', organizerTable );
		});

		$('.delete_plan').on('click', function(){
			deleteConfirmPopup($(this));
		});
	});
</script>
@include('admin.include.footer')