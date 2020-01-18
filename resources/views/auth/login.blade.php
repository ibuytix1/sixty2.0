@extends('layouts.login')
@section('loginContent')
    <div id="login">
        <section class="section-page-header">
            <div class="container">
                <h1 class="entry-title">Login / Sign up</h1>
            </div>
        </section>
        <section class="login-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-wrapper">
                            <div class="form-one" v-if="formOne">
                                <form action="#" @keydown.enter.prevent="" method="POST">
                                    <h3 class="text-center">Login</h3>
                                    <br>
                                    <div class="form-group col-sm-12">
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        <div class="input-group">
                                            <span class="input-group-addon custom-addon"><i class="fa fa-user fa-lg"
                                                                                            aria-hidden="true"></i></span>
                                            <input id="email" v-model="email" type="text"
                                                   class="form-control border-left-0" name="email"
                                                   placeholder="Username or Email" @keydown.enter.prevent="checkEmail">
                                        </div>
                                        <div id="error-div" v-if="error.show"><p v-cloak>@{{ error.message }}</p></div>
                                    </div>
                                    <div class="form-group col-sm-12 text-center">
                                        <a class="checkout-custom  continue-btn" id="continue-btn"
                                           @click.prevent="checkEmail">Continue <i class="fa fa-long-arrow-right"
                                                                                   aria-hidden="true"></i></a>
                                    </div>
                                    <div class="form-group col-sm-12 text-center">
                                        <a href="#" class="fb-login"><i class="fa fa-facebook fa-lg"
                                                                        aria-hidden="true"></i> Sign in with
                                            Facebook</a>
                                        <a href="#" class="tw-login"><i class="fa fa-twitter fa-lg"
                                                                        aria-hidden="true"></i> Sign in with Twitter</a>
                                        <hr/>
                                    </div>
                                    <p class="text-center new-to-ibuy"><span>New to iBuyTix</span></p>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-sm-12 text-center">
                                        <a class="checkout-custom  continue-btn" id="signup-btn"
                                           @click.prevent="formOne=false;formThree=true">Sign up </a>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <div class="clearfix"></div>
                            <div class="form-two" v-if="formTwo">
                                <form action="#" @keydown.enter.prevent="" method="POST">
                                    <h3 class="text-center" v-cloak>Welcome @{{ username.first }} @{{ username.last
                                        }}</h3>
                                    <br>
                                    <div class="form-group col-sm-12">
                                        <div class="alert alert-success" v-if="success.show" v-cloak>
                                            <p>@{{ success.message }} @{{ email }}</p>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon custom-addon"><i class="fa fa-lock fa-lg"
                                                                                            aria-hidden="true"></i></span>
                                            <input id="Password" v-model="password" type="password"
                                                   class="form-control border-left-0" name="password"
                                                   placeholder="Password" @keydown.enter.prevent="userLogin">
                                        </div>
                                        <div id="error-div" v-if="error.show"><p v-cloak>@{{ error.message }}</p></div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class="checkbox">
                                            <input id="category2" class="styled" type="checkbox">
                                            <label for="category2">
                                                Keep me logged in
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <a href="#" class="pull-right" @click.prevent="resetPasswordLink">Forgot Password? </a>
                                    </div>
                                    <div class="form-group col-sm-12 text-center">
                                        <a class="checkout-custom  continue-btn" @click.prevent="userLogin">Log in <i
                                                    class="fa fa-sign-in" aria-hidden="true"></i></a><br><br>
                                        <a href="#" @click="formOne=true;formTwo=false;error.show=false">Not you? </a>
                                    </div>
                                </form>
                            </div>
                            <div class="form-three" v-if="formThree">
                                <form action="#" @keydown.enter.prevent="" method="POST">
                                    <h3 class="text-center">Sign up</h3>
                                    <div id="error-div" style="text-align: center" v-if="error.show"><p v-cloak>@{{
                                            error.message }}</p></div>
                                    <div id="success-div" style="text-align: center" v-if="success.show"><p v-cloak>@{{
                                            success.message }}</p></div>
                                    <br>
                                    <div class="form-group col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user fa-lg"
                                                                               aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" placeholder="First name"
                                                   v-model="regFirstName">
                                        </div>
                                        <div id="error-div" v-if="error.show"><p v-cloak>@{{ error.firstName }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user fa-lg"
                                                                               aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" placeholder="Last name"
                                                   v-model="regLastName">
                                        </div>
                                        <div id="error-div" v-if="error.show"><p v-cloak>@{{ error.lastName }}</p></div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope-o fa-lg"
                                                                               aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" placeholder="Email"
                                                   v-model="regEmail">
                                        </div>
                                        <div id="error-div" v-if="error.show"><p v-cloak>@{{ error.regEmail }}</p></div>
                                    </div>
                                    <div class="form-group col-sm-12 text-center">
                                        <p class="text-left">By clicking Sign Up, I agree to iBuy tix terms of service,
                                            privacy policy, and community guidelines.</p>
                                        <a class="checkout-custom continue-btn" @click.prevent="register">Signup</a>
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