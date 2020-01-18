@extends('user.include.app')
@section('before-content')
    <style>
        .ui-datepicker-calendar {
            display: none !important;
        }
    </style>
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Credit/Debit Cards</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container" id="add-card">
        <div class="row" v-if="!showEditCard && !showAddCard">
            <div class="col-xl-12">
                <div class="saved_card_details" v-for="card in cards.data" v-if="cards.data" v-cloak>
                    <div class="left_panel">
                        <img src="{{ asset('/public/images/master_card_icon.png') }}"
                             alt="Master Card" class="master_card">
                    </div>
                    <div class="right_panel">
                        <h3>XXXXXXXX - @{{ card.card_number.substr(-4) }}</h3>
                        <h4>@{{ card.name }} | exp. @{{ card.expiration_date }}</h4>
                        <button class="btn btn-primary edit_btn" @click.prevent="enableEditCard(card)">Edit</button>
                        <button class="btn btn-danger delete" @click.prevent="deleteCard(card.id)">Delete</button>
                    </div>
                </div>
                <div>
                    <pagination2 :data="cards" @pagination-change-page="getCards"
                                 style="float: right; margin-top: 10px;"></pagination2>
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <button class="btn btn-danger" @click.prevent="enableAddCard">Add New Card</button>
                </div>
            </div>
        </div>

        {{-- add new card --}}
        <div class="row" v-if="showAddCard && !showEditCard" v-cloak>
            <div class="col-xl-12">
                <div class="setting-billing">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="form-group row">
                                <div class="col-lg-12"><label class="col-form-label">Name on Card</label></div>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" name="name_on_card"
                                           placeholder="Enter full name" v-model="card.name_on_card">
                                    <p class="error" v-if="error.card.show">@{{ error.card.name_on_card }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12"><label class="col-form-label">Card Number</label></div>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" name="card_number"
                                           placeholder="Enter Your Card Number" v-model="card.card_number"
                                           @keypress="isNumber($event)">
                                    <p class="error" v-if="error.card.show">@{{ error.card.card_number }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="col-form-label">Expiration Date</label>
                                    <input class="form-control" type="text" placeholder="MM/YYYY"
                                           name="expiration_date"
                                           id="expiration-date" v-model="card.expiration_date">
                                    <p class="error" v-if="error.card.show">@{{ error.card.expiration_date }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">CVV</label>
                                    <input type="number" class="form-control" name="cvv" min="100" max="999"
                                           placeholder="123" v-model="card.cvv">
                                    <p class="error" v-if="error.card.show">@{{ error.card.cvv }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label class="col-form-label">Country</label>
                                </div>
                                <div class="col-lg-12">
                                    <select class="form-control" name="country" v-model="card.country">
                                        <option value="">Select Country</option>
                                        <option value="United States">United States</option>
                                        <option value="Canada">Canada</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Nigeria">Nigeria</option>
                                    </select>
                                    <p class="error" v-if="error.card.show">@{{ error.card.country }}</p>

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12"><label class="col-form-label">Address</label></div>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" name="address"
                                           v-model="card.address"
                                           placeholder="address">
                                    <p class="error" v-if="error.card.show">@{{ error.card.address }}</p>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="col-form-label">City</label>
                                    <input type="text" class="form-control" name="city"
                                           v-model="card.city"
                                           placeholder="Laurel">
                                    <p class="error" v-if="error.card.show">@{{ error.card.city }}</p>

                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">State</label>
                                    <input type="text" class="form-control" name="state"
                                           v-model="card.state"
                                           placeholder="State">
                                    <p class="error" v-if="error.card.show">@{{ error.card.state }}</p>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="col-form-label">Postal Code</label>
                                    <input type="number" class="form-control" name="postal_code"
                                           v-model="card.postal_code"
                                           placeholder="20707">
                                    <p class="error" v-if="error.card.show">@{{ error.card.postal_code }}</p>

                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number"
                                           v-model="card.phone_number" @keypress="isNumber($event)"
                                           placeholder="(123)-456-7890">
                                    <p class="error" v-if="error.card.show">@{{ error.card.phone_number }}</p>

                                </div>
                            </div>
                            <label class="termsandcondition">
                                <input type="checkbox" name="agree" value="agree" v-model="card.agree"/>
                                if i sell tickets, this card may be
                                charged to refund the buyer if the event is cancelled, postponed or rescheduled. *
                                <span>* If buyer requests refund for a rescheduled/postponed event (different date or
                                material change in time) or other refunds authorized by Event Provider.</span>
                            </label>
                            <p class="error" v-if="error.card.show">@{{ error.card.agree }}</p>
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-primery" @click="cancelAddCard">Cancel</button>
                                <button type="button" class="btn btn-success" @click.prevent="addCard">Add Card</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- add new card --}}

        {{-- add new card --}}
        <div class="row" v-if="!showAddCard && showEditCard" v-cloak>
            <div class="col-xl-12">
                <div class="setting-billing">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="form-group row">
                                <div class="col-lg-12"><label class="col-form-label">Name on Card</label></div>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" name="name_on_card"
                                           placeholder="Enter full name" v-model="card.name_on_card">
                                    <p class="error" v-if="error.card.show">@{{ error.card.name_on_card }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12"><label class="col-form-label">Card Number</label></div>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" name="card_number"
                                           placeholder="Enter Your Card Number" v-model="card.card_number"
                                           @keypress="isNumber($event)">
                                    <p class="error" v-if="error.card.show">@{{ error.card.card_number }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="col-form-label">Expiration Date</label>
                                    <input class="form-control" type="text" placeholder="MM/YYYY"
                                           name="expiration_date"
                                           id="expiration-date" v-model="card.expiration_date">
                                    <p class="error" v-if="error.card.show">@{{ error.card.expiration_date }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">CVV</label>
                                    <input type="number" class="form-control" name="cvv" min="100" max="999"
                                           placeholder="123" v-model="card.cvv">
                                    <p class="error" v-if="error.card.show">@{{ error.card.cvv }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label class="col-form-label">Country</label>
                                </div>
                                <div class="col-lg-12">
                                    <select class="form-control" name="country" v-model="card.country">
                                        <option value="">Select Country</option>
                                        <option value="United States">United States</option>
                                        <option value="Canada">Canada</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Nigeria">Nigeria</option>
                                    </select>
                                    <p class="error" v-if="error.card.show">@{{ error.card.country }}</p>

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12"><label class="col-form-label">Address</label></div>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" name="address"
                                           v-model="card.address"
                                           placeholder="address">
                                    <p class="error" v-if="error.card.show">@{{ error.card.address }}</p>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="col-form-label">City</label>
                                    <input type="text" class="form-control" name="city"
                                           v-model="card.city"
                                           placeholder="Laurel">
                                    <p class="error" v-if="error.card.show">@{{ error.card.city }}</p>

                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">State</label>
                                    <input type="text" class="form-control" name="state"
                                           v-model="card.state"
                                           placeholder="State">
                                    <p class="error" v-if="error.card.show">@{{ error.card.state }}</p>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label class="col-form-label">Postal Code</label>
                                    <input type="number" class="form-control" name="postal_code"
                                           v-model="card.postal_code"
                                           placeholder="20707">
                                    <p class="error" v-if="error.card.show">@{{ error.card.postal_code }}</p>

                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phone_number"
                                           v-model="card.phone_number" @keypress="isNumber($event)"
                                           placeholder="(123)-456-7890">
                                    <p class="error" v-if="error.card.show">@{{ error.card.phone_number }}</p>

                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-primery" @click="cancelEditCard">Cancel</button>
                                <button type="button" class="btn btn-success" @click.prevent="updateCard">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- add new card --}}
    </div>
@endsection