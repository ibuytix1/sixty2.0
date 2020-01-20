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
                    <span class="ml-1">Users List</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Users List</a></li>
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
                            <table id="user_list" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <button type="button" class="btn btn-info btn-sm mt-3" id="userExport">Export List</button>
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
		const editUser = "{{url($adminURL.'editUser/')}}";
        const userManageRole = "{{url($adminURL.'manage-role/')}}";
        const userDetail = "{{url($adminURL.'userDetail/')}}";
        const listUserJson = "{{url($adminURL.'listUserJson/')}}";
        var organizerTable = $('#user_list').DataTable({
// 			"processing":true,
			"serverSide":true,
			"paging": true,
			"pageLength": 10,
			"ordering": false,
			"lengthChange": false,
			"ajax":{
        		"url":listUserJson,
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
			'columnDefs':[ 
			{
                "targets": -2,
                "data": function (row, type, val, meta) {
                    var btnClassName = row[4] == 1 ? "success" : "danger";
                    var btnTxt = row[4] == 1 ? 'Active' : 'Inactive';
                    return "<button data-id='" + row[0] + "' user-status='" + row[5] + "' class='btn btn-block btn-xs active_user btn-" + btnClassName + "'>" + btnTxt + "</button>";
                }
            },
            {
				"targets": -1,
                "data": function(row, type, val, meta){
                	var action ='<div class="btn-group"><button type="button" class="btn btn-info btn-xs">Action</button>';
                	action+='<button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';
                	action+='<ul class="dropdown-menu px-3 action" role="menu"><li><a href="' + userDetail + '/' + row[0] + '"><i class="fa fa-eye pr-2"></i>View Detail</a></li>';
                	action+='<li><a href="javascript:;" class="delete_row" data-id="' + row[0] + '" data-type="User" data-name="'+row[1]+'"><i class="fa fa-trash pr-2"></i> Delete</a></li></ul></div>';
                	return action;
				}
			},
			{
				"targets": 0,
                "data": function(row, type, val, meta){
					return row[5];
				}
			} ]
		});

        organizerTable.on('click', '.active_user', function () {
            var id = $(this).attr('data-id');
            var token = '{{ csrf_token() }}';
            var status = $(this).attr('user-status');
            var ths = $(this);
            if (id != '') {
                $.ajax({
                    type: 'post',
                    url: "{{ url('Admin/activeUser')}}",
                    data: 'id=' + id + '&_token=' + token,
                    beforeSend: function () {
                    },
                    success: function (data) {
                        if (data == 1) {
                            $(ths).html('Active');
                            $(ths).removeClass('btn-danger').addClass("btn-success");
                        } else {
                            $(ths).html('Inactive');
                            $(ths).removeClass('btn-success').addClass("btn-danger");
                        }
                    }
                })
            }
        });
        
		$('#modal-warning').on('click', '.deleteConfirm', function(){
			deletePopupSubmit( $(this), '{{ url("Admin/deleteUser")}}', '{{ csrf_token() }}', organizerTable );
		});

		organizerTable.on('click', '.delete_row', function(){
			deleteConfirmPopup($(this));
		});

		$('#userExport').click(function () {
            window.location.href = "{{ url('Admin/excel-organizer')}}";
        });
	});
</script>
@include('admin.include.footer')