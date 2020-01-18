loadProgressBar();
var token = getCookie('token');
var header = {
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + token
    }
};
/* -------------------------------------------------------*/
Vue.component('pagination', {
    props: {
        data: {
            type: Object,
            default: function () {
                return {
                    offset: 0,
                    current_page: 1,
                    data: [],
                    from: 1,
                    last_page: 1,
                    next_page_url: null,
                    per_page: 10,
                    prev_page_url: null,
                    to: 1,
                    total: 0,
                }
            }
        },
        limit: {
            type: Number,
            default: 0
        }
    },

    template: '<ul class="pagination"  v-if="data.total > data.per_page" uk-margin>\
        <li class="page-item" v-if="data.prev_page_url">\
            <a class="page-link" @click.prevent="selectPage(1)" :disabled="data.current_page <= 1">First</a>\
        </li>\
		<li class="page-item" v-if="data.prev_page_url">\
			<a class="page-link" href="#" aria-label="Previous" @click.prevent="selectPage(--data.current_page)"><span aria-hidden="true">&laquo;</span></a>\
		</li>\
		<ul class="pagination-list">\
            <li v-for="page in getPages">\
            {{ page }}\
                <a class="pagination-link" :class="isCurrentPage(page) ? \'is-current\' : \'\'" @click.prevent="selectPage(page)">{{ page }}</a>\
            </li>\
        </ul>\
		<li class="page-item" v-for="n in getPages()" :class="{ \'active\': n == data.current_page }"><a class="page-link" href="#" @click.prevent="selectPage(n)">{{ n }}</a></li>\
		<li class="page-item" v-if="data.next_page_url">\
			<a class="page-link" href="#" aria-label="Next" @click.prevent="selectPage(++data.current_page)"><span aria-hidden="true">&raquo;</span></a>\
		</li>\
		<li class="page-item" v-if="data.next_page_url">\
		    <a class="page-link" @click.prevent="selectPage(data.last_page)" :disabled="data.current_page >= data.last_page">Last</a>\
		</li>\
	</ul>',
    methods: {
        isCurrentPage(page) {
            return this.data.current_page === page;
        },
        selectPage: function (page) {
            this.$emit('pagination-change-page', page);
        },
        getPages: function () {
            this.data.offset = 6;
            let pages = [];

            let start = this.data.current_page - Math.floor(this.data.offset / 2);
            if (start < 1) {
                start = 1;
            }
            let end = start + this.data.offset - 1;
            if (end > this.data.last_page) {
                end = this.data.last_page;
            }
            while (start <= end) {
                pages.push(start);
                start++;
            }
            return pages;
        }
    }
});
/* -------------------------------------------------------*/
Vue.directive('sortable', {
    twoWay: true,
    deep: true,
    bind: function () {
        var that = this;

        var options = {
            draggable: Object.keys(this.modifiers)[0]
        };

        this.sortable = Sortable.create(this.el, options);
        console.log('sortable bound!');

        this.sortable.option("onUpdate", function (e) {
            that.value.splice(e.newIndex, 0, that.value.splice(e.oldIndex, 1)[0]);
        });

        this.onUpdate = function (value) {
            that.value = value;
        }
    },
    update: function (value) {
        this.onUpdate(value);
    }
});
/* -------------------------------------------------------*/
Vue.filter('eventCreatedDate', function (value) {
    if (value) {
        return moment(value).format('LLL');
    }
});
Vue.filter('eventStartDate', function (value) {
    if (value) {
        return moment(value).format('LL');
    }
});
Vue.filter('eventStartTime', function (value) {
    if (value) {
        return moment(value, 'HH:mm:ss').format('h:mm A')
    }
});
/*------------------------------------------------------*/
// DECLARATION
Vue.filter('readMore', function (text, length, suffix) {
    if (text) {
        return text.substring(0, length) + suffix;
    }
});
/*------------------------------------------------------*/
if ($("#promoter-profile").length > 0) {
    new Vue({
        el: '#promoter-profile',
        data: {
            imagePath: imageurl,
            profile: true,
            editProfile: false,
            my: {},
            events: {},
            error: {
                message: '',
                show: false
            },
            success: {
                message: '',
                show: false
            }
        },
        methods: {
            /*------------------------------------------------------*/
            getMyProfile() {
                let self = this;
                axios.post(baseurl + 'me', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.my = data.payload;
                        console.log(data.payload);
                    } else {
                        self.error.message = data.message;
                        self.error.show = true;
                    }
                });
            },

            /*------------------------------------------------------*/
            saveProfileDetails() {
                let self = this;
                axios.post(apiurl + 'update-profile', this.my, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.success.message = data.message;
                        self.success.show = true;
                        self.error.show = false;
                    } else {
                        self.error.message = data.message;
                        self.error.show = true;
                    }
                    window.scrollTo(0, 0);
                });
            },
            /*------------------------------------------------------*/
            saveSocialDetails() {
                let self = this;
                let socialData = {
                    fb_url: this.my.fb_url,
                    twitter: this.my.twitter,
                    snapchat: this.my.snapchat,
                    insta_url: this.my.insta_url,
                };
                axios.post(apiurl + 'update-social-media', socialData, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.success.message = data.message;
                        self.success.show = true;
                        self.error.show = false;
                    } else {
                        self.error.message = data.message;
                        self.error.show = true;
                    }
                    window.scrollTo(0, 0);
                });
            }
            /*------------------------------------------------------*/
        },
        created() {
            this.getMyProfile();
        }
    });
}

