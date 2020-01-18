@extends('organizer.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Add Account Details</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- content area -->

@section('content')
    {{--<div class="content-body" id="add-account">
        <form action="#" method="POST">
            <div class="container bank_account">
                <div class="row justify-content-between">
                    <div class="col-xl-12">
                        <h3><b>Account Information</b></h3>
                        <div class="alert alert-danger" v-cloak v-if="error.message">
                            <h4><i class="icon fa fa-close"></i> @{{ error.message }}</h4>
                        </div>
                        <div class="alert alert-success" v-cloak v-if="success.show">
                            <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                        </div>
                        <div class="setting-billing">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" v-model="showPayPal"
                                           name="payment_type" id="bank_checkbox" :value="false" checked>
                                    Bank Account (ACH)
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" v-model="showPayPal"
                                           name="payment_type" id="paypal" :value="true">
                                    PayPal
                                </label>
                            </div>
                            --}}{{-- account information --}}{{--
                            <div class="list-group" v-if="!showPayPal" v-cloak>
                                <div class="list-group-item">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="bank_name">Bank Name*</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" v-model="bankAccount.bankName"
                                                   placeholder="Bank Name" id="bank_name">
                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                @{{ error.bankAccount.bankName }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label"
                                               for="account_name">Account Name *</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" v-model="bankAccount.accountName"
                                                   placeholder="Account Name" id="account_name">
                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                @{{ error.bankAccount.accountName }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label"
                                               for="account_number">Account Number*</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" v-model="bankAccount.accountNumber"
                                                   placeholder="Account Number" id="account_number">
                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                @{{ error.bankAccount.accountNumber }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Routing Number*</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" v-model="bankAccount.routingNumber"
                                                   id="routing_number" placeholder="Routing Number">
                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                @{{ error.bankAccount.routingNumber }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="bank_currency">Currency*</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" v-model="bankAccount.currency"
                                                    id="bank_currency">
                                                <option selected="selected" value="">Select One</option>
                                                <option value="USD">USD</option>
                                                <option value="CAD">CAD</option>
                                                <option value="GDP">GBP</option>
                                                <option value="NGN">NGN</option>
                                                <option value="ZAR">ZAR</option>
                                                <option value="EUR">EUR</option>
                                            </select>
                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                @{{ error.bankAccount.currency }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="bank_phone_no">Phone Number*</label>
                                        <div class="col-lg-8">
                                            <input type="tel" class="form-control" v-model="bankAccount.phoneNumber"
                                                   id="bank_phone_no" placeholder="(123)-456-7890">
                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                @{{ error.bankAccount.phoneNumber }}</p>
                                        </div>
                                    </div>
                                    <label>
                                        <input type="checkbox" v-model="bankAccount.termAndConditions"/>
                                            Agree with the <a href="">terms and conditions</a>
                                    </label>
                                    <p class="error" v-if="error.bankAccount.show" v-cloak>
                                        @{{ error.bankAccount.termAndConditions }}</p>
                                    <div class="col-sm-12 text-center">
                                        <button type="button" @click.prevent="addBankAccount"
                                                class="btn btn-danger">Add Account</button>
                                    </div>
                                </div>
                            </div>
                            --}}{{-- //account information --}}{{--

                            --}}{{-- paytm information --}}{{--
                            <div class="list-group-item" v-if="showPayPal" v-cloak>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="paypal_name">PayPal Name*</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" v-model="payPalAccount.payPalName"
                                               id="paypal_name" placeholder="PayPal Name">
                                        <p class="error" v-if="error.payPalAccount.show" v-cloak>
                                            @{{ error.payPalAccount.payPalName }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">PayPal Email*</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" v-model="payPalAccount.payPalEmail"
                                               id="paypal_email" placeholder="PayPal Email">
                                        <p class="error" v-if="error.payPalAccount.show" v-cloak>
                                            @{{ error.payPalAccount.payPalEmail }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Currency</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" v-model="payPalAccount.currency"
                                                id="pay_pal_currency">
                                            <option selected="selected" value="">Select One</option>
                                            <option value="USD">USD</option>
                                            <option value="CAD">CAD</option>
                                            <option value="GBP">GBP</option>
                                            <option value="NGN">NGN</option>
                                            <option value="ZAR">ZAR</option>
                                            <option value="EUR">EUR</option>
                                        </select>
                                        <p class="error" v-if="error.payPalAccount.show" v-cloak>
                                            @{{ error.payPalAccount.currency }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="pay_pal_phone_no">Phone Number</label>
                                    <div class="col-lg-8">
                                        <input type="tel" class="form-control" v-model="payPalAccount.phoneNumber"
                                               id="pay_pal_phone_no" placeholder="(123)-456-7890">
                                        <p class="error" v-if="error.payPalAccount.show" v-cloak>
                                            @{{ error.payPalAccount.phoneNumber }}</p>
                                    </div>
                                </div>
                                <label>
                                    <input type="checkbox" v-model="payPalAccount.termAndConditions"/>
                                    Agree with the <a href="#">terms and conditions</a>
                                </label>
                                <p class="error" v-if="error.payPalAccount.show" v-cloak>
                                    @{{ error.payPalAccount.termAndConditions }}</p>
                                <div class="col-sm-12 text-center">
                                    <button type="button" @click.prevent="addPayPalAccount"
                                            class="btn btn-danger">Add PayPal</button>
                                </div>
                            </div>
                            --}}{{-- //paytm information --}}{{--
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>--}}
@endsection