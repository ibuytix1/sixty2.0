@extends('organizer.include.app')
@section('content')
    <div class="content-body" id="manage-accounts">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-12" style="margin-left: 20px;">
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
                    </div>
                </div>
                {{-- bank accounts list  --}}
                <div class="col-xl-12" v-if="!showPayPal" v-cloak>
                    <br>
                    <div class="table-wrapper table-responsive col-sm-12">
                        <!--Table-->
                        <table class="table table-hover mb-0">
                            <thead class="">
                            <tr>
                                <th>Bank Name</th>
                                <th>Account Name</th>
                                <th>Account No.</th>
                                <th>Routing No</th>
                                <th>Currency</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="bank in bankAccounts.data">
                                <td>@{{ bank.bank_name }}</td>
                                <td>@{{ bank.account_name}}</td>
                                <td>@{{ bank.account_number}}</td>
                                <td>@{{ bank.routing_number}}</td>
                                <td>@{{ bank.bank_currency}}</td>
                                <td>@{{ bank.bank_phone_no}}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#editBankAccount"
                                       @click="editBankAccount(bank)">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" @click.prevent="deleteBankAccount(bank.id)">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <pagination :data="bankAccounts" @pagination-change-page="getBankAccounts"
                                    class="justify-content-center"></pagination>
                    </div>
                </div>
                {{-- //bank accounts list  --}}
                {{-- paypal accounts list  --}}
                <div class="col-xl-12" v-if="showPayPal" v-cloak>
                    <br>
                    <div class="table-wrapper table-responsive col-sm-12">
                        <!--Table-->
                        <table class="table table-hover mb-0">

                            <thead>
                            <tr>
                                <th>Organizer Name</th>
                                <th>PayPal Email/ID</th>
                                <th>Currency</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="payPal in payPalAccounts.data">
                                    <td>@{{ payPal.name_paypal }}</td>
                                    <td>@{{ payPal.paypal_email}}</td>
                                    <td>@{{ payPal.pay_pal_currency}}</td>
                                    <td>@{{ payPal.pay_pal_phone_no}}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#editPayPalAccount"
                                           @click="editPayPalAccount(payPal)">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" @click.prevent="deletePayPalAccount(payPal.id)">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="payPalAccounts" @pagination-change-page="getPayPalAccounts"
                                    class="justify-content-center"></pagination>
                    </div>
                </div>
                {{-- //paypal accounts list  --}}

                <div class="col-sm-12 text-center">
                    {{--<a href="{{ route('add-account')}}">
                    <button type="button" class="btn btn-danger">Add New</button></a>--}}
                    <a href="#" data-toggle="modal" data-target="#addAccount">
                        <button type="button" class="btn btn-danger">Add New</button></a>
                </div>
            </div>
        </div>
        {{-- Edit bank account Modal --}}
        <div id="editBankAccount" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Bank Account</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-cloak v-if="error.message">
                            <h4><i class="icon fa fa-close"></i> @{{ error.message }}</h4>
                        </div>
                        <div class="alert alert-success" v-cloak v-if="success.show">
                            <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                        </div>
                        <form action="#" method="POST">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="bank_name">Bank Name*</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="bankAccount.bank_name"
                                           placeholder="Bank Name" id="bank_name">
                                    <p class="error" v-if="error.bankAccount.show" v-cloak>
                                        @{{ error.bankAccount.bankName }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label"
                                       for="account_name">Account Name *</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="bankAccount.account_name"
                                           placeholder="Account Name" id="account_name">
                                    <p class="error" v-if="error.bankAccount.show" v-cloak>
                                        @{{ error.bankAccount.accountName }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label"
                                       for="account_number">Account Number*</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="bankAccount.account_number"
                                           placeholder="Account Number" id="account_number">
                                    <p class="error" v-if="error.bankAccount.show" v-cloak>
                                        @{{ error.bankAccount.accountNumber }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="routing_number"
                                >Routing Number*</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="bankAccount.routing_number"
                                           id="routing_number" placeholder="Routing Number">
                                    <p class="error" v-if="error.bankAccount.show" v-cloak>
                                        @{{ error.bankAccount.routingNumber }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="bank_currency">Currency*</label>
                                <div class="col-lg-8">
                                    <select class="form-control" v-model="bankAccount.bank_currency"
                                            id="bank_currency">
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
                                    <input type="tel" class="form-control" v-model="bankAccount.bank_phone_no"
                                           id="bank_phone_no" placeholder="(123)-456-7890">
                                    <p class="error" v-if="error.bankAccount.show" v-cloak>
                                        @{{ error.bankAccount.phoneNumber }}</p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                                @click.prevent="updateBankAccount">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                @click="resetAccountValue">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- //Edit bank account Modal --}}

        {{-- palpal account Modal --}}
        <div id="editPayPalAccount" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit PayPal Account</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-cloak v-if="error.message">
                            <h4><i class="icon fa fa-close"></i> @{{ error.message }}</h4>
                        </div>
                        <div class="alert alert-success" v-cloak v-if="success.show">
                            <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                        </div>
                        <form action="#" method="POST">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="paypal_name">PayPal Name*</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="payPalAccount.name_paypal"
                                           id="paypal_name" placeholder="PayPal Name">
                                    <p class="error" v-if="error.payPalAccount.show" v-cloak>
                                        @{{ error.payPalAccount.payPalName }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="paypal_email"
                                >PayPal Email*</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="payPalAccount.paypal_email"
                                           id="paypal_email" placeholder="PayPal Email">
                                    <p class="error" v-if="error.payPalAccount.show" v-cloak>
                                        @{{ error.payPalAccount.payPalEmail }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="pay_pal_currency">Currency</label>
                                <div class="col-lg-8">
                                    <select class="form-control" v-model="payPalAccount.pay_pal_currency"
                                            id="pay_pal_currency">
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
                                    <input type="tel" class="form-control" v-model="payPalAccount.pay_pal_phone_no"
                                           id="pay_pal_phone_no" placeholder="(123)-456-7890">
                                    <p class="error" v-if="error.payPalAccount.show" v-cloak>
                                        @{{ error.payPalAccount.phoneNumber }}</p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                                @click.prevent="updatePayPalAccount">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                @click="resetAccountValue">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- //paypal account Modal --}}
    </div>


    {{-- add account ( bank and paypal ) --}}

    <div id="addAccount" class="modal fade creat-event " role="dialog" >
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3><b>Add Account Information</b></h3>
                </div>
                <div class="modal-body">
                    <div class="content-body" id="add-account">
                        <form action="#" method="POST">
                            <div class="container bank_account">
                                <div class="row justify-content-between">
                                    <div class="col-xl-12">
                                        <div class="alert alert-danger" v-cloak v-if="error.message">
                                            <h4><i class="icon fa fa-close"></i> @{{ error.message }}</h4>
                                        </div>
                                        <div class="alert alert-success" v-cloak v-if="success.show">
                                            <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                                        </div>
                                        <div class="setting-billing">
                                            {{-- account information --}}
                                            <div class="list-group" v-if="!showPayPal" v-cloak>
                                                <div class="">
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label"
                                                               for="bank_name">Bank Name*</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control"
                                                                   v-model="bankAccount.bankName"
                                                                   placeholder="Bank Name" id="bank_name">
                                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                                @{{ error.bankAccount.bankName }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label"
                                                               for="account_name">Account Name *</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control"
                                                                   v-model="bankAccount.accountName"
                                                                   placeholder="Account Name" id="account_name">
                                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                                @{{ error.bankAccount.accountName }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label"
                                                               for="account_number">Account Number*</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control"
                                                                   v-model="bankAccount.accountNumber"
                                                                   placeholder="Account Number" id="account_number">
                                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                                @{{ error.bankAccount.accountNumber }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label">Routing Number*</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control"
                                                                   v-model="bankAccount.routingNumber"
                                                                   id="routing_number" placeholder="Routing Number">
                                                            <p class="error" v-if="error.bankAccount.show" v-cloak>
                                                                @{{ error.bankAccount.routingNumber }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label"
                                                               for="bank_currency">Currency*</label>
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
                                                        <label class="col-lg-4 col-form-label"
                                                               for="bank_phone_no">Phone Number*</label>
                                                        <div class="col-lg-8">
                                                            <input type="tel" class="form-control"
                                                                   v-model="bankAccount.phoneNumber"
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
                                                        <button type="button" class="btn btn-default" data-dismiss="modal"
                                                        >Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- //account information --}}

                                            {{-- paytm information --}}
                                            <div class="" v-if="showPayPal" v-cloak>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label"
                                                           for="paypal_name">PayPal Name*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                               v-model="payPalAccount.payPalName"
                                                               id="paypal_name" placeholder="PayPal Name">
                                                        <p class="error" v-if="error.payPalAccount.show" v-cloak>
                                                            @{{ error.payPalAccount.payPalName }}</p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label">PayPal Email*</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                               v-model="payPalAccount.payPalEmail"
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
                                                    <label class="col-lg-4 col-form-label"
                                                           for="pay_pal_phone_no">Phone Number</label>
                                                    <div class="col-lg-8">
                                                        <input type="tel" class="form-control"
                                                               v-model="payPalAccount.phoneNumber"
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
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"
                                                    >Close</button>
                                                </div>
                                            </div>
                                            {{-- //paytm information --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- //add account ( bank and paypal ) --}}
@endsection