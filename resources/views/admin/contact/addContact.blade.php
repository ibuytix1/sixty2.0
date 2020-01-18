<?php $adminURL = config('constants.ADMIN_URL'); ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Add Contact</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  @include('admin.include.css')
</head>
<body class="skin-blue">
 @include('admin.include.header')
 @include('admin.include.sidebar')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Contact
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active"> Add Contact</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Contact</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {{ Form::open(array('url' => config('constants.ADMIN_URL').'saveContact','method' => 'post', 'id' => 'm_form_addCategory', 'files' => false)) }}
            @if(session('success_msg'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                 {{session('success_msg') }}
              </div>
            @endif
            @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">First Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="First Name" name="first_name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Last Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Last Name" name="last_name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Select Event</label>
                  {{ Form::select('event_id',$events,'', ['class' => 'form-control', 'data-live-search' => 'true']) }}
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            {{ Form::close() }}
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
 @include('admin.include.footer')
 @include('admin.include.script')
</body>
</html>