/*------------------------------------------------------*/
/* add account page with add band account details
    and paypal details.
 */
if ($("#add-account").length > 0) {
    var addAccounts = new Vue({
        el: '#add-account',
        data: {
            showPayPal: false,
            bankAccount: {
                bankName: '',
                accountName: '',
                accountNumber: '',
                routingNumber: '',
                currency: '',
                phoneNumber: '',
                termAndConditions: false,
            },
            payPalAccount: {
                payPalName: '',
                payPalEmail: '',
                currency: '',
                phoneNumber: '',
                termAndConditions: false,
            },
            error: {
                bankAccount: {
                    bankName: '',
                    accountName: '',
                    accountNumber: '',
                    routingNumber: '',
                    currency: '',
                    phoneNumber: '',
                    termAndConditions: '',
                    show: false,
                },
                payPalAccount: {
                    payPalName: '',
                    payPalEmail: '',
                    currency: '',
                    phoneNumber: '',
                    termAndConditions: '',
                    show: false,
                },
                message: '',
                show: false
            },
            success: {
                message: '',
                show: false
            },
        },
        methods: {
            /*------------------------------------------------------*/
            /* add account details */
            addBankAccount: function () {
                if (this.validateBankAccount()) {
                    let self = this;
                    let sendData = {
                        bank_name: this.bankAccount.bankName,
                        account_name: this.bankAccount.accountName,
                        account_number: this.bankAccount.accountNumber,
                        bank_currency: this.bankAccount.currency,
                        routing_number: this.bankAccount.routingNumber,
                        bank_phone_no: this.bankAccount.phoneNumber,
                    };
                    axios.post(apiurl + 'add-bank-account', sendData, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            self.bankAccount.bankName = '';
                            self.bankAccount.accountName = '';
                            self.bankAccount.accountNumber = '';
                            self.bankAccount.currency = '';
                            self.bankAccount.routingNumber = '';
                            self.bankAccount.phoneNumber = '';
                            self.bankAccount.termAndConditions = false;

                            swal.fire({
                                title: 'Success',
                                text: data.message,
                                type: 'success'
                            });
                            manageAccounts.getBankAccounts();
                        } else {
                            self.success.show = false;
                            swal.fire({
                                title: 'Oops!',
                                text: data.message,
                                type: 'error'
                            });
                            /*self.error.message = data.message;*/
                            self.error.bankAccount.show = false;
                            /*self.error.show = true;*/
                        }
                    });
                }
            },
            /*------------------------------------------------------*/
            /* add paypal account details */
            addPayPalAccount: function () {
                if (this.validatePayPalAccount()) {
                    /*console.log(this.validEmail(this.payPalAccount.payPalEmail));*/
                    if (this.validEmail(this.payPalAccount.payPalEmail)) {
                        let self = this;
                        let sendData = {
                            'name_paypal': this.payPalAccount.payPalName,
                            'paypal_email': this.payPalAccount.payPalEmail,
                            'pay_pal_currency': this.payPalAccount.currency,
                            'pay_pal_phone_no': this.payPalAccount.phoneNumber,
                        };
                        axios.post(apiurl + 'add-paypal-account', sendData, header).then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                self.payPalAccount.payPalName = '';
                                self.payPalAccount.payPalEmail = '';
                                self.payPalAccount.currency = '';
                                self.payPalAccount.phoneNumber = '';
                                self.payPalAccount.termAndConditions = false;
                                self.error.show = false;

                                swal.fire({
                                    title: 'Success',
                                    text: data.message,
                                    type: 'success'
                                });

                                manageAccounts.getPayPalAccounts();
                            } else {
                                self.success.show = false;
                                self.error.bankAccount.show = false;
                                swal.fire({
                                    title: 'Oops!',
                                    text: data.message,
                                    type: 'error',
                                });
                            }
                        });
                    } else {
                        this.error.payPalAccount.payPalEmail = 'Please enter a valid email address';
                        this.error.payPalAccount.show = true;
                    }
                }
            },
            /*------------------------------------------------------*/
            /* validate bank account details */
            validateBankAccount: function () {
                if (!this.bankAccount.bankName || !this.bankAccount.accountName
                    || !this.bankAccount.accountNumber || !this.bankAccount.routingNumber
                    || !this.bankAccount.currency || !this.bankAccount.phoneNumber
                    || !this.bankAccount.termAndConditions
                ) {
                    if (!this.bankAccount.bankName) {
                        this.error.bankAccount.bankName = 'Bank name cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.bankName = '';
                    }
                    if (!this.bankAccount.accountName) {
                        this.error.bankAccount.accountName = 'Account name cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.accountName = '';
                    }
                    if (!this.bankAccount.accountNumber) {
                        this.error.bankAccount.accountNumber = 'Account number cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.accountNumber = '';
                    }
                    if (!this.bankAccount.routingNumber) {
                        this.error.bankAccount.routingNumber = 'Routing number cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.routingNumber = '';
                    }
                    if (!this.bankAccount.currency) {
                        this.error.bankAccount.currency = 'Currency cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.currency = '';
                    }
                    if (!this.bankAccount.phoneNumber) {
                        this.error.bankAccount.phoneNumber = 'Phone number cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.phoneNumber = '';
                    }
                    if (!this.bankAccount.termAndConditions) {
                        this.error.bankAccount.termAndConditions = 'Please agree to terms and conditions';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.termAndConditions = '';
                    }
                    return false;
                } else {
                    this.error.bankAccount.show = false;
                    this.error.payPalAccount.show = false;
                    this.error.show = false;
                    return true;
                }
            },
            /*------------------------------------------------------*/
            /* validate paypal account details */
            validatePayPalAccount: function () {
                if (!this.payPalAccount.payPalName || !this.payPalAccount.payPalEmail
                    || !this.payPalAccount.currency || !this.payPalAccount.phoneNumber
                    || !this.payPalAccount.termAndConditions
                ) {
                    if (!this.payPalAccount.payPalName) {
                        this.error.payPalAccount.payPalName = 'PayPal name cannot be empty';
                        this.error.payPalAccount.show = true;
                    } else {
                        this.error.payPalAccount.payPalName = '';
                    }
                    if (!this.payPalAccount.payPalEmail) {
                        this.error.payPalAccount.payPalEmail = 'Email cannot be empty';
                        this.error.payPalAccount.show = true;
                    } else {
                        this.error.payPalAccount.payPalEmail = '';
                    }
                    if (!this.payPalAccount.currency) {
                        this.error.payPalAccount.currency = 'Currency cannot be empty';
                        this.error.payPalAccount.show = true;
                    } else {
                        this.error.payPalAccount.currency = '';
                    }
                    if (!this.payPalAccount.phoneNumber) {
                        this.error.payPalAccount.phoneNumber = 'Phone number cannot be empty';
                        this.error.payPalAccount.show = true;
                    } else {
                        this.error.payPalAccount.phoneNumber = '';
                    }
                    if (!this.payPalAccount.termAndConditions) {
                        this.error.payPalAccount.termAndConditions = 'Please agree to terms and conditions';
                        this.error.payPalAccount.show = true;
                    } else {
                        this.error.payPalAccount.termAndConditions = '';
                    }
                    return false;
                } else {
                    this.error.bankAccount.show = false;
                    this.error.payPalAccount.show = false;
                    this.error.show = false;
                    return true;
                }
            },
            /*------------------------------------------------------*/
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/

        }
    });
}
/*------------------------------------------------------*/
/* manage account, edit account, delete account.
    paypal and bank account*/
