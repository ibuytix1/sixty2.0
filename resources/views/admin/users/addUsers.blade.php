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
                    <span class="ml-1">Add User</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                	<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Add User</a></li>
                </ol>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body">
						{{ Form::open(array('url' => config('constants.ADMIN_URL').'saveOrganizer','method' => 'post', 'id' => 'm_form_addOrganizer', 'files' => false)) }}
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
                                    <div class="form-group col-md-6">
                                        <label for="first_name">First Name</label>
										<input type="text" class="form-control" placeholder="Enter first name" name="first_name" required value="{{old('first_name')}}">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
    	                                <label for="last_name">Last Name</label>
		                                <input type="text" class="form-control" placeholder="Enter Last name" name="last_name" required value="{{old('last_name')}}">
	                                </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
										<input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required onblur="duplicateEmail(this)" value="{{old('email')}}">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
    	                                <label for="mobile_number">Mobile No</label>
		                                <input type="text" class="form-control" id="mobile_number" placeholder="Enter mobile no" name="mobile_number" value="{{old('mobile_number')}}">
	                                </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
    	                                <label for="password">Password</label>
		                                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required value="{{old('password')}}">
	                                </div>
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
<script type="text/javascript">
    function duplicateEmail(element) 
    {
        var email = $(element).val();
        $.ajax({
            type: "get",
            url: "{{url('Organizer/checkemail')}}",
            data: { email: email },
            dataType: "json",
            success: function (res) {
                if (res == 1) 
                {
                    $('#success').html('Already exist please enter diffrent').css("color", 'red');
                    $('#m_login_signin_submit').prop("disabled", true);
                } 
                else 
                {
                    $('#success').html('')
                    $('#m_login_signin_submit').prop("disabled", false);
                }
            },
            error: function (jqXHR, exception) {}
        });
    }
</script>

@include('admin.include.footer')