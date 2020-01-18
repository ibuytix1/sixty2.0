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
                    <span class="ml-1">List Tags</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tags</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">List Tags</a></li>
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
                            <table id="cms_page_list" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Tag</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Tag</th>
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
		const editCategory = "{{url($adminURL.'editTag/')}}";
	    const listCategoryJson = "{{url($adminURL.'listTagJson/')}}";
	    var organizerTable = $('#cms_page_list').DataTable({
            'processing':true,
            'serverSide':true,
            "paging": true,
            "pageLength": 10,
            "ordering": false,
            "lengthChange": false,
            'ajax':{
                'url':listCategoryJson,
    			dataFilter: function(data){
    	            var json = data;
    	            json.recordsTotal = data.recordsTotal;
    	            json.recordsFiltered = data.recordsFiltered;
    	            json.data = data.data;
    	            return json; // return JSON string
    			},
    			data:function(data){ data.page=data.start>0?(data.start/10)+1:1 }
	        },
	        'columnDefs':[
				{
                    "targets": -1,
                    "data": function(row, type, val, meta){
						return '<div class="btn-group"><button type="button" class="btn btn-info btn-xs">Action</button><button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu" role="menu"><li><a href="'+editCategory+'/'+row[0]+'">Edit</a></li><li><a href="javascript:;" class="delete_row" data-id="'+row[0]+'">Delete</a></li></ul></div>';
					}
				},
				{
					"targets": 1,
					"data": function(row, type, val, meta){
						return row[1];
    				}
    			}
	        ]
		});
	    
		$('#modal-warning').on('click', '.deleteConfirm', function(){
            var id = $(this).attr('data');
            var token = '{{ csrf_token() }}';
            var ths = $(this).attr('data');
            var data_row_id = $(this).attr('data-row-id');

			if (id != '') 
			{
				$.ajax({
                    type: 'post',
                    url: "{{ url('Admin/deleteTag')}}",
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
@include('admin.include.footer')