if ($("#manage-accounts").length > 0) {
    var manageAccounts = new Vue({
        el: '#manage-accounts',
        data: {
            showPayPal: false,
            showBankAccountModal: false,
            showPayPalAccountModal: false,
            bankAccounts: {},
            bankAccount: {},
            payPalAccounts: {},
            payPalAccount: {},
            error: {
                bankAccount: {
                    bankName: '',
                    accountName: '',
                    accountNumber: '',
                    routingNumber: '',
                    currency: '',
                    phoneNumber: '',
                    show: false,
                },
                payPalAccount: {
                    payPalName: '',
                    payPalEmail: '',
                    currency: '',
                    phoneNumber: '',
                    show: false,
                },
                message: '',
                show: false,
            },
            success: {
                message: '',
                show: false,
            },
        },
        watch: {
            showPayPal: function (val) {
                if (val) {
                    this.getPayPalAccounts();
                    addAccounts.showPayPal = true;
                } else {
                    addAccounts.showPayPal = false;
                    this.getBankAccounts();
                }
            }
        },
        methods: {
            /*------------------------------------------------------*/
            getBankAccounts: function (page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'bank-account-list?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.bankAccounts = data.payload;
                    } else {
                        self.bankAccounts = data;
                    }
                });
            },
            /*------------------------------------------------------*/
            getPayPalAccounts: function (page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'paypal-account-list?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.payPalAccounts = data.payload;
                    } else {
                        self.payPalAccounts = data;
                    }
                });
            },
            /*------------------------------------------------------*/
            editBankAccount: function (bank) {
                this.bankAccount = bank;
            },
            /*------------------------------------------------------*/
            editPayPalAccount: function (payPal) {
                this.payPalAccount = payPal;
            },
            /*------------------------------------------------------*/
            resetAccountValue: function () {
                this.bankAccount = {};
                this.payPalAccount = {};
            },
            /*------------------------------------------------------*/
            updateBankAccount: function () {
                if (this.validateBankAccount()) {
                    let self = this;
                    let sendData = this.bankAccount;
                    axios.post(apiurl + 'update-bank-account', sendData, header)
                        .then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                swal.fire({
                                    title: 'Success',
                                    text: data.message,
                                    type: 'success'
                                });
                                self.error.message = '';
                                self.error.show = false;
                                self.bankAccount = data.payload;
                                self.getBankAccounts();
                            } else {
                                self.success.show = false;
                                swal.fire({
                                    title: 'Oops!',
                                    text: data.message,
                                    type: 'error',
                                });
                            }
                        });
                }
            },
            /*------------------------------------------------------*/
            updatePayPalAccount: function () {
                if (this.validatePayPalAccount()) {
                    if (this.validEmail(this.payPalAccount.paypal_email)) {
                        let self = this;
                        let sendData = this.payPalAccount;
                        axios.post(apiurl + 'update-paypal-account', sendData, header)
                            .then(function (response) {
                                let data = response.data;
                                if (data.code === 1) {
                                    swal.fire({
                                        title: 'Success',
                                        text: data.message,
                                        type: 'success'
                                    });
                                    self.error.message = '';
                                    self.error.show = false;
                                    self.payPalAccount = data.payload;
                                    self.getPayPalAccounts();
                                } else {
                                    self.success.show = false;
                                    swal.fire({
                                        title: 'Oops!',
                                        text: data.message,
                                        type: 'error',
                                    });
                                }
                            });
                    } else {
                        this.error.payPalAccount.payPalEmail = 'Please enter a valid email address';
                        this.error.payPalAccount.show = true;
                    }
                }
            },
            /*------------------------------------------------------*/
            deleteBankAccount: function (bankID) {
                let self = this;
                swal.fire({
                    title: 'Are you sure you want to delete this account?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        let sendData = {
                            id: bankID,
                        };
                        axios.post(apiurl + 'delete-bank-account', sendData, header).then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                );
                                self.getBankAccounts();
                            } else {
                                swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'error'
                                );
                                self.success.show = false;
                            }
                        });
                    }
                });
            },
            /*------------------------------------------------------*/
            deletePayPalAccount: function (payPalID) {
                let self = this;
                swal.fire({
                    title: 'Are you sure you want to delete this account?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        let sendData = {
                            id: payPalID,
                        };
                        axios.post(apiurl + 'delete-paypal-account', sendData, header).then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                );
                                self.getPayPalAccounts();
                            } else {
                                swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'error'
                                );
                                self.success.show = false;
                            }
                        });
                    }
                });
            },
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /* validate bank account details */
            validateBankAccount: function () {
                if (!this.bankAccount.bank_name || !this.bankAccount.account_name
                    || !this.bankAccount.account_number || !this.bankAccount.routing_number
                    || !this.bankAccount.bank_currency || !this.bankAccount.bank_phone_no
                ) {
                    if (!this.bankAccount.bank_name) {
                        this.error.bankAccount.bankName = 'Bank name cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.bankName = '';
                    }
                    if (!this.bankAccount.account_name) {
                        this.error.bankAccount.accountName = 'Account name cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.accountName = '';
                    }
                    if (!this.bankAccount.account_number) {
                        this.error.bankAccount.accountNumber = 'Account number cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.accountNumber = '';
                    }
                    if (!this.bankAccount.routing_number) {
                        this.error.bankAccount.routingNumber = 'Routing number cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.routingNumber = '';
                    }
                    if (!this.bankAccount.bank_currency) {
                        this.error.bankAccount.currency = 'Currency cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.currency = '';
                    }
                    if (!this.bankAccount.bank_phone_no) {
                        this.error.bankAccount.phoneNumber = 'Phone number cannot be empty';
                        this.error.bankAccount.show = true;
                    } else {
                        this.error.bankAccount.phoneNumber = '';
                    }
                    return false;
                } else {
                    this.error.bankAccount.show = false;
                    this.error.payPalAccount.show = false;
                    this.error.show = false;
                    return true;
                }
            },
            /*------------------------------------------------------*/
            /* validate paypal account details */
            validatePayPalAccount: function () {
                if (!this.payPalAccount.name_paypal || !this.payPalAccount.paypal_email
                    || !this.payPalAccount.pay_pal_currency || !this.payPalAccount.pay_pal_phone_no
                ) {
                    if (!this.payPalAccount.name_paypal) {
                        this.error.payPalAccount.payPalName = 'PayPal name cannot be empty';
                        this.error.payPalAccount.show = true;
                    } else {
                        this.error.payPalAccount.payPalName = '';
                    }
                    if (!this.payPalAccount.paypal_email) {
                        this.error.payPalAccount.payPalEmail = 'Email cannot be empty';
                        this.error.payPalAccount.show = true;
                    } else {
                        this.error.payPalAccount.payPalEmail = '';
                    }
                    if (!this.payPalAccount.pay_pal_currency) {
                        this.error.payPalAccount.currency = 'Currency cannot be empty';
                        this.error.payPalAccount.show = true;
                    } else {
                        this.error.payPalAccount.currency = '';
                    }
                    if (!this.payPalAccount.pay_pal_phone_no) {
                        this.error.payPalAccount.phoneNumber = 'Phone number cannot be empty';
                        this.error.payPalAccount.show = true;
                    } else {
                        this.error.payPalAccount.phoneNumber = '';
                    }
                    return false;
                } else {
                    this.error.bankAccount.show = false;
                    this.error.payPalAccount.show = false;
                    this.error.show = false;
                    return true;
                }
            },
            /*------------------------------------------------------*/
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/


        },
        mounted() {
            /*------------------------------------------------------*/
            this.getBankAccounts();
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
        }
    });
}

