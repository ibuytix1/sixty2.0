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
                    <span class="ml-1">Category List</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Category</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Category List</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
					<?php if(session('success_msg')): ?>
                        <div class="card-header row">
							<div class="alert alert-success alert-dismissible col-md-12 mb-0">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-check"></i> Alert!</h4>
								<?php echo e(session('success_msg')); ?>

							</div>
                        </div>
					<?php endif; ?>
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
	<div class="modal modal-default fade" id="modal-warning">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Warning</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete this <b>category</b> ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning pull-left" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success deleteConfirm" id="modelConfirm" data-row-id='' data-dismiss="modal">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--**********************************
    Content body end
***********************************-->

<script type="text/javascript">

	$(document).ready(function(){
		const editOrganizer = "<?php echo e(url($adminURL.'editOrganizer/')); ?>";
        const viewEvent = "<?php echo e(url($adminURL.'viewEvent/')); ?>";
        const orgnizerListUrl = "<?php echo e(url($adminURL.'listEventJson/')); ?>";
        var organizerTable = $('#event_list').DataTable({
// 			"processing":true,
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
                    return '<div class="btn-group"><button type="button" class="btn btn-info btn-xs">Action</button><button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu px-3 action" role="menu"><li><a href="' + viewEvent + '/' + row[0] + '"><i class="fa fa-eye pr-2"></i> View Detail</a></li></ul></div>';
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
            var id = $(this).attr('data');
            var token = '<?php echo e(csrf_token()); ?>';
            var ths = $(this).attr('data');
            var data_row_id = $(this).attr('data-row-id');

			if (id != '') 
			{
				$.ajax({
                    type: 'post',
                    url: "<?php echo e(url('Admin/deleteCategory')); ?>",
                    data: 'id=' + id + '&_token=' + token,
					beforeSend: function() { },
					success: function (data) {
						organizerTable.ajax.reload();
					}
				});
			}
		});

		organizerTable.on('click', '.delete_row', function(){
            var id = $(this).attr('data-id');
            $('#modelConfirm').attr('data', id);
            $('#modelConfirm').attr('data-row-id', id);
            $('#modal-warning').modal();
            return false;
		});
	});
</script>
<?php echo $__env->make('admin.include.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>