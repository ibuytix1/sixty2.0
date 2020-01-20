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
                    <span class="ml-1">CMS Pages</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">CMS Pages</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">CMS Pages List</a></li>
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
                                        <th>Title</th>
                                        <th>Page Title</th>
                                        <th>Page Keyword</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($data as $k=>$pages)
										<?php $k++;?>
    									<tr class="{{$pages->id}}">
    										<td>{{$k}}</td>
    										<td>{{$pages->title}}</td>
    										<td>{{$pages->page_title}}</td>
    										<td>{{$pages->page_keyword}}</td>
    										<td>
    											<div class="btn-group">
    												<button type="button" class="btn btn-info btn-xs">Action</button>
    												<button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
    													<span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>
    												</button>
    												<ul class="dropdown-menu px-3 action" role="menu">
    													<li>
    														<a href="{{ url($adminURL.'edit-cms-page/'.$pages->id) }}"><i class="fa fa-pencil pr-2"></i> Edit</a>
														</li>
    												</ul>
    											</div>
											</td>
    									</tr>
									@endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Title</th>
                                        <th>Page Title</th>
                                        <th>Page Keyword</th>
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
    	$('#cms_page_list').DataTable()({
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
			deletePopupSubmit( $(this), '{{ url("Admin/deleteUser")}}', '{{ csrf_token() }}', organizerTable );
		});
	});
</script>
@include('admin.include.footer')