/*------------------------------------------------------*/
if ($("#my-promotion-list").length > 0) {
    new Vue({
        el: '#my-promotion-list',
        data: {
            myPromotions: {},
            promotion: {},
            error: {
                message: '',
                show: false,
            },
            requestType: '',
        },
        watch: {
            requestType: function () {
                this.getMyPromotions();
            }
        },
        methods: {
            getMyPromotions(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                let sendData = {
                    page: page,
                    request_type: this.requestType,
                };
                axios.post(apiurl + 'promo/requests', sendData, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.myPromotions = data.payload;
                    } else {
                        self.myPromotions = {};
                    }
                });
            }
        },
        created() {
            this.getMyPromotions();
        }
    });
}
/*------------------------------------------------------*/
if ($("#my-following-list").length > 0) {
    new Vue({
        el: '#my-following-list',
        data: {
            following: {},
            organizer: {},
            error: {
                message: '',
                show: false,
            }
        },
        methods: {
            /*------------------------------------------------------*/
            getFollowing(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                let sendData = {
                    page: page
                };
                axios.post(apiurl + 'following', sendData, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.following = data.payload;
                    }
                });
            },
            /*------------------------------------------------------*/
            unfollowOrganizer(organizer) {
                let self = this;
                swal.fire({
                    title: 'Are you sure?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Unfollow!'
                }).then((result) => {
                    if (result.value) {
                        let sendData = {
                            followed_user_id: organizer.id
                        };
                        axios.post(baseurl + 'user/unfollow-organizer', sendData, header).then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                swal.fire(
                                    'Unfollowed!',
                                    'Unfollowed ' + organizer.first_name + ' ' + organizer.last_name,
                                    'success'
                                );
                                self.getFollowing();
                            } else {
                                swal.fire(
                                    'Oops!',
                                    data.message,
                                    'error'
                                );
                                self.getFollowing();
                            }
                        });

                    }
                })
            },
            /*------------------------------------------------------*/
            showOrgDetails(organizer) {
                this.organizer = organizer;
            }
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
        },
        created() {
            this.getFollowing();
        }
    });
}
/*------------------------------------------------------*/
if ($("#support-tickets").length > 0) {
    new Vue({
        el: '#support-tickets',
        data: {
            allTickets: {},
            ticket: {},
            error: {
                ticket: {
                    organizer_id: '',
                    category_id: '',
                    message: '',
                    show: false,
                },
                message: '',
                show: false,
            },
            createTicket: {
                organizer_id: '',
                category_id: '',
                subject: '',
                message: '',
                image_one: '',
                image_two: '',
                image_three: '',
                image_four: '',
            },
            organizers: {},
            helpdeskCategories: {}
        },
        methods: {
            /*------------------------------------------------------*/
            onImageChange(e) {
                console.log(e.target.files[0]);
                this.createTicket.image_one = e.target.files[0];
            },
            /*------------------------------------------------------*/
            getMySupportTickets(page) {
                let self = this;
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.post(apiurl + 'help-tickets-all', {page: page}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.allTickets = data.payload;
                    } else {
                        self.allTickets = {}
                    }
                });
            },
            /*------------------------------------------------------*/
            showTicketDetails(ticket) {
                this.ticket = ticket;
            },
            /*------------------------------------------------------*/
            showEditMessage(ticket) {
                this.ticket = ticket;
            },
            /*------------------------------------------------------*/
            updateMessage() {
                if (this.validateForm()) {
                    let self = this;
                    let sendData = {
                        id: this.ticket.id,
                        message: this.ticket.message,
                    };
                    axios.post(apiurl + 'update-help-ticket-message', sendData, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            swal.fire('success', data.message, 'success');
                            self.getMySupportTickets();
                        } else {
                            this.error.message = data.message;
                            this.error.show = true;
                        }
                    });
                }
            },
            /*------------------------------------------------------*/
            cancelEditTicketMessage() {
                this.ticket = {};
            },
            /*------------------------------------------------------*/
            validateForm() {
                if (!this.ticket.message) {
                    this.error.message = 'Message is required';
                    this.error.show = true;
                    return false;
                } else {
                    this.error.message = '';
                    this.error.show = false;
                    return true;
                }
            },
            /*------------------------------------------------------*/
            validateCreateTicket() {
                if (!this.createTicket.organizer_id || !this.createTicket.category_id
                    || !this.createTicket.subject || !this.createTicket.message
                ) {
                    if (!this.createTicket.organizer_id) {
                        this.error.ticket.organizer_id = 'Please select an organizer';
                        this.error.ticket.show = true;
                    } else {
                        this.error.ticket.organizer_id = '';
                    }
                    if (!this.createTicket.category_id) {
                        this.error.ticket.category_id = 'please select a category';
                        this.error.ticket.show = true;
                    } else {
                        this.error.ticket.category_id = '';
                    }
                    if (!this.createTicket.subject) {
                        this.error.ticket.subject = 'Please enter a subject.';
                        this.error.ticket.show = true;
                    } else {
                        this.error.ticket.subject = '';
                    }
                    if (!this.createTicket.message) {
                        this.error.ticket.message = 'Please write a message.';
                        this.error.ticket.show = true;
                    } else {
                        this.error.ticket.message = '';
                    }
                    return false;
                } else {
                    this.error.ticket.show = false;
                    return true;
                }
            },
            /*------------------------------------------------------*/
            createSupportTicket() {
                if (this.validateCreateTicket()) {
                    let create_support_ticket_button = $("#create-support-ticket-button");
                    create_support_ticket_button.attr("disabled", true);
                    create_support_ticket_button.html('creating...');
                    let self = this;
                    let formData = new FormData();
                    formData.append('image_one', this.createTicket.image_one);
                    formData.append('organizer_id', this.createTicket.organizer_id);
                    formData.append('help_category', this.createTicket.category_id);
                    formData.append('subject', this.createTicket.subject);
                    formData.append('message', this.createTicket.message);
                    axios.post(apiurl + 'create-help-ticket', formData, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            swal.fire('success', data.message, 'success');
                            self.createTicket.image_one = '';
                            self.createTicket.organizer_id = '';
                            self.createTicket.category_id = '';
                            self.createTicket.subject = '';
                            self.createTicket.message = '';
                            $("#ticket_image").val('');
                            self.getMySupportTickets();
                            create_support_ticket_button.attr("disabled", false);
                            create_support_ticket_button.html('create');
                        } else {
                            swal.fire('Oops!', data.message, 'error');
                            create_support_ticket_button.attr("disabled", false);
                            create_support_ticket_button.html('create');
                        }
                    });
                }
            },
            /*------------------------------------------------------*/
            getOrganizers() {
                let self = this;
                axios.post(baseurl + 'organizer-list', {}).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.organizers = data.payload;
                    } else {
                        self.organizers = {};
                    }
                });
            },
            /*------------------------------------------------------*/
            getHelpdeskCategory() {
                let self = this;
                axios.post(baseurl + 'help-categories', {}).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.helpdeskCategories = data.payload;
                    } else {
                        self.helpdeskCategories = {};
                    }
                });
            },
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
        },
        created() {
            this.getMySupportTickets();
            this.getOrganizers();
            this.getHelpdeskCategory();
        }
    });
}
/*------------------------------------------------------*/
/*------------------------------------------------------*/
/*------------------------------------------------------*/
/*------------------------------------------------------*/
/*------------------------------------------------------*/
/*------------------------------------------------------*/
/*------------------------------------------------------*/


/* get cookies */
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
}
