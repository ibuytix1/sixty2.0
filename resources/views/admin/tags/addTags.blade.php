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
                    <span class="ml-1">Add Tag</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Tag</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Tag</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body">
						{{ Form::open(array('url' => config('constants.ADMIN_URL').'saveTag','method' => 'post', 'id' => 'm_form_addCategory', 'files' => false)) }}
							@if(session('success_msg'))
								<div class="alert alert-success alert-dismissible col-md-12 mb-0">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h4><i class="icon fa fa-check"></i> Alert!</h4>
									{{session('success_msg') }}
								</div>
							@endif
							
							@if (count($errors) > 0)
								<div class="alert alert-danger alert-dismissible col-md-12 mb-0">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h4><i class="icon fa fa-ban"></i> Alert!</h4>
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
                            <div class="basic-form">
                            	<div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="tag">title</label>
                                		<input type="text" class="form-control" id="tag" placeholder="Enter tag" name="tag" value="">                                    </div>
                                </div>
                               
                                <div class="col-md-12 pl-0">
                                	<button type="submit" class="btn btn-primary">Submit</button>
                            	</div>
                            </div>
                        {{ Form::close() }}
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