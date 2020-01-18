{{--@extends('layouts.login')--}}
{{--@section('loginContent')--}}
{{--    <div id="reset-pass-email">--}}
{{--        <section class="section-page-header">--}}
{{--            <div class="container">--}}
{{--                <h1 class="entry-title">Forgot Password</h1>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--        <section class="login-wrapper">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-sm-6 col-sm-offset-3">--}}
{{--                        <div class="form-wrapper">--}}
{{--                            <div class="form-one">--}}
{{--                                <form action="#" method="POST" @keydown.prevent.enter="">--}}
{{--                                    <h3 class="text-center">Forgot Password</h3>--}}
{{--                                    <br>--}}
{{--                                    <div class="form-group col-sm-12">--}}
{{--                                        <div class="alert alert-success" v-if="success.show" v-cloak><p>@{{ success.message }}</p></div>--}}
{{--                                        <div id="response"></div>--}}
{{--                                        <div class="input-group">--}}
{{--                                            <span class="input-group-addon custom-addon">--}}
{{--                                                <i class="fa fa-user fa-lg" aria-hidden="true"></i>--}}
{{--                                            </span>--}}
{{--                                            <input type="text" class="form-control border-left-0"--}}
{{--                                                   v-model="email" placeholder="Username or Email" @keydown.enter.prevent="resetPasswordLink">--}}
{{--                                        </div>--}}
{{--                                        <div id="error-div" v-if="error.show" v-cloak><p>@{{ error.message }}</p></div>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-group col-sm-12 text-center">--}}
{{--                                        <button class="checkout-custom  continue-btn"--}}
{{--                                                @click.prevent="resetPasswordLink">Continue--}}
{{--                                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>--}}
{{--                                    </div>--}}
{{--                                    <div class="clearfix"></div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                            <br>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--    </div>--}}
{{--@endsection--}}