<?php $adminURL = config('constants.ADMIN_URL'); 
$access_role = explode(',',Session::get('user_data')['roles']);
?>
@include('admin.include.header')
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <h5 class="mb-0">Hi, <small>Welcome</small></h5>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
        	@if(in_array(1,$access_role))
                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-3">
                    <div class="card widget-stat">
                        <div class="chart-wrapper bg-primary pt-5">
                            <canvas id="chart_widget_1"></canvas> 
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="text-dark"> Users</h4>
                                    <a href="{{url($adminURL.'usersList')}}">
                                    	<span class="text-muted">More Info<i class="mdi mdi-arrow-right-bold text-warning pl-2"></i></span>
                                	</a>
                                </div>
                                <h3 class="text-dark">{{$data['users']}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-3">
                    <div class="card widget-stat">
                        <div class="chart-wrapper bg-success pt-5">
                            <canvas id="chart_widget_2"></canvas>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="text-dark">Promoter</h4>
                                    <a href="{{ url($adminURL.'promoterList') }}">
                                    	<span class="text-muted">More Info<i class="mdi mdi-arrow-right-bold text-warning pl-2"></i></span>
                                	</a>
                                </div>
                                <h3 class="text-dark">{{$data['promoter']}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-3">
                    <div class="card widget-stat">
                        <div class="chart-wrapper bg-danger pt-5">
                            <canvas id="chart_widget_3"></canvas>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="text-dark">Organizer</h4>
                                    <a href="{{ url($adminURL.'listOrganizer') }}">
                                    	<span class="text-muted">More Info<i class="mdi mdi-arrow-right-bold text-warning pl-2"></i></span>
                                	</a>
                                </div>
                                <h3 class="text-dark">{{$data['organizer']}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 col-lg-6 col-md-3">
                    <div class="card widget-stat">
                        <div class="chart-wrapper bg-info pt-5">
                            <canvas id="chart_widget_04"></canvas>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="text-dark">Events</h4>
                                    <a href="{{ url($adminURL.'eventList') }}">
                                    	<span class="text-muted">More Info<i class="mdi mdi-arrow-right-bold text-warning pl-2"></i></span>
                                	</a>
                                </div>
                                <h3 class="text-dark">{{$data['events']}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @else
				@if(in_array(2,$access_role))
					<div class="col-xl-3 col-xxl-3 col-lg-6 col-md-3">
                        <div class="card widget-stat">
                            <div class="chart-wrapper bg-info pt-5">
                                <canvas id="chart_widget_04"></canvas>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="text-dark">Payment</h4>
                                        <a href="{{ url($adminURL.'list-payment') }}">
                                        	<span class="text-muted">More Info<i class="mdi mdi-arrow-right-bold text-warning pl-2"></i></span>
                                    	</a>
                                    </div>
                                    <h3 class="text-dark">{{$data['payment']}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
				@endif
				
				@if(in_array(3,$access_role))
					<div class="col-xl-3 col-xxl-3 col-lg-6 col-md-3">
                        <div class="card widget-stat">
                            <div class="chart-wrapper bg-info pt-5">
                                <canvas id="chart_widget_04"></canvas>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="text-dark">Report</h4>
                                        <a href="#">
                                        	<span class="text-muted">More Info<i class="mdi mdi-arrow-right-bold text-warning pl-2"></i></span>
                                    	</a>
                                    </div>
                                    <h3 class="text-dark">1</h3>
                                </div>
                            </div>
                        </div>
                    </div>
				@endif
				
				@if(in_array(4,$access_role))
					<div class="col-xl-3 col-xxl-3 col-lg-6 col-md-3">
                        <div class="card widget-stat">
                            <div class="chart-wrapper bg-info pt-5">
                                <canvas id="chart_widget_04"></canvas>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="text-dark">Events</h4>
                                        <a href="{{ url($adminURL.'eventList') }}">
                                        	<span class="text-muted">More Info<i class="mdi mdi-arrow-right-bold text-warning pl-2"></i></span>
                                    	</a>
                                    </div>
                                    <h3 class="text-dark">{{$data['events']}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
				@endif
				
				@if(in_array(4,$access_role))
					<div class="col-xl-3 col-xxl-3 col-lg-6 col-md-3">
                        <div class="card widget-stat">
                            <div class="chart-wrapper bg-info pt-5">
                                <canvas id="chart_widget_04"></canvas>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="text-dark">Other</h4>
                                        <a href="#">
                                        	<span class="text-muted">More Info<i class="mdi mdi-arrow-right-bold text-warning pl-2"></i></span>
                                    	</a>
                                    </div>
                                    <h3 class="text-dark">1</h3>
                                </div>
                            </div>
                        </div>
                    </div>
				@endif
				
			@endif
        </div>	
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->
@include('admin.include.footer')