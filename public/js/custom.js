loadProgressBar();
$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
var authToken = '';
var token = getCookie('token');
var header = {
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + token
    }
};
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
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

    template: '<ul class="pagination"  v-if="data.total > data.per_page">\
        <li v-if="data.prev_page_url">\
            <a href="#" @click.prevent="selectPage(1)" :disabled="data.current_page <= 1">\
                <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>\
            </a>\
        </li>\
		<li v-if="data.prev_page_url">\
			<a href="#" aria-label="Previous" @click.prevent="selectPage(--data.current_page)">\
			    <span aria-hidden="true"><i class="fa fa-angle-left" aria-hidden="true"></i></span>\
			</a>\
		</li>\
		<li v-for="n in getPages()" :class="{ \'active\': n == data.current_page }">\
		    <a  href="#" @click.prevent="selectPage(n)">{{ n }}</a>\
        </li>\
		<li v-if="data.next_page_url">\
			<a href="#" aria-label="Next" @click.prevent="selectPage(++data.current_page)">\
			    <span aria-hidden="true"><i class="fa fa-angle-right" aria-hidden="true"></i></span>\
            </a>\
		</li>\
		<li v-if="data.next_page_url">\
		    <a href="#" @click.prevent="selectPage(data.last_page)" :disabled="data.current_page >= data.last_page">\
		        <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>\
		    </a>\
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
            this.data.offset = 5;
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
/*-------------------------------------------------------------*/
/* -------------------------------------------------------*/
Vue.component('pagination2', {
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
            this.data.offset = 4;
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
/*-------------------------------------------------------------*/
const showLogin = function () {
    login.formOne = true;
    login.formTwo = false;
    login.formThree = false;
};
/*-------------------------------------------------------------*/
const showRegister = function () {
    login.formOne = false;
    login.formTwo = false;
    login.formThree = true;
};

/*-------------------------------------------------------------*/
/* filters for date */
Vue.filter('eventCreatedDate', function (value) {
    if (value) {
        return moment(value).format('LLL');
    }
});
Vue.filter('orderCreatedAt', function (value) {
    if (value) {
        return moment(value).format('L');
    }
});
Vue.filter('orderCreatedFull', function (value) {
    if (value) {
        return moment(value).format('LLLL');
    }
});
Vue.filter('eventStartDate', function (value) {
    if (value) {
        /*return moment(value ).format('d MMMM YYYY');*/
        return moment(value, 'YYYY-MM-D').format('D MMMM YYYY');
    }
});
Vue.filter('eventStartTime', function (value) {
    if (value) {
        return moment(value, 'HH:mm:ss').format('h:mm A')
    }
});
Vue.filter('eventFullDate', function (value) {
    if (value) {
        return moment(value).format('dddd, D MMMM YYYY');
    }
});
Vue.filter('eventStartDateDay', function (value) {
    if (value) {
        return moment(value).format('D');
    }
});
Vue.filter('eventStartDateFullDay', function (value) {
    if (value) {
        return moment(value).format('dddd');
    }
});

Vue.filter('eventStartDateMonth', function (value) {
    if (value) {
        return moment(value).format('MMMM');
    }
});

Vue.filter('eventStartDateYear', function (value) {
    if (value) {
        return moment(value).format('YYYY');
    }
});
Vue.filter('eventStartDateSearchEvent', function (value) {
    if (value) {
        return moment(value).format('MMMM. Do, YYYY')
    }
});
Vue.filter('capitalize', function (value) {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
});
/*-------------------------------------------------------------*/
// DECLARATION
Vue.filter('readMore', function (text, length, suffix) {
    if (text) {
        return text.substring(0, length) + suffix;
    }
});
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
// login
if ($('#login').length === 1) {
    var login = new Vue({
        el: '#login',
        data: {
            email: '',
            password: '',
            error: {
                show: false,
                message: '',
                firstName: '',
                lastName: '',
                regEmail: ''
            },
            success: {
                message: '',
                show: false
            },
            username: {
                first: '', last: ''
            },
            formOne: true,
            formTwo: false,
            formThree: false,
            showError: false,
            regFirstName: '',
            regLastName: '',
            regEmail: ''
        },
        methods: {
            checkEmail: function () {
                if (this.email === '') {
                    this.error.message = 'email cannot be empty!';
                    this.error.show = true;
                } else {
                    let self = this;
                    axios.post(apiurl + 'login-step-1', {email: this.email}).then(function (response) {
                        let res = response.data;
                        if (res.code === 0) {
                            self.error.message = res.message;
                            self.error.show = true;
                            // alertify.error(res.message);
                        } else {
                            let user = res.payload;
                            self.error.show = false;
                            self.formOne = false;
                            self.username.first = user.first_name;
                            self.username.last = user.last_name;
                            self.formTwo = true;
                        }
                    });
                }
            },
            userLogin: function () {
                if (this.password === '') {
                    this.error.message = 'Password cannot be empty!';
                    this.error.show = true;
                } else {
                    let self = this;
                    let sendData = {
                        email: this.email,
                        password: this.password,
                    };
                    axios.post(apiurl + 'login', sendData).then(function (response) {
                        let data = response.data;
                        if (data.code === 0) {
                            self.password = '';
                            self.error.message = data.message;
                            self.error.show = true;
                        } else {
                            self.error.show = false;
                            authToken = data.payload.token;
                            createCookie('email', data.payload.email);
                            createCookie('token', authToken);
                            createCookie('came_from_single', localStorage.getItem('came_from_single'));
                            localStorage.removeItem('came_from_single');
                            window.location = weburl + data.redirect_url;
                        }
                    });
                }
            },

            resetPasswordLink: function () {
                this.error.show = false;
                if (!this.email) {
                    this.error.message = 'Email cannot be empty';
                    this.error.show = true;
                } else {
                    let self = this;
                    let sendData = {email: this.email};
                    axios.post(apiurl + 'forgot-password', sendData).then(response => {
                        let data = response.data;
                        if (data.code === 0) {
                            self.error.message = data.message;
                            self.error.show = true;
                        } else {
                            self.error.show = false;
                            self.success.message = 'Reset password link sent to your email ';
                            self.success.show = true;
                        }
                    });
                }
            },

            register: function () {
                if (!this.regFirstName) {
                    this.success.show = false;
                    this.error.firstName = 'First name cannot be empty';
                    this.error.show = true;
                } else {
                    this.error.firstName = '';
                }
                if (!this.regLastName) {
                    this.success.show = false;
                    this.error.lastName = 'Last name cannot be empty';
                    this.error.show = true;
                } else {
                    this.error.lastName = '';
                }
                if (!this.regEmail) {
                    this.success.show = false;
                    this.error.regEmail = 'Email cannot be empty';
                    this.error.show = true;
                } else {
                    this.error.regEmail = '';
                }
                // registration email
                if (this.regFirstName && this.regLastName && this.regEmail) {
                    if (!this.validEmail(this.regEmail)) {
                        this.success.show = false;
                        this.error.regEmail = 'Please enter a valid email address';
                        this.error.show = true;
                    } else {
                        let self = this;
                        let sendData = {
                            first_name: this.regFirstName,
                            last_name: this.regLastName,
                            email: this.regEmail
                        };
                        axios.post(apiurl + 'register', sendData).then(function (response) {
                            let data = response.data;
                            if (data.code === 0) {
                                self.success.message = '';
                                self.success.show = false;
                                self.password = '';
                                self.error.message = data.message;
                                self.error.show = true;
                            } else {
                                self.success.message = data.message;
                                self.success.show = true;
                                self.error.message = '';
                                self.error.show = false;
                                self.regFirstName = '';
                                self.regLastName = '';
                                self.regEmail = '';
                            }
                        });
                    }
                }
            },

            // validating email address
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        }
    });
}
/*-------------------------------------------------------------*/
/* register */
if ($('#completeRegister').length === 1) {
    var completeRegister = new Vue({
        el: '#completeRegister',
        data: {
            token: '',
            email: '',
            password: '',
            confirmPassword: '',
            error: {
                show: false,
                message: '',
            },
            success: {
                show: false,
                message: ''
            },
        },
        methods: {
            completeRegister: function () {
                if (!this.password || !this.confirmPassword) {
                    this.error.message = "Both fields are required!";
                    this.error.show = true;
                } else if (this.password !== this.confirmPassword) {
                    this.error.message = 'Both password should be same';
                    this.error.show = true;
                } else if (this.password.length < 6) {
                    this.error.message = "password must be greater then 5 characters";
                    this.error.show = true;
                } else {
                    let sendData = {
                        email: this.email,
                        token: this.token,
                        password: this.password,
                        password_confirmation: this.confirmPassword
                    };
                    let self = this;
                    axios.post(apiurl + 'complete-register', sendData, {}).then(function (response) {
                        let data = response.data;
                        if (data.code === 0) {
                            self.error.message = data.message;
                            // self.error.message = data.message.password[0];
                            self.error.show = true;
                        } else if (data.code === 1) {
                            swal.fire({
                                title: 'Success',
                                text: data.message,
                                type: 'success',
                                allowOutsideClick: false
                            }).then(function(val){
                                if(val){
                                    authToken = data.payload.token;
                                    createCookie('email', data.payload.user.email);
                                    window.location = weburl + data.payload.redirect_url;
                                }
                            });
                            /*self.error.message = '';
                            self.error.show = false;
                            self.success.message = 'Registration completed!';
                            self.success.show = true;*/
                        }
                    });
                }
            }
        }
    });
}
/*-------------------------------------------------------------*/
/* send email to reset user password */
if ($('#reset-pass-email').length === 1) {
    var resetPassEmail = new Vue({
        el: '#reset-pass-email',
        data: {
            email: '',
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
            resetPasswordLink: function () {
                this.error.show = false;
                if (!this.email) {
                    this.error.message = 'Email cannot be empty';
                    this.error.show = true;
                } else {
                    let self = this;
                    let sendData = {email: this.email};
                    axios.post(apiurl + 'forgot-password', sendData).then(response => {
                        let data = response.data;
                        if (data.code === 0) {
                            self.error.message = data.message;
                            self.error.show = true;
                        } else {
                            self.error.show = false;
                            self.success.message = 'Reset password link sent to your email.';
                            self.success.show = true;
                            self.email = '';
                        }
                    });
                }
            }
        },
    })
}
/*-------------------------------------------------------------*/
/* reset user password */
if ($('#reset-pass').length === 1) {
    var resetPass = new Vue({
        el: '#reset-pass',
        data: {
            password: '',
            confirmPassword: '',
            token: '',
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
            resetPassword: function () {
                if (!this.password || !this.confirmPassword) {
                    this.error.message = 'Both fields are required';
                    this.error.show = true;
                } else if (this.password.length < 6) {
                    this.error.message = 'Password cannot be less then 6 characters.';
                    this.error.show = true;
                } else if (this.password !== this.confirmPassword) {
                    this.error.message = 'Both password must be same.';
                    this.error.show = true;
                } else {
                    this.error.show = false;
                    let self = this;
                    let sendData = {
                        token: this.token,
                        password: this.password,
                        password_confirmation: this.confirmPassword,
                    };
                    axios.post(apiurl + 'reset-password', sendData).then(response => {
                        let data = response.data;
                        if (data.code === 1) {
                            self.success.message = data.message;
                            self.success.show = true;
                            self.password = '';
                            self.confirmPassword = '';
                            window.location = data.payload.redirect_url;
                        } else {
                            self.error.message = data.message;
                            self.error.show = true;
                        }
                    });
                }
            }
        },
    })
}
/*-------------------------------------------------------------*/
if ($("#landing-page").length === 1) {
    var welcome = new Vue({
        el: '#landing-page',
        data: {
            categories: {},
            categoriesPage: 1,
            events: {},
            allEvents: {},
            eventsPage: 1,
            today: {
                day: '',
                month: '',
                year: '',
            },
            imageUrl: imgurl,
            eventImageUrl: event_image_url,
            search: '',
            webUrl: weburl,
            location: {
                lat: 37.755104,
                lng: -122.448591,
            },
            map: {},
            geocoder: {},
            currentLocation: '',
            currentLocationError: '',
            changeCurrentLocation: false,
            newCurrentLocation: '',
        },
        mounted() {
            setTimeout(function () {
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 8,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 4,
                            autoplay: true,
                            autoplayTimeout: 2000,
                            autoplayHoverPause: true,
                            nav: false
                        },
                        600: {
                            items: 4,
                            autoplay: true,
                            autoplayTimeout: 2000,
                            autoplayHoverPause: true,
                            nav: false
                        },
                        1000: {
                            items: 4,
                            nav: false,
                            autoplay: true,
                            autoplayTimeout: 2000,
                            autoplayHoverPause: true,
                            margin: 20
                        }
                    }
                });
            }, 2000);
            this.geocoder = new google.maps.Geocoder();
            this.getCurrentLocation();
        },
        watch: {
            changeCurrentLocation: function (val) {
                let self = this;
                if (val === true) {
                    this.$nextTick(function () {
                        let input = self.$refs.locationInputField;
                        self.autocomplete = new google.maps.places.Autocomplete(input);
                    });
                }
            },
        },
        methods: {
            getCurrentCountryName() {
                let self = this;
                let latlng = new google.maps.LatLng(this.location.lat, this.location.lng);
                this.geocoder.geocode({'latLng': latlng}, function (results, status) {
                    let address;
                    if (status == google.maps.GeocoderStatus.OK) {
                        self.currentLocation = '';
                        results.forEach(function (val) {
                            if (val.types[0] == 'administrative_area_level_1') {
                                self.currentLocation = val.formatted_address;
                            }
                        });
                    } else {
                        alert("Find location failed due to: " + status);
                    }
                });
                this.getEvents();
            },
            /*-------------------------------------------------------------*/
            updatePlace(ev) {
                let self = this;
                let place = this.autocomplete.getPlace();
                this.location.lat = place.geometry.location.lat();
                this.location.lng = place.geometry.location.lng();
                if (place) {
                    self.currentLocation = '';
                    self.changeCurrentLocation = false;
                    place.address_components.forEach(function (val) {
                        if (val.types[0] === 'administrative_area_level_1' || val.types[0] === 'country'
                            || val.types[0] === 'sublocality_level_1' || val.types[0] === 'locality') {
                            self.currentLocation += (val.long_name + ', ');
                        }
                    });
                    this.getEvents();
                } else {
                    alert('something went wrong! your location cannot be updated.');
                }
            },
            /*-------------------------------------------------------------*/
            getCategories(page) {
                let self = this;
                axios.post(apiurl + 'all-category-list').then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.categories = data.payload;
                    } else {
                        self.categories = data.message;
                    }
                });
            },
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /* get events list */
            getEvents(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'all-events?page=' + page + '&lat=' + self.location.lat + '&lng=' + self.location.lng)
                    .then(function (response) {
                        let data = response.data;
                        if (page === 1) {
                            if (data.code === 1) {
                                self.allEvents = data.payload;
                                //set minimum paid price
                                // There's no real number bigger than plus Infinity
                                for (let p = 0; p < self.allEvents.data.length; p++) {
                                    self.allEvents.data[p].totalQuantity = 0;
                                    self.allEvents.data[p].isSoldOut = '';
                                    let lowest = Number.POSITIVE_INFINITY;
                                    let highest = Number.NEGATIVE_INFINITY;
                                    let tmp;
                                    for (let i = self.allEvents.data[p].r_e_l_event_ticket.length - 1; i >= 0; i--) {
                                        self.allEvents.data[p].totalQuantity = self.allEvents.data[p].totalQuantity
                                            + self.allEvents.data[p].r_e_l_event_ticket[i].quantity;
                                        if (self.allEvents.data[p].r_e_l_event_ticket[i].quantity > 0) {
                                            if (self.allEvents.data[p].r_e_l_event_ticket[i].price >= 0) {
                                                tmp = self.allEvents.data[p].r_e_l_event_ticket[i].price;
                                                if (tmp < lowest) lowest = tmp;
                                                if (tmp > highest) highest = tmp;
                                            }
                                        }
                                    }
                                    if (lowest !== Infinity) {
                                        self.allEvents.data[p].minPrice = lowest;
                                        self.allEvents.data[p].maxPrice = highest;
                                    } else {
                                        self.allEvents.data[p].minPrice = 0;
                                    }
                                    if (self.allEvents.data[p].totalQuantity <= 0) {
                                        self.allEvents.data[p].isSoldOut = 'sold-out';
                                    }
                                }
                            } else {
                                self.allEvents = data.message;
                            }
                        } else {
                            if (data.code === 1) {
                                for (let i = 0; i < data.payload.data.length; i++) {
                                    self.allEvents.data.push(data.payload.data[i]);
                                }
                                self.eventsPage++;
                                self.allEvents.data.push();
                                self.allEvents.current_page = data.payload.current_page;
                                self.allEvents.from = data.payload.from;
                                self.allEvents.last_page = data.payload.last_page;
                                self.allEvents.next_page_url = data.payload.next_page_url;
                                self.allEvents.path = data.payload.path;
                                self.allEvents.per_page = data.payload.per_page;
                                self.allEvents.prev_page_url = data.payload.prev_page_url;
                                self.allEvents.to = data.payload.to;
                                self.allEvents.total = data.payload.total;
                                //set minimum paid price
                                // There's no real number bigger than plus Infinity
                                for (let p = 0; p < self.allEvents.data.length; p++) {
                                    self.allEvents.data[p].totalQuantity = 0;
                                    self.allEvents.data[p].isSoldOut = '';
                                    let lowest = Number.POSITIVE_INFINITY;
                                    let highest = Number.NEGATIVE_INFINITY;
                                    let tmp;
                                    for (let i = self.allEvents.data[p].r_e_l_event_ticket.length - 1; i >= 0; i--) {
                                        self.allEvents.data[p].totalQuantity = self.allEvents.data[p].totalQuantity
                                            + self.allEvents.data[p].r_e_l_event_ticket[i].quantity;
                                        if (self.allEvents.data[p].r_e_l_event_ticket[i].quantity > 0) {
                                            if (self.allEvents.data[p].r_e_l_event_ticket[i].price >= 0) {
                                                tmp = self.allEvents.data[p].r_e_l_event_ticket[i].price;
                                                if (tmp < lowest) lowest = tmp;
                                                if (tmp > highest) highest = tmp;
                                            }
                                        }
                                    }
                                    if (lowest !== Infinity) {
                                        self.allEvents.data[p].minPrice = lowest;
                                        self.allEvents.data[p].maxPrice = highest;
                                    } else {
                                        self.allEvents.data[p].minPrice = 0;
                                    }
                                    if (self.allEvents.data[p].totalQuantity <= 0) {
                                        self.allEvents.data[p].isSoldOut = 'sold-out';
                                    }
                                }
                            } else {
                                self.allEvents = data.message;
                            }
                        }
                        /*console.log(self.allEvents);*/
                    });
            },
            /*-------------------------------------------------------------*/
            getWeeksEvents() {
                let self = this;
                axios.post(apiurl + 'upcoming-event-list', {}).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload.data;
                        //set minimum paid price
                        // There's no real number bigger than plus Infinity
                        for (var p = 0; p < self.events.length; p++) {
                            self.events[p].totalQuantity = 0;
                            self.events[p].isSoldOut = '';
                            let lowest = Number.POSITIVE_INFINITY;
                            let highest = Number.NEGATIVE_INFINITY;
                            let tmp;
                            for (var i = self.events[p].r_e_l_event_ticket.length - 1; i >= 0; i--) {
                                self.events[p].totalQuantity = self.events[p].totalQuantity
                                    + self.events[p].r_e_l_event_ticket[i].quantity;
                                if (self.events[p].r_e_l_event_ticket[i].quantity > 0) {
                                    if (self.events[p].r_e_l_event_ticket[i].price >= 0) {
                                        tmp = self.events[p].r_e_l_event_ticket[i].price;
                                        if (tmp < lowest) lowest = tmp;
                                        if (tmp > highest) highest = tmp;
                                    }
                                }
                            }
                            if (lowest !== Infinity) {
                                self.events[p].minPrice = lowest;
                                self.events[p].maxPrice = highest;
                            } else {
                                self.events[p].minPrice = 0;
                            }
                            if (self.events[p].totalQuantity <= 0) {
                                self.events[p].isSoldOut = 'sold-out';
                            }
                        }
                        /*console.log(self.events[1].maxPrice);*/
                    }
                });
            },
            /*-------------------------------------------------------------*/
            searchEvent(category_id) {
                localStorage.setItem('search_event', this.search);
                localStorage.setItem('category_id', category_id);
                window.location = weburl + 'search';
            },
            /*-------------------------------------------------------------*/
            getCurrentLocation() {
                let self = this;
                let address = {};
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        self.location.lat = position.coords.latitude;
                        self.location.lng = position.coords.longitude;
                        /*self.getCurrentCountryName(position.coords.latitude, position.coords.longitude);*/
                        self.getCurrentCountryName();
                    }, function (error) {
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                self.currentLocationError = "You denied the request for Geolocation.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                self.currentLocationError = "Location information is unavailable.";
                                break;
                            case error.TIMEOUT:
                                self.currentLocationError = "The request to get user location timed out.";
                                break;
                            case error.UNKNOWN_ERROR:
                                self.currentLocationError = "An unknown error occurred.";
                                break;
                        }
                    });
                } else {
                    self.currentLocationError = "Geolocation is not supported by this browser.";
                    self.getCurrentCountryName();
                }
            },
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
        },
        created() {
            /*this.getEvents();*/
            this.getCategories();
            this.getWeeksEvents();
            this.today.day = moment().format('DD');
            this.today.month = moment().format('MMMM');
            this.today.year = moment().format('YYYY');
            /*this.getCurrentLocation();*/
        },
    });
}
/*-------------------------------------------------------------*/
if ($("#single-event").length === 1) {
    var singleEvent = new Vue({
        el: '#single-event',
        data: {
            event: {},
            imgUrl: imgurl,
            ticketDetails: [],
            eventImgUrl: event_image_url,
            item: {},
            additional: [],
            minPrice: 0,
            maxPrice: 0,
            promoterMessage: '',
            promoterAcceptAgreement: false,
            error: {
                promoterMessage: '',
                promoterAcceptAgreement: '',
                show: false,
            },
            user: {},
            isLoggedIn: false,
            isFollowing: false,
            me: false,
            organizer: {},
            baseHomeUrl: basehomeurl
        },
        methods: {
            /*--------------------------------------------------------------*/
            /*selectTicket(ticket){
                console.log(this.ticketDetails);
            },*/
            /*--------------------------------------------------------------*/
            showCheckout(ticketDetails) {
                let self = this;
                let checkoutDetails = [];
                let j = 0;
                for (let i = 0; i < ticketDetails.length; i++) {
                    if (ticketDetails[i].selected > 0 && ticketDetails[i].quantity > 0) {
                        checkoutDetails[j] = ticketDetails[i];
                        for (let k = 0; k < ticketDetails[i].selected - 1; k++) {
                            checkoutDetails[j].attendees[k] = {
                                first_name: '',
                                last_name: '',
                                email: '',
                            };
                        }
                        j++;
                    }
                }

                if (checkoutDetails.length < 1) {
                    swal.fire('Oops!', 'please select at least one ticket', 'warning');
                } else {
                    localStorage.setItem('ticket_details', JSON.stringify(checkoutDetails));
                    localStorage.setItem('event_details', JSON.stringify(this.event));
                    //setting timer for cart page
                    let countDownDate = new Date().getTime() + (5 * 60000);
                    localStorage.setItem('count_down_date', countDownDate);
                    localStorage.setItem('came_from_single', 1);
                    window.location = weburl + 'checkout';
                }
            },
            /*--------------------------------------------------------------*/
            // send promotion request to event organizer
            sendPromotionRequest() {
                let self = this;
                if (!this.promoterMessage && !this.promoterAcceptAgreement) {
                    this.error.promoterMessage = 'Please write a message for organizer.';
                    this.error.promoterAcceptAgreement = 'You must agree to terms of service';
                    this.error.show = true;
                } else if (!this.promoterMessage) {
                    this.error.promoterAcceptAgreement = '';
                    this.error.promoterMessage = 'Please write a message for organizer.';
                    this.error.show = true;
                } else if (!this.promoterAcceptAgreement) {
                    this.error.promoterMessage = '';
                    this.error.promoterAcceptAgreement = 'You must agree to terms of service';
                    this.error.show = true;
                } else {
                    this.error.show = false;
                    if (this.isLoggedIn) {
                        let sendData = {
                            request_type: this.promoterMessage,
                            event_id: this.event.id,
                        };
                        axios.post(apiurl + 'promoter/promotion-request', sendData, header).then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                self.promoterMessage = '';
                                self.promoterAcceptAgreement = false;
                                swal.fire('success', data.message, 'success');
                            } else {
                                swal.fire('Oops!', data.message, 'error');
                            }
                        });
                    } else {
                        alertify.error('Please Login / SignUp first');
                    }
                }
            },
            /*--------------------------------------------------------------*/
            /*--------------------------------------------------------------*/
            getEvent(event_id) {
                let self = this;
                axios.post(apiurl + 'view-single-event', {id: event_id}).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.event = data.payload;
                        if (self.event.aditional_information) {
                            self.additional = self.event.aditional_information.split(',');
                        }
                        //set minimum paid price
                        // There's no real number bigger than plus Infinity
                        let lowest = Number.POSITIVE_INFINITY;
                        let highest = Number.NEGATIVE_INFINITY;
                        let tmp;
                        for (var i = self.event.r_e_l_event_ticket.length - 1; i >= 0; i--) {
                            if (self.event.r_e_l_event_ticket[i].quantity > 0) {
                                if (self.event.r_e_l_event_ticket[i].price >= 0) {
                                    tmp = self.event.r_e_l_event_ticket[i].price;
                                    if (tmp < lowest) lowest = tmp;
                                    if (tmp > highest) highest = tmp;
                                }
                            }
                        }
                        self.ticketDetails = self.event.r_e_l_event_ticket.map(function (value, index) {
                            value.selected = 0;
                            value.attendees = [];
                            return value;
                        });
                        /*console.log(self.ticketDetails);*/
                        if (lowest !== Infinity) {
                            self.minPrice = lowest;
                        } else {
                            self.minPrice = 0;
                        }
                        if (highest !== Infinity) {
                            self.maxPrice = highest;
                        } else {
                            self.maxPrice = 0;
                        }
                        // self.additional_information = self.event.additional_information;
                        self.getOrganizerDetails(self.event.r_e_l__event__organizer.id);
                        self.renderGoogleMap(self.event.cityLat, self.event.cityLng);
                        self.getFollowing();
                    } else {
                        swal.fire({
                            title: 'Oops',
                            text: data.message,
                            type: 'error',
                            confirmButtonText: 'close',
                            allowOutsideClick: false
                        }).then(function (value) {
                            window.location = weburl;
                        });
                    }
                });
            },
            /*--------------------------------------------------------------*/
            // get user details if logged in
            /*getUser(){
                if(token){
                    let self = this;
                    axios.post(apiurl + 'me', {}, header).then(function (response) {
                        let data = response.data;
                        if(data.code === 1){
                            self.user = data.payload;
                            self.isLoggedIn = true;
                        }
                    });
                }
            }*/
            /*--------------------------------------------------------------*/
            // get all the list of organizer i'm following
            getFollowing() {
                let self = this;
                axios.get(apiurl + 'user/following-list', header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        data.payload.data.map(function (val, index) {
                            if (val.followed_user_id == self.event.r_e_l__event__organizer.id) {
                                self.isFollowing = true;
                            }
                        });
                    }
                });
            },
            /*--------------------------------------------------------------*/
            //follow organizer
            follow(org_id) {
                let self = this;
                let sendData = {
                    followed_user_id: org_id,
                };
                axios.post(apiurl + 'user/follow-organizer', sendData, header).then(function (response) {
                    if (response.data.code === 1) {
                        self.isFollowing = true;
                        self.getFollowing();
                    }
                }).catch(function (error) {
                    alertify.error('please login/signup');
                });
            },
            /*--------------------------------------------------------------*/
            //unfollow organizer
            unFollow(org_id) {
                let self = this;
                let sendData = {
                    followed_user_id: org_id,
                };
                axios.post(apiurl + 'user/unfollow-organizer', sendData, header).then(function (response) {
                    if (response.data.code === 1) {
                        self.isFollowing = false;
                        self.getFollowing();
                    }
                });
            },
            /*-------------------------------------------------------------*/
            // organizer details
            getOrganizerDetails(id) {
                let self = this;
                let sendData = {
                    user_id: id
                };
                axios.post(apiurl + 'view-organizer-profile', sendData).then(function (response) {
                    if (response.data.code === 1) {
                        self.organizer = response.data.payload;
                    }
                });
            },
            /*-------------------------------------------------------------*/
            //display google maps for event location
            renderGoogleMap(clat, clng){
                let center = {
                    lat: parseFloat(clat),
                    lng: parseFloat(clng)
                };
                let map = new google.maps.Map(document.getElementById('map'), {
                    center: center,
                    zoom: 12
                });
                // The marker, positioned at center
                new google.maps.Marker({position: center, map: map});
            }
        },
        /*--------------------------------------------------------------*/
        /*--------------------------------------------------------------*/
        created() {
            let event_id = getCookie('single_event');
            // make this event id dynamic
            this.getEvent(event_id);
        },
        /*--------------------------------------------------------------*/
        beforeUpdate() {
            if (token && this.event) {
                let current_user_email = getCookie('email');
                if (current_user_email === this.event.r_e_l__event__organizer.email) {
                    this.me = true;
                }
                this.isLoggedIn = true;
                // this.getFollowing();
            }
        },
        /*--------------------------------------------------------------*/
        updated() {
            // The slider being synced must be initialized first
            $('#carousel').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 160,
                itemMargin: 5,
                asNavFor: '#slider'
            });

            $('#slider').flexslider({
                animation: "slide",
                controlNav: false,
                directionNav: false,
                animationLoop: false,
                slideshow: false,
                sync: "#carousel"
            });
        }
    });
}
/*-------------------------------------------------------------*/
var checkout = [];
if ($("#checkout-section").length === 1) {
    new Vue({
        el: '#checkout-section',
        data: {
            /*ticketDetails: getJsonCookie('checkout_details'),*/
            event: {},
            imgUrl: imgurl,
            eventImgUrl: event_image_url,
            item: {},
            ticketDetails: [],
            total: 0,
            buyer: {
                first_name: '',
                last_name: '',
                email: '',
                confirm_email: '',
                phone: '',
                billing_address: '',
                billing_country: '',
                billing_city: '',
                billing_state: '',
                billing_zip: '',
                billing_address_2: '',
                billing_landmark: '',
                is_save_info: false,
            },
            isAgreeToTerms: false,
            ticketHolder: {
                first_name: '',
                last_name: '',
                email: '',
            },
            coupon: {
                id: null
            },
            error: {
                buyer: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    confirm_email: '',
                    phone: '',
                    billing_address: '',
                    billing_country: '',
                    billing_city: '',
                    billing_state: '',
                    billing_zip: '',
                    billing_address_2: '',
                    billing_landmark: '',
                    message: '',
                    isAgreeToTerms: '',
                    show: false,
                },
                show: false,
                message: '',
            },
            hideInputFields: false,
            showProceedToPay: true,
            showPaymentOptions: false,
            payment_type: 'paypal',
            savedInDB: 0,
            order: {},
            bookNow: true,
            countries: [
                {id: 231, sortname: 'US', name: 'United States'},
                {id: 38, sortname: 'CA', name: 'Canada'},
                {id: 230, sortname: 'GB', name: 'United Kingdom'},
                {id: 83, sortname: 'GH', name: 'Ghana'},
                {id: 160, sortname: 'NG', name: 'Nigeria'}
            ],
            states: {},
            minutes: 5,
            seconds: 0,
            minPrice: 0,
            maxPrice: 0,
            allTicketDetails: {},
            user: {},
        },
        watch: {
            payment_type: function (val) {
                if (val === 'paypal') {
                    this.showPayPalCheckout();
                }
            },
        },
        methods: {
            /*-------------------------------------------------------------*/
            proceedToPay() {
                if (this.validateForm()) {
                    let self = this;
                    if (this.validEmail(this.buyer.email)) {
                        this.showProceedToPay = false;
                        this.createOrder(function (data) {
                            if (data.code) {
                                self.order = data.payload;
                                self.disableInputFields();
                                self.hideInputFields = true;
                                self.showPaymentOptions = true;
                                self.showPayPalCheckout();
                            } else {
                                swal.fire(
                                    'Oops!',
                                    data.message,
                                    'error'
                                );
                            }
                        });
                    } else {
                        this.setErrorBuyerEmpty();
                        this.error.buyer.email = 'Please enter a valid email address';
                        this.error.buyer.show = true;
                    }
                }
            },
            /*-------------------------------------------------------------*/
            createOrder(callback) {
                let send_data = {
                    event: this.event,
                    ticket_details: this.ticketDetails,
                    total_price: this.total,
                    buyer: this.buyer,
                    ticket_holder: this.ticketHolder,
                    coupon: this.coupon,
                    status: 'pending',
                    payer: '',
                };
                axios.post(apiurl + 'create-order', send_data, header).then(function (response) {
                    let data = response.data;
                    // return (data.code === 1);
                    callback(data);
                });
            },
            /*-------------------------------------------------------------*/
            showPayPalCheckout() {
                /*console.log(this.order);*/
                let self = this;
                let total = this.order.total_amount;
                this.$nextTick(function () {
                    // Render the PayPal button into #paypal-button-container
                    paypal.Buttons({
                        style: {
                            shape: 'pill',
                            label: 'pay',
                        },
                        // Set up the transaction
                        createOrder: function (data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: total
                                    }
                                }]
                            });
                        },

                        // Finalize the transaction
                        onApprove: function (data, actions) {
                            $("#paypal-button-container").hide();
                            return actions.order.capture().then(function (details) {
                                // Show a success message to the buyer
                                /*alert('Transaction completed by ' + details.payer.name.given_name + '!');*/
                                let send_data = {
                                    order_id: self.order.id,
                                    status: details.status,
                                    payer_first_name: details.payer.name.given_name,
                                    payer_last_name: details.payer.name.surname,
                                    payer_email: details.payer.email_address,
                                    payer_id: details.payer.payer_id,
                                    payed_with: 'paypal'
                                };
                                axios.post(apiurl + 'update-order', send_data, header).then(function (response) {
                                    let data = response.data;
                                    if (data.code === 1) {
                                        swal.fire({
                                            title: 'success',
                                            text: 'Payment Successful!',
                                            type: 'success',
                                            allowOutsideClick: false
                                        }).then(function (value) {
                                            if (value) {
                                                window.location = weburl;
                                            }
                                        });
                                        localStorage.removeItem('ticket_details');
                                        localStorage.removeItem('event_details');
                                    } else {
                                        swal.fire('Oops!', data.message + ' Please Contact Support', 'error');
                                    }
                                });
                            });
                        },
                        /*onCancel: function(data, actions){
                            console.log('data');
                            console.warn(data);
                            console.log('actions');
                            console.warn(actions);

                            /!*let send_data = {
                                order_id: self.order.id,
                                status: 'CANCELED',
                            };
                            axios.post(apiurl + 'update-order', send_data, header).then(function (response) {
                                let data = response.data;
                                if (data.code === 1) {
                                    swal.fire({
                                        title: 'success',
                                        text: 'Payment Successful!',
                                        type: 'success',
                                        allowOutsideClick: false
                                    }).then(function(value){
                                        if(value){
                                            window.location = weburl;
                                        }
                                    });
                                    localStorage.removeItem('ticket_details');
                                    localStorage.removeItem('event_details');
                                } else {
                                    swal.fire('Oops!', data.message  + ' Please Contact Support', 'error');
                                }
                            });*!/
                        }*/
                    }).render('#paypal-button-container');
                });
            },
            /*-------------------------------------------------------------*/
            updateCheckout(ticketDetails) {
                let self = this;
                let checkoutDetails = [];
                let j = 0;
                for (let i = 0; i < ticketDetails.length; i++) {
                    if (ticketDetails[i].selected > 0 && ticketDetails[i].quantity > 0) {
                        checkoutDetails[j] = ticketDetails[i];
                        for (let k = 0; k < ticketDetails[i].selected - 1; k++) {
                            checkoutDetails[j].attendees[k] = {
                                first_name: '',
                                last_name: '',
                                email: '',
                            };
                        }
                        j++;
                    }
                }
                if (checkoutDetails.length < 1) {
                    swal.fire('Oops!', 'Please select minimum one ticket.', 'warning');
                } else {
                    localStorage.setItem('ticket_details', JSON.stringify(checkoutDetails));
                    localStorage.setItem('event_details', JSON.stringify(this.event));
                    //setting timer for cart page
                    /*let countDownDate = new Date().getTime() + (5 * 60000);
                    localStorage.setItem('count_down_date', countDownDate);*/
                    localStorage.setItem('came_from_single', 1);
                    window.location = weburl + 'checkout';
                }
            },
            /*-------------------------------------------------------------*/
            loadCheckoutData() {
                this.total = 0;
                for (let i = 0; i < this.ticketDetails.length; i++) {
                    if (this.ticketDetails[i].selected > 0) {
                        this.checkout = true;
                    }
                    this.total = this.total + (parseInt(this.ticketDetails[i].price)
                        * parseInt(this.ticketDetails[i].selected));
                }
                //set minimum paid price
                // There's no real number bigger than plus Infinity
                let lowest = Number.POSITIVE_INFINITY;
                let highest = Number.NEGATIVE_INFINITY;
                let tmp;
                for (let i = this.event.r_e_l_event_ticket.length - 1; i >= 0; i--) {
                    if (this.event.r_e_l_event_ticket[i].quantity > 0) {
                        if (this.event.r_e_l_event_ticket[i].price >= 0) {
                            tmp = this.event.r_e_l_event_ticket[i].price;
                            if (tmp < lowest) lowest = tmp;
                            if (tmp > highest) highest = tmp;
                        }
                    }
                }
                this.allTicketDetails = this.event.r_e_l_event_ticket.map(function (value, index) {
                    value.selected = 0;
                    value.attendees = [];
                    return value;
                });
                if (lowest !== Infinity) {
                    this.minPrice = lowest;
                } else {
                    this.minPrice = 0;
                }
                if (highest !== Infinity) {
                    this.maxPrice = highest;
                } else {
                    this.maxPrice = 0;
                }
            },
            /*-------------------------------------------------------------*/
            buyFreeTickets() {
                if (this.validateForm()) {
                    if (this.validEmail(this.buyer.email)) {
                        this.error.buyer.show = false;
                        this.bookNow = false;
                        let send_data = {
                            event: this.event,
                            ticket_details: this.ticketDetails,
                            total_price: this.total,
                            buyer: this.buyer,
                            ticket_holder: this.ticketHolder,
                            coupon: this.coupon,
                            status: 'completed',
                            payer: '',
                        };
                        axios.post(apiurl + 'create-order', send_data, header).then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                localStorage.removeItem('ticket_details');
                                localStorage.removeItem('event_details');
                                swal.fire({
                                    title: 'success',
                                    text: 'Order Placed Successfully!',
                                    type: 'success',
                                    allowOutsideClick: false
                                }).then(function (value) {
                                    if (value) {
                                        window.location = weburl;
                                    }
                                });
                            } else {
                                swal.fire('Oops!', data.message + ' Please Contact Support', 'error');
                            }
                        });
                    } else {
                        this.setErrorBuyerEmpty();
                        this.error.buyer.email = 'Please Enter a valid email address.';
                        this.error.buyer.show = true;
                    }
                }
            },
            /*-------------------------------------------------------------*/
            validateForm() {
                if (!this.buyer.first_name || !this.buyer.last_name
                    || !this.buyer.email || !this.buyer.confirm_email
                    || !this.buyer.billing_address || !this.buyer.billing_country
                    || !this.buyer.billing_city || !this.buyer.billing_state
                    || !this.buyer.billing_zip || !this.isAgreeToTerms
                    || (this.buyer.email !== this.buyer.confirm_email)
                    || (this.total > 0 && !this.buyer.phone)
                ) {
                    if (!this.buyer.first_name) {
                        this.error.buyer.first_name = 'First Name cannot be empty';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.first_name = '';
                    }
                    if (!this.buyer.last_name) {
                        this.error.buyer.last_name = 'Last Name cannot be empty';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.last_name = '';
                    }
                    if (!this.buyer.email) {
                        this.error.buyer.email = 'Email cannot be empty';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.email = '';
                    }
                    /*if (!this.buyer.phone) {
                        this.error.buyer.phone = 'Last Name cannot be empty';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.phone = '';
                    }*/
                    if (!this.buyer.billing_address) {
                        this.error.buyer.billing_address = 'Address cannot be empty';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.billing_address = '';
                    }
                    if (!this.buyer.billing_country) {
                        this.error.buyer.billing_country = 'Please Select a Country';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.billing_country = '';
                    }
                    if (!this.buyer.billing_city) {
                        this.error.buyer.billing_city = 'City cannot be empty';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.billing_city = '';
                    }
                    if (!this.buyer.billing_state) {
                        this.error.buyer.billing_state = 'State cannot be empty';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.billing_state = '';
                    }
                    if (!this.buyer.billing_zip) {
                        this.error.buyer.billing_zip = 'Zip Code cannot be empty';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.billing_zip = '';
                    }
                    if (!this.isAgreeToTerms) {
                        this.error.buyer.isAgreeToTerms = 'Please Agree to terms of service.';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.isAgreeToTerms = '';
                    }
                    if (this.buyer.email !== !this.buyer.confirm_email) {
                        this.error.buyer.confirm_email = 'Confirm email address does not match with email';
                        this.error.buyer.show = true;
                    }
                    if (this.total > 0 && !this.buyer.phone) {
                        this.error.buyer.phone = 'Phone number cannot be blank';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.phone = '';
                    }
                    return false;
                } else if (this.total > 0 && !this.buyer.phone) {
                    if (!this.buyer.phone) {
                        this.error.buyer.phone = 'Phone number cannot be blank';
                        this.error.buyer.show = true;
                    } else {
                        this.error.buyer.phone = '';
                    }
                    return false;
                } else {
                    return true;
                }
            },
            /*-------------------------------------------------------------*/
            // validating email address
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            /*-------------------------------------------------------------*/
            disableInputFields() {
                this.savedInDB = 1;
            },
            /*-------------------------------------------------------------*/
            setErrorBuyerEmpty() {
                this.error.buyer.first_name = '';
                this.error.buyer.last_name = '';
                this.error.buyer.phone = '';
                this.error.buyer.billing_address = '';
                this.error.buyer.billing_country = '';
                this.error.buyer.billing_city = '';
                this.error.buyer.billing_state = '';
                this.error.buyer.billing_zip = '';
                this.error.buyer.billing_address_2 = '';
                this.error.buyer.billing_landmark = '';
                this.error.buyer.message = '';
                this.error.buyer.isAgreeToTerms = '';
            },
            /*-------------------------------------------------------------*/
            startTimer(countDownDate) {
                // 5 mint timer after that values reset.
                // Set the date we're counting down to
                // Update the count down every 1 second
                let x = setInterval(function () {
                    // Get today's date and time
                    let now = new Date().getTime();
                    // Find the distance between now and the count down date
                    let distance = countDownDate - now;
                    localStorage.setItem('count_down_date', countDownDate);
                    // Time calculations for days, hours, minutes and seconds
                    /*var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));*/
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    // Output the result in an element with id="demo"
                    document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";
                    // If the count down is over, write some text
                    /*console.log(distance);*/
                    if (minutes === 1 && seconds === 30) {
                        /*console.log(minutes);
                        console.log(seconds);
                        console.log('distance = ' + distance);*/
                        return false;
                    }
                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = "EXPIRED";
                        alert('Time up for checkout please try again.');
                        window.location = basehomeurl;
                        localStorage.removeItem('ticket_details');
                        localStorage.removeItem('event_details');
                        localStorage.removeItem('count_down_date');
                    }
                    if (distance < 90707 && distance >= 0) {
                        document.getElementById("demo").style.color = "RED";
                    }
                }, 1000);
            },
            /*-------------------------------------------------------------*/
            getStates() {
                let self = this;
                axios.post(apiurl + 'get-states', {id: this.buyer.billing_country}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.states = data.payload
                    }
                });
            },
            /*-------------------------------------------------------------*/
            getMyInfo() {
                let self = this;
                axios.post(apiurl + 'me', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.user = data.payload;
                        self.setBuyerInfo(self.user);
                    }
                });
            },
            /*-------------------------------------------------------------*/
            setBuyerInfo(user) {
                this.buyer.first_name = user.first_name;
                this.buyer.last_name = user.last_name;
                this.buyer.email = user.email;
            }
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
        },
        created() {
            this.ticketDetails = JSON.parse(localStorage.getItem('ticket_details'));
            this.event = JSON.parse(localStorage.getItem('event_details'));
            if (this.ticketDetails === null) {
                window.location = weburl;
            }
            this.loadCheckoutData();
            let countDownDate = localStorage.getItem('count_down_date');
            this.startTimer(countDownDate);
            this.getMyInfo();
        },
    });
}
/*-------------------------------------------------------------*/
if ($("#search-event").length === 1) {
    new Vue({
        el: '#search-event',
        data: {
            keyword: '',
            searchLocation: '',
            searchStartDate: '',
            events: {},
            eventImgUrl: event_image_url,
            imgUrl: imgurl,
            minPrice: 0,
            selectCategory: '',
            categories: {},
        },
        watch: {
            keyword: function (value) {
                localStorage.setItem('search_event', value);
                this.searchEvents();
            },
            /*-------------------------------------------------------------*/
            searchLocation: function (value) {
                this.searchEvents();
            },
            /*-------------------------------------------------------------*/
            searchStartDate: function (value) {
                this.searchEvents();
            },
            /*-------------------------------------------------------------*/
            sortBy: function (value) {
                this.searchEvents();
            },
            /*-------------------------------------------------------------*/
            selectCategory: function (value) {
                localStorage.setItem('category_id', value);
                /*console.log(value);*/
                this.searchEvents();
            }
        },
        methods: {
            /*-------------------------------------------------------------*/
            searchEvents(page) {
                if (typeof page === 'undefined' || page === '') {
                    page = 1;
                }
                let self = this;
                let search_url = 'q=' + this.keyword + '&location=' + this.searchLocation + '&start_date=' + this.searchStartDate + '&category=' + this.selectCategory;
                axios.get(apiurl + 'search-event?' + search_url + '&page=' + page).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;
                        //set minimum paid price
                        // There's no real number bigger than plus Infinity
                        for (var p = 0; p < self.events.data.length; p++) {
                            self.events.data[p].totalQuantity = 0;
                            self.events.data[p].isSoldOut = '';
                            let lowest = Number.POSITIVE_INFINITY;
                            let highest = Number.NEGATIVE_INFINITY;
                            let tmp;
                            for (var i = self.events.data[p].r_e_l_event_ticket.length - 1; i >= 0; i--) {
                                self.events.data[p].totalQuantity = self.events.data[p].totalQuantity
                                    + self.events.data[p].r_e_l_event_ticket[i].quantity;
                                if (self.events.data[p].r_e_l_event_ticket[i].quantity > 0) {
                                    if (self.events.data[p].r_e_l_event_ticket[i].price > 0) {
                                        tmp = self.events.data[p].r_e_l_event_ticket[i].price;
                                        if (tmp < lowest) lowest = tmp;
                                        if (tmp > highest) highest = tmp;
                                    }
                                }
                            }
                            if (lowest !== Infinity) {
                                self.events.data[p].minPrice = lowest;
                                self.events.data[p].maxPrice = highest;
                            } else {
                                self.events.data[p].minPrice = 0;
                            }
                            if (self.events.data[p].totalQuantity <= 0) {
                                self.events.data[p].isSoldOut = 'sold-out';
                            }
                        }
                    } else {
                        self.events = data.payload;
                        self.events.message = data.message;
                        self.events.from = 0;
                        self.events.to = 0;
                        self.events.total = 0;
                    }
                });
            },
            /*-------------------------------------------------------------*/
            getCategories() {
                let self = this;
                axios.post(apiurl + 'all-category-list').then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.categories = data.payload;
                        /*console.log(self.categories);*/
                    } else {
                        self.categories = data.message;
                    }
                });
            },
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
        },
        /*-------------------------------------------------------------*/
        created() {
            this.keyword = localStorage.getItem('search_event');
            if (localStorage.getItem('category_id') && localStorage.getItem('category_id') !== 'undefined') {
                this.selectCategory = localStorage.getItem('category_id');
            }
            this.searchEvents();
            this.getCategories();
        },
        /*-------------------------------------------------------------*/
        beforeUpdate() {
            let self = this;
            $("#search_event_date").datetimepicker({
                format: 'L',
                icons: {
                    left: "fa fa-arrow-up",
                    right: "fa fa-arrow-down"
                },
                useCurrent: false
            });
            $("#search_event_date").data("DateTimePicker").minDate(new Date());
            $("#search_event_date").on("dp.change", function (e) {
                let event_date = $("#search_event_date").val();
                if (event_date !== '') {
                    self.searchStartDate = moment(event_date, 'MM/D/YYYY').format('YYYY-MM-D');
                }
                self.searchStartDate = event_date;
            });
        }
    });
}
/*-------------------------------------------------------------*/
if ($("#user-profile").length === 1) {
    new Vue({
        el: '#user-profile',
        data: {
            imagePath: imageurl,
            profile: true,
            editProfile: false,
            my: {},
            events: {},
            error: {
                my: {
                    old_password: '',
                    new_password: '',
                    new_password_confirmation: '',
                    show: false,
                },
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
                axios.post(apiurl + 'me', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.my = data.payload;
                    } else {
                        self.error.message = data.message;
                        self.error.show = true;
                    }
                });
            },

            /*------------------------------------------------------*/
            saveProfileDetails() {
                let self = this;
                axios.post(userurl + 'update-profile', this.my, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        /*self.success.message = data.message;
                        self.success.show = true;*/
                        swal.fire('success', data.message, 'success');
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
                axios.post(userurl + 'update-social-media', socialData, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        /*self.success.message = data.message;
                        self.success.show = true;*/
                        self.error.show = false;
                        swal.fire('success', data.message, 'success');
                    } else {
                        self.error.message = data.message;
                        self.error.show = true;
                    }
                    window.scrollTo(0, 0);
                });
            },
            /*------------------------------------------------------*/
            updatePassword() {
                let self = this;
                if (this.validatePassword()) {
                    let sendData = {
                        old_password: this.my.old_password,
                        new_password: this.my.new_password,
                        new_password_confirmation: this.my.new_password_confirmation,
                    };
                    axios.post(apiurl + 'user/update-password', sendData, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            self.error.my.show = false;
                            self.my.old_password = '';
                            self.my.new_password = '';
                            self.my.new_password_confirmation = '';
                            Swal.fire('success', data.message, 'success');
                        } else {
                            self.error.my.new_password = '';
                            self.error.my.new_password_confirmation = '';
                            self.error.my.old_password = data.message;
                            self.error.show = true;
                        }
                    });
                }
            },
            /*------------------------------------------------------*/
            validatePassword() {
                if (!this.my.old_password || !this.my.new_password
                    || !this.my.new_password_confirmation
                ) {
                    if (!this.my.old_password) {
                        this.error.my.old_password = 'Old password cannot be empty.';
                        this.error.my.show = true;
                    } else {
                        this.error.my.old_password = '';
                    }
                    if (!this.my.new_password) {
                        this.error.my.new_password = 'New password cannot be empty.';
                        this.error.my.show = true;
                    } else {
                        this.error.my.new_password = '';
                    }
                    if (!this.my.new_password_confirmation) {
                        this.error.my.new_password_confirmation = 'Repeat new password cannot be empty.';
                        this.error.my.show = true;
                    } else {
                        this.error.my.new_password_confirmation = '';
                    }
                    return false;
                } else if (this.my.new_password !== this.my.new_password_confirmation) {
                    this.error.my.new_password_confirmation = 'Repeat Password must be same as new password';
                    this.error.my.show = true;
                    return false;
                } else {
                    this.error.my.show;
                    return true;
                }
            }
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
        },
        created() {
            this.getMyProfile();
        }
    });
}
/*-------------------------------------------------------------*/
if ($("#my-orders").length > 0) {
    new Vue({
        el: '#my-orders',
        data: {
            show_order: {},
            upcoming: {},
            pastEvents: {},
            showUpcoming: true,
        },
        methods: {
            /*-------------------------------------------------------------*/
            /* get the upcoming events bought by the user  */
            getUpcomingEvents(page) {
                if (typeof page == 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.post(userurl + 'upcoming-event-orders', {page: page}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.upcoming = data.payload;
                        for (let i = 0; i < self.upcoming.data.length; i++) {
                            let sum = 0;
                            for (let j = 0; j < self.upcoming.data[i].order_tickets.length; j++) {
                                sum = sum + self.upcoming.data[i].order_tickets[j].quantity;
                                self.upcoming.data[i].total_quantity = sum;
                            }
                        }
                    }
                });
            },
            /* get the past events bought by the user  */
            getPastEvents(page) {
                if (typeof page == 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.post(userurl + 'past-event-orders', {page: page}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.pastEvents = data.payload;
                        for (let i = 0; i < self.pastEvents.data.length; i++) {
                            let sum = 0;
                            for (let j = 0; j < self.pastEvents.data[i].order_tickets.length; j++) {
                                sum = sum + self.pastEvents.data[i].order_tickets[j].quantity;
                                self.pastEvents.data[i].total_quantity = sum;
                            }
                        }
                    }
                });
            },
            /*-------------------------------------------------------------*/
            showOrderTicket(order) {
                this.show_order = order;
            }
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
        },
        created() {
            this.getUpcomingEvents();
            this.getPastEvents();
        }
    });
}
/*-------------------------------------------------------------*/
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
                axios.post(apiurl + 'user/following', sendData, header).then(function (response) {
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
                        axios.post(apiurl + 'user/unfollow-organizer', sendData, header).then(function (response) {
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
/*-------------------------------------------------------------*/
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
                /*console.log(e.target.files[0]);*/
                this.createTicket.image_one = e.target.files[0];
            },
            /*------------------------------------------------------*/
            getMySupportTickets(page) {
                let self = this;
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.post(apiurl + 'user/help-tickets-all', {page: page}, header).then(function (response) {
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
                    axios.post(apiurl + 'user/update-help-ticket-message', sendData, header).then(function (response) {
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
                    axios.post(apiurl + 'user/create-help-ticket', formData, header).then(function (response) {
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
                axios.post(apiurl + 'organizer-list', {}).then(function (response) {
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
                axios.post(apiurl + 'help-categories', {}).then(function (response) {
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
/*-------------------------------------------------------------*/
if ($("#add-card").length > 0) {
    new Vue({
        el: '#add-card',
        data: {
            card: {
                name_on_card: '',
                card_number: '',
                expiration_date: '',
                cvv: '',
                country: '',
                address: '',
                city: '',
                state: '',
                postal_code: '',
                phone_number: '',
                agree: false,
            },
            cards: {},

            showAddCard: false,
            showEditCard: false,
            error: {
                card: {
                    name_on_card: '',
                    card_number: '',
                    expiration_date: '',
                    cvv: '',
                    country: '',
                    address: '',
                    city: '',
                    state: '',
                    postal_code: '',
                    phone_number: '',
                    agree: '',
                    show: false,
                },
                message: '',
                show: false,
            }
        },
        methods: {
            /*-------------------------------------------------------------*/
            getCards(page) {
                if (typeof page == 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.post(apiurl + 'user/card-list', {page: page}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.cards = data.payload;
                    } else {
                        self.cards = {}
                    }
                });
            },
            /*-------------------------------------------------------------*/
            cancelAddCard() {
                this.showAddCard = false;
            },
            /*-------------------------------------------------------------*/
            enableAddCard() {
                this.showAddCard = true;
                this.showEditCard = false;
            },
            /*-------------------------------------------------------------*/
            cancelEditCard() {
                this.showEditCard = false;
                this.card = {
                    name_on_card: '',
                    card_number: '',
                    expiration_date: '',
                    cvv: '',
                    country: '',
                    address: '',
                    city: '',
                    state: '',
                    postal_code: '',
                    phone_number: '',
                    agree: false,
                };
            },
            /*-------------------------------------------------------------*/
            enableEditCard(card) {
                this.showAddCard = false;
                this.showEditCard = true;
                this.card = card;
                this.card.name_on_card = card.name;
            },
            /*-------------------------------------------------------------*/
            addCard() {
                if (this.validateForm()) {
                    this.error.card.show = false;
                    let self = this;
                    axios.post(apiurl + 'user/add-card', this.card, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            self.card = {
                                name_on_card: '',
                                card_number: '',
                                expiration_date: '',
                                cvv: '',
                                country: '',
                                address: '',
                                city: '',
                                state: '',
                                postal_code: '',
                                phone_number: '',
                                agree: false,
                            };
                            self.getCards();
                            self.cancelAddCard();
                            swal.fire({
                                'title': 'Success',
                                'text': data.message,
                                'type': 'success'
                            });
                        } else {
                            swal.fire({
                                'title': 'Oops!',
                                'text': data.message,
                                'type': 'error'
                            });
                        }
                    });
                }
            },
            /*-------------------------------------------------------------*/
            updateCard() {
                this.error.card.show = false;
                let self = this;
                if (this.validateFormOnUpdate()) {
                    axios.post(apiurl + 'user/update-card', this.card, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            self.card = {
                                name_on_card: '',
                                card_number: '',
                                expiration_date: '',
                                cvv: '',
                                country: '',
                                address: '',
                                city: '',
                                state: '',
                                postal_code: '',
                                phone_number: '',
                                agree: false,
                            };
                            self.getCards();
                            self.cancelEditCard();
                            swal.fire({
                                'title': 'Success',
                                'text': data.message,
                                'type': 'success'
                            });
                        } else {
                            swal.fire({
                                'title': 'Oops!',
                                'text': data.message,
                                'type': 'error'
                            });
                        }
                    });
                } else {
                    /*console.log('validation failed');*/
                }
            },
            /*-------------------------------------------------------------*/
            isNumber(evt) {
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },
            /*-------------------------------------------------------------*/
            validateForm() {
                if (!this.card.name_on_card || !this.card.expiration_date
                    || !this.card.cvv || !this.card.country
                    || !this.card.address || !this.card.city
                    || !this.card.state || !this.card.postal_code
                    || !this.card.phone_number || !this.card.agree
                    || !this.card.card_number
                ) {
                    if (!this.card.name_on_card) {
                        this.error.card.name_on_card = 'Please enter you first name and last name.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.name_on_card = '';
                    }

                    if (!this.card.expiration_date) {
                        this.error.card.expiration_date = 'Please select expiration date.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.expiration_date = '';
                    }

                    if (!this.card.cvv) {
                        this.error.card.cvv = 'Please enter cvv.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.cvv = '';
                    }

                    if (!this.card.country) {
                        this.error.card.country = 'Please select country.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.country = '';
                    }

                    if (!this.card.address) {
                        this.error.card.address = 'Please enter address.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.address = '';
                    }

                    if (!this.card.city) {
                        this.error.card.city = 'Please enter city.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.city = '';
                    }

                    if (!this.card.state) {
                        this.error.card.state = 'Please enter state .';
                        this.error.card.show = true;
                    } else {
                        this.error.card.state = '';
                    }

                    if (!this.card.postal_code) {
                        this.error.card.postal_code = 'Please enter postal code.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.postal_code = '';
                    }

                    if (!this.card.phone_number) {
                        this.error.card.phone_number = 'Please enter phone number.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.phone_number = '';
                    }

                    if (!this.card.agree) {
                        this.error.card.agree = 'Please agree to our terms and conditions.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.agree = '';
                    }

                    if (!this.card.card_number) {
                        this.error.card.card_number = 'Please enter your card number.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.card_number = '';
                    }

                    return false;
                } else {
                    return true;
                }
            },
            /*-------------------------------------------------------------*/
            validateFormOnUpdate() {
                if (!this.card.name_on_card || !this.card.expiration_date
                    || !this.card.cvv || !this.card.country
                    || !this.card.address || !this.card.city
                    || !this.card.state || !this.card.postal_code
                    || !this.card.phone_number || !this.card.card_number
                ) {
                    if (!this.card.name_on_card) {
                        this.error.card.name_on_card = 'Please enter you first name and last name.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.name_on_card = '';
                    }
                    if (!this.card.expiration_date) {
                        this.error.card.expiration_date = 'Please select expiration date.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.expiration_date = '';
                    }
                    if (!this.card.cvv) {
                        this.error.card.cvv = 'Please enter cvv.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.cvv = '';
                    }
                    if (!this.card.country) {
                        this.error.card.country = 'Please select country.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.country = '';
                    }
                    if (!this.card.address) {
                        this.error.card.address = 'Please enter address.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.address = '';
                    }
                    if (!this.card.city) {
                        this.error.card.city = 'Please enter city.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.city = '';
                    }
                    if (!this.card.state) {
                        this.error.card.state = 'Please enter state .';
                        this.error.card.show = true;
                    } else {
                        this.error.card.state = '';
                    }
                    if (!this.card.postal_code) {
                        this.error.card.postal_code = 'Please enter postal code.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.postal_code = '';
                    }
                    if (!this.card.phone_number) {
                        this.error.card.phone_number = 'Please enter phone number.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.phone_number = '';
                    }
                    if (!this.card.card_number) {
                        this.error.card.card_number = 'Please enter your card number.';
                        this.error.card.show = true;
                    } else {
                        this.error.card.card_number = '';
                    }

                    return false;
                } else {
                    return true;
                }
            },
            /*-------------------------------------------------------------*/
            deleteCard(id) {
                let self = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this card!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.post(apiurl + 'user/delete-card', {id: id}, header).then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                self.getCards();
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                )
                            } else {
                                Swal.fire('Oops!', data.message, 'error');
                            }
                        });
                    }
                });
            }
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
            /*-------------------------------------------------------------*/
        },
        created() {
            this.getCards();
        },
        updated() {
            let self = this;
            $("#expiration-date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'mm/yy',
                showButtonPanel: true,
                onClose: function (dateText, inst) {
                    self.card.expiration_date = (inst.selectedMonth + 1) + '/' + inst.selectedYear;
                },
                minDate: 0
            });
        }
    });
}
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/
/*-------------------------------------------------------------*/

// javascript function for creating cookie
function createCookie(key, value) {
    let cookie = escape(key) + "=" + escape(value) + ";";
    document.cookie = cookie;
}

/* get cookies */
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
}