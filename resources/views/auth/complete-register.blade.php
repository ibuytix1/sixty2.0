@extends('layouts.login')
@section('loginContent')
    <div id="completeRegister">
        <section class="section-page-header">
            <div class="container">
                <h1 class="entry-title">Sign up</h1>
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
                                    <h6 class="text-center">Create a password for your account.</h6>
                                    <br>
                                    <div id="error-div" v-if="error.show" class="text-center"><p v-cloak>@{{ error.message }}</p></div>
                                    <div class="form-group col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon custom-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                            <input type="password"  v-model="password" class="form-control border-left-0" placeholder="Password" @keydown.enter.prevent="completeRegister">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon custom-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                            <input v-model="confirmPassword" type="password" class="form-control border-left-0" placeholder="Confirm Password" @keydown.enter.prevent="completeRegister">
                                        </div>
                                    </div>
                                    <input type="hidden" :value="email = '{{ $email }}'">
                                    <input type="hidden" :value="token = '{{ $token }}'">
                                    <div class="clearfix"></div>
                                    <div class="form-group col-sm-12 text-center">
                                        <a class="checkout-custom  continue-btn" @click.prevent="completeRegister">Sign up</a>
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