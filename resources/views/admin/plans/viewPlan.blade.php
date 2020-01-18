<?php $adminURL = config('constants.ADMIN_URL'); ?>



<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Admin | Plan Detail</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  @include('admin.include.css')

</head>

<body class="skin-blue">

 @include('admin.include.header')

 @include('admin.include.sidebar')

  <div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <h1>

     Plan Detail

      <small>Preview</small>

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>

      <li><a href="#">Plan</a></li>

      <li class="active">Detail</li>

    </ol>

  </section>

  <section class="content">

      <div class="row">

        <div class="col-md-12">

          <div class="box box-primary">

            <div class="box-body box-profile">

              <h3 class="profile-username text-center"></h3>

              <div class="form-group">

              <div class="col-md-6"><b>Plan Title:</b>{{$data->plan_title}}</div>

              <div class="col-md-6"><b>Plan Price:</b>{{$data->plan_price}}</div><br><br>

               <div class="col-md-6"><b>Plan Exipry Date</b>{{date('Y-m-d h:i:s',$data->plan_expiry_date)}}</div>

              <div class="col-md-6"><b>About Plan</b>{{$data->plan_description  }}</div>

            </div>

          </div>

        </div>

      </div>

    </section>

  <!-- /.content -->

</div>

@include('admin.include.footer')

@include('admin.include.script')

</body>

</html>





