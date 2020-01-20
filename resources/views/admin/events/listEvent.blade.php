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
                    <span class="ml-1">Event List</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Event</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Event List</a></li>
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
                            <table id="event_list" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Event Title</th>
                                        <th>Event Category</th>
                                        <th>Event Organizer</th>
                                        <th>Event Location</th>
                                        <th>Event Url</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Event Title</th>
                                        <th>Event Category</th>
                                        <th>Event Organizer</th>
                                        <th>Event Location</th>
                                        <th>Event Url</th>
                                        <th>Status</th>
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

	$(document).ready(function(){
		const editOrganizer = "{{url($adminURL.'editOrganizer/')}}";
        const viewEvent = "{{url($adminURL.'viewEvent/')}}";
        const orgnizerListUrl = "{{url($adminURL.'listEventJson/')}}";
        var organizerTable = $('#event_list').DataTable({
			"serverSide":true,
			"paging": true,
			"pageLength": 10,
			"ordering": false,
			"lengthChange": false,
			"ajax":{
        		"url":orgnizerListUrl,
				dataFilter: function(data)
				{
					var json = data;
                    json.recordsTotal = data.recordsTotal;
                    json.recordsFiltered = data.recordsFiltered;
                    json.data = data.data;
                    return json; // return JSON string
				},
				data:function(data){
					data.page=data.start>0?(data.start/10)+1:1
				}
			},
			'columnDefs':[ {
				"targets": -2,
                "data": function (row, type, val, meta) {
                    var btnClassName = row[6] == 1 ? "success" : "danger";
                    var btnTxt = row[6] == 1 ? 'Unhide' : 'Hide';
                    return "<button data-id='" + row[0] + "' user-status='" + row[6] + "' class='btn btn-block btn-xs active_user btn-" + btnClassName + "'>" + btnTxt + "</button>";
                }
			},
			{
                "targets": -1,
                "data": function (row, type, val, meta) {
                	var action ='<div class="btn-group">';
                	action+='<button type="button" class="btn btn-info btn-xs">Action</button>';
                	action+='<button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';
                	action+='<ul class="dropdown-menu px-3 action" role="menu">';
                	action+='<li><a href="' + viewEvent + '/' + row[0] + '" data-type="Event" data-name="'+row[1]+'"><i class="fa fa-eye pr-2"></i> View Detail</a></li></ul></div>';
                	return action;
                }
            },
			{
				"targets": 0,
                "data": function(row, type, val, meta){
					return row[7];
				}
			} ]
		});

		$('#modal-warning').on('click', '.deleteConfirm', function(){
			deletePopupSubmit( $(this), '{{ url("Admin/deleteCategory")}}', '{{ csrf_token() }}', organizerTable );
		});

		organizerTable.on('click', '.delete_row', function(){
			deleteConfirmPopup($(this));
		});
	});
</script>
@include('admin.include.footer')