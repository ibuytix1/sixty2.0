<?php $adminURL = config('constants.ADMIN_URL'); ?>



<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Admin | Change Password</title>

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

        Change Password

        

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>

        <li><a href="#">Forms</a></li>

        <li class="active">Chnage Password</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

        <!-- left column -->

        <div class="col-md-12">

         

          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Chnage Password</h3>

            </div>

            <!-- /.box-header -->

            <!-- form start -->

            {{ Form::open(array('url' => config('constants.ADMIN_URL').'saveChangePassword','method' => 'post', 'id' => 'm_form_addCategory', 'files' => false)) }}

             @if (count($errors) > 0)

            <div class="m-form__content">

                <div class="m-alert m-alert--icon alert alert-danger" role="alert" id="m_form_1_msg">

                    <div class="m-alert__icon">

                        <i class="la la-warning"></i>

                    </div>

                    <div class="m-alert__text">

                        <ul>

                            @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                    <div class="m-alert__close">

                        <button type="button" class="close" data-close="alert" aria-label="Close"></button>

                    </div>

                </div>

            </div>

            @endif

            @if(session('status'))

            <div class="m-form__content">

                <div class="m-alert m-alert--icon alert alert-danger" role="alert">

                    <div class="m-alert__icon">

                        <i class="la la-check"></i>

                    </div>

                    <div class="m-alert__text">

                        {{session('status') }}

                    </div>

                    <div class="m-alert__close">

                        <button type="button" class="close" data-close="alert" aria-label="Close"></button>

                    </div>

                </div>

            </div>

            @endif

              <div class="box-body">

                <div class="form-group">

                  <label for="exampleInputEmail1">Old Password</label>

                  <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Old password" name="old_password">

                </div>

                <div class="form-group">

                  <label for="exampleInputEmail1">New Passowrd</label>

                  <input type="password" class="form-control" id="exampleInputEmail1" placeholder="New password" name="new_password">

                </div>

                 <div class="form-group">

                  <label for="exampleInputEmail1">Confirm Password</label>

                  <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Confirm password" name="confirm_password">

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





