<?php $organizerURL = config('constants.organizer'); ?>
        <!DOCTYPE html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('constants.admin_login') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->
    @include('admin.layouts.css')
</head>
<body class="login-bg">
<div class="event-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6">
                <div class="login-area p-t-100">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center m-t-15">Log into Your Account</h4>
                            {{ Form::open(array('url' => config('constants.admin').'/get_login',
                            'class' => 'm-t-30 m-b-30', 'method' => 'post',
                            'id' => 'm_form_login', 'files' => false)) }}
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email"
                                       value="{{ Cookie::get('email') }}">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                       value="{{ Cookie::get('password') }}">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck"
                                               name="remember" value="1" {{ Cookie::get('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                                    </div>

                                </div>
                                <div class="form-group col-md-6 text-right">
                                    <a href="{{url($organizerURL.'forgot-password') }}">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="text-center m-b-15 m-t-15">
                                <button type="submit" class="btn btn-primary" id="m_login_signin_submit">Sign in
                                </button>
                            </div>
                            {{ Form::close() }}
                            <div class="text-center">
                                <p class="m-t-30">Dont have an account?
                                    <a href="#">Register Now</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.script')
<script type="text/javascript">
    //== Class Definition
    var SnippetLogin = function () {

        var login = $('#m_login');

        var showErrorMsg = function (form, type, msg) {
            var alert = $('<div class="m-alert m-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
            <span></span>\
        </div>');

            form.find('.alert').remove();
            alert.prependTo(form);
            alert.find('span').html(msg);
        }

        var displayForgetPasswordForm = function () {
            login.removeClass('m-login--signin');
            login.removeClass('m-login--signup');

            login.addClass('m-login--forget-password');
            login.find('.m-login__forget-password').animateClass('flipInX animated');
        }
        var handleFormSwitch = function () {
            $('#m_login_forget_password').click(function (e) {
                e.preventDefault();
                displayForgetPasswordForm();
            });

            $('#m_login_forget_password_cancel').click(function (e) {
                e.preventDefault();
                displaySignInForm();
            });
        }

        var displaySignInForm = function () {
            login.removeClass('m-login--forget-password');
            login.removeClass('m-login--signup');

            login.addClass('m-login--signin');
            login.find('.m-login__signin').animateClass('flipInX animated');
        }


        var handleSignInFormSubmit = function () {
            $('#m_login_signin_submit').click(function (e) {
                e.preventDefault();
                var btn = $(this);
                var form = $(this).closest('form');

                form.validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true
                        }
                    }
                });

                if (!form.valid()) {
                    return;
                }
                btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);
                form.ajaxSubmit({
                    url: "{{ url('Admin/get_login') }}",
                    success: function (response, status, xhr, $form) {


                        if (response == 0) {

                            // similate 2s delay
                            setTimeout(function () {
                                btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                                showErrorMsg(form, 'danger', 'Incorrect username or password. <br/>Please try again.');
                            }, 2000);
                        } else if (response == 1) {

                            setTimeout(function () {
                                btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                                showErrorMsg(form, 'danger', 'Your account has not been approved. <br/>Kindly login again after approval.');
                            }, 2000);

                        } else {
                            window.location.href = "Admin/dashboard";
                        }
                    }
                });
            });
        }


        //== Public Functions
        return {
            // public functions
            init: function () {
                handleFormSwitch();
                handleSignInFormSubmit();

            }
        };
    }();

    //== Class Initialization
    jQuery(document).ready(function () {
        $('#m_login_signin_submit').show();
        SnippetLogin.init();
    });
</script>
</body>

</html>