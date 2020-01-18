@extends('layouts.login')
@section('loginContent')
    <div id="reset-pass">
        <section class="section-page-header">
            <div class="container">
                <h1 class="entry-title">Reset Password</h1>
            </div>
        </section>
        <section class="login-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-wrapper">
                            <div class="">
                                <form action="#" @keydown.enter.prevent="">
                                    <h3 class="text-center">Welcome {{ $name }}.</h3>
                                    <br>
                                    <h6 class="text-center">Reset Password</h6>
                                    <br>
                                    <div class="form-group col-sm-12">
                                        <div id="error-div" v-if="error.show" class="text-center"><p v-cloak>@{{
                                                error.message }}</p></div>
                                        <div class="alert alert-success" v-if="success.show" v-cloak>
                                            <p>@{{ success.message }}</p>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon custom-addon"><i class="fa fa-lock fa-lg"
                                                                                            aria-hidden="true"></i></span>
                                            <input type="password" v-model="password" class="form-control border-left-0"
                                                   placeholder="New Password" @keydown.enter.prevent="resetPassword">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon custom-addon"><i class="fa fa-lock fa-lg"
                                                                                            aria-hidden="true"></i></span>
                                            <input v-model="confirmPassword" type="password"
                                                   class="form-control border-left-0" placeholder="Repeat Password"
                                                   @keydown.enter.prevent="resetPassword">
                                        </div>
                                    </div>
                                    <input type="hidden" :value="token = '{{ $token }}'">
                                    <div class="clearfix"></div>
                                    <div class="form-group col-sm-12 text-center">
                                        <a class="checkout-custom  continue-btn" @click.prevent="resetPassword">Sign
                                            up</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection