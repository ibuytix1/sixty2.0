loadProgressBar();
$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
var token = getCookie('token');
var header = {
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + token
    }
};
/* -------------------------------------------------------*/
Vue.component('vue-multiselect', window.VueMultiselect.default);
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
// vue multi select for tags
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
/* -------------------------------------------------------*/
/*------------------------------------------------------*/
if ($("#org-profile").length > 0) {
    new Vue({
        el: '#org-profile',
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
                    } else {
                        self.error.message = data.message;
                        self.error.show = true;
                    }
                });
            },
            /*------------------------------------------------------*/
            getMyEvents(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'my-events?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;
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
            this.getMyEvents();
        }
    });
}
/*------------------------------------------------------*/
/* edit coupon and coupon list and delete coupon*/
if ($("#coupon-list").length > 0) {
    var couponList = new Vue({
        el: '#coupon-list',
        data: {
            search: false,
            keywords: null,
            edit: false,
            coupon: {},
            coupons: {},
            events: {},
            errors: {
                events: {
                    message: '',
                    show: '',
                },
                coupon_code: '',
                description: '',
                start_date: '',
                end_date: '',
                total_available: '',
                redeem_on: '',
                amount: '',
                type: '',
                start_time: '',
                end_time: '',
                message: {dev: '', text: '', show: false},
                show: false
            },
            error: {
                message: [],
                show: false
            },
            success: {
                message: '',
                show: false
            }
        },
        watch: {
            keywords: function (value) {
                this.searchCoupons();
            }
        },
        methods: {
            /* search coupons */
            searchCoupons: function (page) {
                if (this.keywords === '' || this.keywords === null) {
                    this.search = false;
                    this.getCoupons();
                } else {
                    if (typeof page === 'undefined') {
                        page = 1;
                    }
                    let self = this;
                    let searchurl = apiurl + 'search-coupon?key=' + this.keywords + '&page=' + page;
                    axios.get(searchurl, header).then(function (response) {
                        if (response.data.code === 1)
                            self.coupons = response.data.payload;
                        else
                            self.coupons = response.data;
                    });
                }
            },
            /*----------------------------------------------------------------------*/
            /*----------------------------------------------------------------------*/

            getCoupons: function (page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'coupon-list?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.coupons = data.payload;
                    } else {
                        self.coupons = data;
                    }
                });
            },
            /* edit coupon */
            editCoupon(coupon) {
                this.edit = true;
                this.coupon = coupon;
            },
            /* cancel coupon edit */
            cancelEdit() {
                this.edit = false;
                this.coupon = {};
            },
            /*----------------------------------------------------------------------*/

            /* update coupon in backend */
            updateCoupon() {
                let self = this;
                if (this.validateCoupon()) {
                    axios.post(apiurl + 'update-coupon', this.coupon, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            swal.fire(
                                {
                                    title: 'Success',
                                    text: data.message,
                                    type: 'success'
                                }).then(function () {
                                self.cancelEdit();
                            });
                            window.scrollTo(0, 0);
                        } else {
                            self.error.message = data.message;
                            self.error.show = true;
                        }
                    });
                }
            },
            /*----------------------------------------------------------------------*/

            /* getting events to display in the select box */
            getEvents() {
                let self = this;
                axios.post(apiurl + 'event-list-for-coupon', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;

                    } else {
                        self.errors.events.message = 'Please create an event first before creating a coupon';
                        self.errors.events.show = true;
                    }
                });
            },
            /*----------------------------------------------------------------------*/

            deleteCoupon(coupon) {
                let self = this;
                swal.fire({
                    title: 'Are you sure you want to delete this item?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.post(apiurl + 'delete-coupon', {id: coupon.id}, header).then(function (response) {
                            let data = response.data;
                            if (response.data.code === 1) {
                                swal.fire({
                                    title: 'Success',
                                    text: data.message,
                                    type: 'success'
                                });
                                self.coupons = data.payload;
                            } else {
                                swal.fire({
                                    title: 'Oops!',
                                    text: data.message,
                                    type: 'error'
                                })
                            }
                        });
                    }
                });

            },
            /*----------------------------------------------------------------------*/
            viewCoupon(coupon) {
                this.coupon = coupon;
            },
            /*----------------------------------------------------------------------*/
            /*----------------------------------------------------------------------*/
            /*----------------------------------------------------------------------*/
            /*----------------------------------------------------------------------*/
            validateCoupon() {
                if (!this.coupon.coupon || !this.coupon.start_date
                    || !this.coupon.end_date || !this.coupon.redeem_on
                    || !this.coupon.amount || !this.coupon.type
                    || !this.coupon.start_time || !this.coupon.end_time
                ) {
                    if (!this.coupon.coupon) {
                        this.errors.coupon_code = 'Coupon/Discount name cannot be empty';
                        this.errors.show = true;
                    } else {
                        this.errors.description = '';
                    }

                    if (!this.coupon.start_date) {
                        this.errors.start_date = 'Start Date cannot be empty';
                        this.errors.show = true;
                    } else {
                        this.errors.start_date = '';
                    }

                    if (!this.coupon.end_date) {
                        this.errors.end_date = 'End Date cannot be empty';
                        this.errors.show = true;
                    } else {
                        this.errors.end_date = '';
                    }

                    if (!this.coupon.redeem_on) {
                        this.errors.redeem_on = 'Redeem on cannot be empty';
                        this.errors.show = true;
                    } else {
                        this.errors.redeem_on = '';
                    }

                    if (!this.coupon.type) {
                        this.errors.type = 'Coupon Type cannot be empty';
                        this.errors.show = true;
                    } else {
                        this.errors.type = '';
                    }

                    if (!this.coupon.start_time) {
                        this.errors.start_time = 'Start Time cannot be empty';
                        this.errors.show = true;
                    } else {
                        this.errors.start_time = '';
                    }

                    if (!this.coupon.end_time) {
                        this.errors.end_time = 'End Time cannot be empty';
                        this.errors.show = true;
                    } else {
                        this.errors.end_time = '';
                    }

                    if (!this.coupon.amount) {
                        this.errors.amount = 'Coupon Amount cannot be empty';
                        this.errors.show = true;
                    } else {
                        return this.errors.amount = '';
                    }
                    window.scrollTo(0, 0);
                    return false;
                } else if (this.coupon.type === '%' && this.coupon.amount > 100) {
                    this.errors.amount = 'Please enter valid percent discount for coupon';
                    this.errors.show = true;
                    return false;
                } else {
                    return true;
                }
            }
            /*----------------------------------------------------------------------*/
            /*----------------------------------------------------------------------*/
            /*----------------------------------------------------------------------*/
        },
        /*----------------------------------------------------------------------*/
        updated() {
            let self = this;
            $("#start_date_update").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    self.coupon.start_date = selected;
                    let dt = new Date(selected);
                    dt.setDate(dt.getDate() + 1);
                    $("#end_date_update").datepicker("option", "minDate", dt);
                    self.error.end_date = '';
                },
                minDate: 0
            });
            $("#end_date_update").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    if (self.coupon.start_date === '') {
                        self.coupon.end_date = '';
                        $("#end_date_update").val('');
                        self.error.end_date = 'Please select start date first';
                        self.error.show = true;
                    } else {
                        let dt = new Date(selected);
                        self.coupon.end_date = selected;
                        dt.setDate(dt.getDate() - 1);
                        $("#start_date_update").datepicker("option", "maxDate", dt);
                    }
                }
            });
            $("#start_time_update").timepicker({
                timeFormat: 'HH:mm',
                interval: 15,
                zindex: 999999999,
                change: function (time) {
                    // the input field
                    var element = $(this), text;
                    // get access to this Timepicker instance
                    var timepicker = element.timepicker();
                    text = 'Selected time is: ' + timepicker.format(time);
                    self.coupon.start_time = timepicker.format(time);
                },
            });
            $("#end_time_update").timepicker({
                timeFormat: 'HH:mm',
                interval: 15,
                zindex: 999999999,
                change: function (time) {
                    // the input field
                    var element = $(this), text;
                    // get access to this Timepicker instance
                    var timepicker = element.timepicker();
                    text = 'Selected time is: ' + timepicker.format(time);
                    self.coupon.end_time = timepicker.format(time);
                },
            });
        },
        /*----------------------------------------------------------------------*/
        /*----------------------------------------------------------------------*/
        created() {
            this.getCoupons();
            this.getEvents();
        },
    });
}
/*------------------------------------------------------*/
/* create coupon */
if ($("#create-coupon").length > 0) {
    new Vue({
        el: '#create-coupon',
        data: {
            coupon: {
                coupon_code: '',
                description: '',
                start_date: '',
                start_time: '',
                end_date: '',
                end_time: '',
                total_available: '',
                redeem_on: '',
                amount: 0,
                status: 0,
                type: 'amt',
            },
            events: {},
            error: {
                events: {
                    message: '',
                    show: '',
                },
                coupon_code: '',
                description: '',
                start_date: '',
                end_date: '',
                total_available: '',
                redeem_on: '',
                amount: '',
                type: '',
                start_time: '',
                end_time: '',
                message: {dev: '', text: '', show: false},
                show: false
            },
            success: {
                message: '',
                show: false
            }
        },
        methods: {
            /* create coupon request to api */
            createCoupon() {
                if (this.validateCoupon()) {
                    let self = this;
                    axios.post(apiurl + 'create-coupon', this.coupon, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            self.error.message.show = false;
                            self.error.show = false;
                            /*self.success.message = data.message;
                            self.success.show = true;*/
                            swal.fire({
                                title: 'Success',
                                text: data.message,
                                type: 'success'
                            }).then(function () {
                                /*$('#add_coupon').modal();*/
                                $("#close_add_coupon").click();
                                couponList.getCoupons();
                            });
                            self.coupon = {
                                coupon_code: '',
                                description: '',
                                start_date: '',
                                start_time: '',
                                end_date: '',
                                end_time: '',
                                total_available: '',
                                redeem_on: '',
                                amount: '',
                                status: 0,
                                type: 'amt',
                            };
                            /*window.scrollTo(0, 0);*/
                        } else {
                            self.error.show = false;
                            self.error.message.dev = data.dev_message;
                            self.error.message.text = data.message;
                            self.error.message.show = true;
                            /*window.scrollTo(0, 0);*/
                        }
                    });
                }
            },
            /* getting events to display in the select box */
            getEvents() {
                let self = this;
                axios.post(apiurl + 'event-list-for-coupon', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;

                    } else {
                        self.error.events.message = 'Please create an event first before creating a coupon';
                        self.error.events.show = true;
                    }
                });
            },
            /* validating data client side */
            validateCoupon() {
                if (!this.coupon.coupon_code || !this.coupon.start_date
                    || !this.coupon.end_date || !this.coupon.redeem_on
                    || !this.coupon.amount || !this.coupon.type
                    || !this.coupon.start_time || !this.coupon.end_time
                ) {
                    if (!this.coupon.coupon_code) {
                        this.error.coupon_code = 'Coupon/Discount name cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.coupon_code = '';
                    }

                    if (!this.coupon.start_date) {
                        this.error.start_date = 'Start Date cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.start_date = '';
                    }

                    if (!this.coupon.end_date) {
                        this.error.end_date = 'End Date cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.end_date = '';
                    }

                    if (!this.coupon.redeem_on) {
                        this.error.redeem_on = 'Redeem on cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.redeem_on = '';
                    }

                    if (!this.coupon.type) {
                        this.error.type = 'Coupon Type cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.type = '';
                    }

                    if (!this.coupon.start_time) {
                        this.error.start_time = 'Start Time cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.start_time = '';
                    }

                    if (!this.coupon.end_time) {
                        this.error.end_time = 'End Time cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.end_time = '';
                    }

                    if (!this.coupon.amount || this.coupon.amount <= 0) {
                        this.error.amount = 'Coupon Amount cannot be empty or negative';
                        this.error.show = true;
                    } else {
                        if (this.coupon.type === '%' && this.coupon.amount > 100) {
                            this.error.amount = 'Please enter valid percent discount for coupon';
                            this.error.show = true;
                        } else {
                            this.error.amount = '';
                        }
                    }
                    window.scrollTo(0, 0);
                    return false;
                } else {
                    return true;
                }
            }
        },
        beforeUpdate: function () {
            let self = this;
            $("#start_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    self.coupon.start_date = selected;
                    let dt = new Date(selected);
                    /*dt.setDate(dt.getDate() + 1);*/
                    dt.setDate(dt.getDate());
                    $("#end_date").datepicker("option", "minDate", dt);
                    self.error.end_date = '';
                },
                minDate: 0
            });
            $("#end_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    if (self.coupon.start_date === '') {
                        self.coupon.end_date = '';
                        $("#end_date").val('');
                        self.error.end_date = 'Please select start date first';
                        self.error.show = true;
                    } else {
                        let dt = new Date(selected);
                        self.coupon.end_date = selected;
                        dt.setDate(dt.getDate() - 1);
                        $("#start_date").datepicker("option", "maxDate", dt);
                    }
                }
            });
            $("#start_time").timepicker({
                timeFormat: 'HH:mm',
                interval: 15,
                zindex: 999999999,
                change: function (time) {
                    // the input field
                    var element = $(this), text;
                    // get access to this Timepicker instance
                    var timepicker = element.timepicker();
                    text = 'Selected time is: ' + timepicker.format(time);
                    self.coupon.start_time = timepicker.format(time);
                },
            });
            $("#end_time").timepicker({
                timeFormat: 'HH:mm',
                interval: 15,
                zindex: 999999999,
                change: function (time) {
                    // the input field
                    var element = $(this), text;
                    // get access to this Timepicker instance
                    var timepicker = element.timepicker();
                    text = 'Selected time is: ' + timepicker.format(time);
                    self.coupon.end_time = timepicker.format(time);
                },
            });
        },
        created() {
            this.getEvents();
        }
    });
}
/*------------------------------------------------------*/
/* live event list for organizer dashboard */
if ($("#live-events").length > 0) {
    new Vue({
        el: '#live-events',
        data: {
            event: {},
            edit: false,
            events: {},
            imageUrl: imageurl,
            error: {
                attendee: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    amount: '',
                    ticket_type: '',
                    quantity: '',
                    payment_type: '',
                    show: false
                },
                title: '',
                url: '',
                location: '',
                address: '',
                startDate: '',
                startTime: '',
                endDate: '',
                endTime: '',
                description: '',
                status: '',
                otherInformation: '',
                selectCategory: '',
                occurrence_start_time: '',
                occurrence_end_time: '',
                occurrence_off_the_day: '',
                occurrence_from_date: '',
                occurence_to_date: '',
                message: '',
                show: false
            },
            success: {
                message: '',
                show: false
            },
            categories: {},
            subCategories: {},
            additional_information: [],
            images: [],
            rows: [{}],
            eventInsights: {},
            insight: false,
            attendee: {
                first_name: '',
                last_name: '',
                email: '',
                amount: '',
                ticket_type: '',
                quantity: '',
                payment_type: '',
                event_id: '',
            },
            insights: {
                netRevenue: '',
                tixSold: '',
                eventClicks: '',
                contacts: '',
            },
            autocomplete: {},
            tags: [],
        },
        computed: {
            url: function () {
                this.event.event_url = this.sanitizeTitle(this.event.event_url);
                return basehomeurl;
            },
        },
        methods: {
            /*------------------------------------------------------*/
            disableAmountIfFree(some, index) {
                if (some === '1') {
                    this.event.price[index] = 0;
                    this.event.disableAmount[index] = true;
                } else {
                    this.event.disableAmount[index] = false;
                }
            },
            /*-----------------------------------------------------------------*/
            /* go back to event list from edit event page */
            cancelEdit() {
                this.edit = false;
                this.getLiveEvents();
                this.success.show = false;
                this.event = {};
            },
            /*-----------------------------------------------------------------*/
            /* go back to event list from event insight page */
            cancelInsight() {
                this.insight = false;
                this.success.show = false;
                this.event = {};
            },
            /*-----------------------------------------------------------------*/
            /*-----------------------------------------------------------------*/
            /* show event insight page */
            showInsight(event) {
                this.insight = true;
                this.success.show = false;
                this.error.show = false;
                this.event = event;
                /*Vue.nextTick(function(){
                    $(function(){
                        "use strict";
                        $('.insight-circle').circleProgress({
                            value: 1,
                            size: 130,
                            fill: {
                                color: ["#3F51B5"]
                            }
                        });
                    });

                });*/
                this.getInsightRevenueDetails(event.id);
            },
            /*-----------------------------------------------------------------*/
            /* get list of live events */
            getLiveEvents(page) {
                if (typeof page == 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'live-event-list?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;
                        // console.log(data.payload.data);
                    } else {
                        self.events = {};
                        self.error.message = data.message;
                        self.error.show = true;
                        // console.log(data);
                    }
                });
            },
            /*-----------------------------------------------------------------*/
            /* show edit event section */
            editEvent(event) {
                let self = this;
                this.edit = true;
                this.success.show = false;
                this.error.show = false;
                this.event = event;
                this.getSubCategories();
                this.additional_information = this.event.aditional_information.split(',');
                Vue.nextTick(function () {
                    CKEDITOR.replace('event_description');
                    $("#start_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        onSelect: function (selected) {
                            self.event.start_date = selected;
                            self.event.end_date = selected;
                            let dt = new Date(selected);
                            /*dt.setDate(dt.getDate() + 1);*/
                            dt.setDate(dt.getDate());
                            $("#end_date").datepicker("option", "minDate", dt);
                            self.error.start_date = '';
                        },
                        minDate: 0
                    });
                    $("#end_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        onSelect: function (selected) {
                            if (self.event.start_date === '') {
                                self.event.end_date = '';
                                $("#end_date").val('');
                                self.error.endDate = 'Please select start date first';
                                self.error.show = true;
                            } else {
                                let dt = new Date(selected);
                                self.event.end_date = selected;
                                dt.setDate(dt.getDate() - 1);
                                $("#start_date").datepicker("option", "maxDate", dt);
                            }
                        }
                    });
                    $("#start_time").timepicker({
                        timeFormat: 'HH:mm',
                        interval: 15,
                        zindex: 999999999,
                        change: function (time) {
                            // the input field
                            var element = $(this), text;
                            // get access to this Timepicker instance
                            var timepicker = element.timepicker();
                            text = 'Selected time is: ' + timepicker.format(time);
                            self.event.start_time = timepicker.format(time);
                        },
                    });
                    $("#end_time").timepicker({
                        timeFormat: 'HH:mm',
                        interval: 15,
                        zindex: 999999999,
                        change: function (time) {
                            // the input field
                            var element = $(this), text;
                            // get access to this Timepicker instance
                            var timepicker = element.timepicker();
                            text = 'Selected time is: ' + timepicker.format(time);
                            self.event.end_time = timepicker.format(time);
                        },
                    });
                    $("#occurrence_from_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        onSelect: function (selected) {
                            self.event.occurrence_from_date = selected;
                            let dt = new Date(selected);
                            dt.setDate(dt.getDate() + 1);
                            $("#occurrence_to_date").datepicker("option", "minDate", dt);
                            self.error.occurrence_from_date = '';
                        },
                        minDate: 0
                    });
                    $("#occurrence_to_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        onSelect: function (selected) {
                            if (self.event.occurrence_from_date === '') {
                                self.event.occurence_to_date = '';
                                $("#occurrence_to_date").val('');
                                self.error.occurence_to_date = 'Please select start date first';
                                self.error.show = true;
                            } else {
                                let dt = new Date(selected);
                                self.event.occurence_to_date = selected;
                                dt.setDate(dt.getDate() - 1);
                                $("#occurrence_from_date").datepicker("option", "maxDate", dt);
                            }
                        }
                    });
                    $("#occurrence_start_time").timepicker({
                        timeFormat: 'HH:mm',
                        interval: 15,
                        zindex: 999999999,
                        change: function (time) {
                            // the input field
                            var element = $(this), text;
                            // get access to this Timepicker instance
                            var timepicker = element.timepicker();
                            text = 'Selected time is: ' + timepicker.format(time);
                            self.event.occurrence_start_time = timepicker.format(time);
                        },
                    });
                    $("#occurrence_end_time").timepicker({
                        timeFormat: 'HH:mm',
                        interval: 15,
                        zindex: 999999999,
                        change: function (time) {
                            // the input field
                            var element = $(this), text;
                            // get access to this Timepicker instance
                            var timepicker = element.timepicker();
                            text = 'Selected time is: ' + timepicker.format(time);
                            self.event.occurrence_end_time = timepicker.format(time);
                        },
                    });
                    let input = self.$refs.eventAddressField;
                    self.autocomplete = new google.maps.places.Autocomplete(input);
                });
                this.sanitizeTitleEventUrl(this.event.event_url);
            },
            /*------------------------------------------------------*/
            /* remove image */
            removeImage(index) {
                this.event.r_e_l__event__image.splice(index, 1);
            },
            /*------------------------------------------------------*/
            /* on image change */
            onImageChange(e) {
                // console.log(e.target.files);

                this.images = [];
                let files = e.target.files || e.dataTransfer.files;
                for (let i = files.length - 1; i >= 0; i--) {
                    this.images.push(files[i]);
                }

            },
            /*------------------------------------------------------*/
            /* edit event in database */
            editLiveEvent() {
                this.event.event_description = CKEDITOR.instances['event_description'].getData();
                this.success.show = false;
                if (this.validateForm()) {
                    let formData = new FormData();
                    if (this.images.length > 0) {
                        for (let i = 0; i < this.images.length; i++) {
                            let image = this.images[i];
                            formData.append('event_image[]', image);
                        }
                    }
                    formData.append('event_id', this.event.id);
                    formData.append('event_title', this.event.event_title);
                    formData.append('event_url', this.event.event_url);
                    formData.append('event_image', this.event_image);
                    formData.append('event_location', this.event.event_location);
                    formData.append('address', this.event.address);
                    formData.append('start_date', this.event.start_date);
                    formData.append('start_time', this.event.start_time);
                    formData.append('end_date', this.event.end_date);
                    formData.append('end_time', this.event.end_time);
                    formData.append('event_description', this.event.event_description);
                    formData.append('category_id', this.event.category_id);
                    formData.append('subcategory_id', this.event.subcategory_id);
                    if(this.event.other_information == null || this.event.other_information === 'null'){
                        this.event.other_information = '';
                    }
                    formData.append('other_information', this.event.other_information);
                    formData.append('aditional_information', this.event.aditional_information);
                    if(this.event.address_2 == null){
                        this.event.address_2 = '';
                    }
                    formData.append('address_2', this.event.address_2);
                    formData.append('is_recurring', this.event.is_recurring);
                    formData.append('event_occurrence_type', this.event.event_occurrence_type);
                    formData.append('occurrence_from_date', this.event.occurrence_from_date);
                    formData.append('show_no_of_available_tickets', this.event.show_no_of_available_tickets);
                    formData.append('occurence_to_date', this.event.occurence_to_date);
                    formData.append('occurrence_start_time', this.event.occurrence_start_time);
                    formData.append('occurrence_off_the_day', this.event.occurrence_off_the_day);
                    formData.append('occurrence_end_time', this.event.occurrence_end_time);
                    formData.append('event_status', this.event.event_status);
                    formData.append('refund_policy', this.event.refund_policy);
                    formData.append('ticket_fees', this.event.ticket_fees);
                    formData.append('is_private', this.event.is_private);
                    if(this.event.tags){
                        this.event.tags.forEach(function (val, index) {
                            formData.append('tags[' + index + ']', val.id);
                        });
                    }
                    for (let i = 0; i < this.event.r_e_l_event_ticket.length; i++) {
                        formData.append('event_type[' + i + ']', this.event.r_e_l_event_ticket[i].event_type);
                        formData.append('ticket_type[' + i + ']', this.event.r_e_l_event_ticket[i].ticket_type);
                        formData.append('price[' + i + ']', this.event.r_e_l_event_ticket[i].price);
                        formData.append('quantity[' + i + ']', this.event.r_e_l_event_ticket[i].quantity);
                    }

                    formData.append('cityLat', this.event.cityLat);
                    formData.append('cityLng', this.event.cityLng);

                    let self = this;
                    axios.post(apiurl + 'update-event', formData, header).then(function (response) {
                        self.error = {};
                        let data = response.data;
                        if (data.code === 1) {
                            // console.log(data);
                            self.event = data.payload;
                            swal.fire({
                                title: 'Success',
                                text: data.message,
                                type: 'success',
                                allowOutsideClick: false
                            }).then(function (val) {
                                if (val) {
                                    self.cancelEdit();
                                }
                            });
                            self.success.message = data.message;
                            self.success.show = true;
                        } else {
                            self.success.show = false;
                            if (data.message === 'Validation failed') {
                                self.error.message = data.dev_message;
                            } else {
                                self.error.message = data.message;
                            }
                            self.error.dev = true;
                        }
                        window.scrollTo(0, 0);
                        // console.log(data);
                    });

                }
            },
            /*------------------------------------------------------*/
            /* get subcategories */
            getSubCategories() {
                /* get all subcategory for selected category */
                if (this.event.category_id !== '') {
                    let sendData = {
                        category_id: this.event.category_id,
                    };
                    let self = this;
                    axios.post(apiurl + 'subcategory-list', sendData, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            self.subCategories = data.payload;
                        } else {
                            self.subCategories = null;
                        }
                    });
                }
            },
            /*------------------------------------------------------*/
            /* add attendee to database */
            addAttendee() {
                if (this.validateAttendee()) {
                    if (this.validEmail(this.attendee.email)) {
                        this.error.attendee.show = false;
                        let self = this;
                        this.attendee.event_id = this.event.id;
                        axios.post(apiurl + 'add-attendee', this.attendee, header)
                            .then(function (response) {
                                let data = response.data;
                                if (data.code === 1) {
                                    self.attendee.first_name = '';
                                    self.attendee.last_name = '';
                                    self.attendee.email = '';
                                    self.attendee.amount = '';
                                    self.attendee.ticket_type = '';
                                    self.attendee.quantity = '';
                                    self.attendee.payment_type = '';
                                    Swal.fire(
                                        'Success',
                                        data.message,
                                        'success'
                                    );
                                    self.success.message = data.message;
                                    self.success.show = true;
                                } else {
                                    self.success.show = false;
                                    self.error.message = data.message;
                                    self.error.show = true;
                                }
                            });
                    } else {
                        this.error.attendee.first_name = '';
                        this.error.attendee.last_name = '';
                        this.error.attendee.email = '';
                        this.error.attendee.amount = '';
                        this.error.attendee.ticket_type = '';
                        this.error.attendee.quantity = '';
                        this.attendee.payment_type = '';
                        this.error.attendee.email = 'Please enter a valid email address';
                        this.error.attendee.show = true;
                    }
                }
            },
            /*------------------------------------------------------*/
            /* validate attendee form */
            validateAttendee() {
                if (!this.attendee.first_name || !this.attendee.last_name ||
                    !this.attendee.email || !this.attendee.amount ||
                    !this.attendee.ticket_type || !this.attendee.quantity ||
                    !this.attendee.payment_type
                ) {
                    if (!this.attendee.first_name) {
                        this.error.attendee.first_name = 'First Name cannot be empty';
                        this.error.attendee.show = true;
                    } else {
                        this.error.attendee.first_name = '';
                    }
                    if (!this.attendee.last_name) {
                        this.error.attendee.last_name = 'Last Name cannot be empty';
                        this.error.attendee.show = true;
                    } else {
                        this.error.attendee.last_name = '';
                    }
                    if (!this.attendee.email) {
                        this.error.attendee.email = 'Email cannot be empty';
                        this.error.attendee.show = true;
                    } else {
                        this.error.attendee.email = '';
                    }
                    if (!this.attendee.amount) {
                        this.error.attendee.amount = 'Amount cannot be empty';
                        this.error.attendee.show = true;
                    } else {
                        this.error.attendee.amount = '';
                    }
                    if (!this.attendee.ticket_type) {
                        this.error.attendee.ticket_type = 'Please select a Ticket Type';
                        this.error.attendee.show = true;
                    } else {
                        this.error.attendee.ticket_type = '';
                    }
                    if (!this.attendee.quantity) {
                        this.error.attendee.quantity = 'Please select Ticket Quantity';
                        this.error.attendee.show = true;
                    } else {
                        this.error.attendee.quantity = '';
                    }
                    if (!this.attendee.payment_type) {
                        this.error.attendee.payment_type = 'Please Select a Payment Type';
                        this.error.attendee.show = true;
                    } else {
                        this.error.attendee.payment_type = '';
                    }
                    return false;
                } else {
                    return true;
                }
            },
            /*------------------------------------------------------*/
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            /*------------------------------------------------------*/
            /* form validation */
            validateForm() {
                if (!this.event.event_title || !this.event.event_url ||
                    !this.event.event_location || !this.event.address ||
                    !this.event.start_date || !this.event.start_time ||
                    !this.event.end_date || !this.event.end_time ||
                    !this.event.event_description || !this.event.category_id
                    || !this.event.event_status
                ) {
                    if (!this.event.event_title) {
                        this.error.title = 'Event Name cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.title = '';
                    }
                    if (!this.event.event_url) {
                        this.error.url = 'Event unique url cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.url = '';
                    }
                    if (!this.event.event_location) {
                        this.error.location = 'Event Location cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.location = '';
                    }
                    if (!this.event.address) {
                        this.error.address = 'Event Address cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.address = '';
                    }
                    if (!this.event.start_date) {
                        this.error.startDate = 'Event Start Date cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.startDate = '';
                    }
                    if (!this.event.start_time) {
                        this.error.startTime = 'Event Start Time cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.startTime = '';
                    }
                    if (!this.event.end_date) {
                        this.error.endDate = 'Event End Date cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.endDate = '';
                    }
                    if (!this.event.end_time) {
                        this.error.endTime = 'Event End Time cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.endTime = '';
                    }
                    if (!this.event.event_description) {
                        this.error.description = 'Event Event Description cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.description = '';
                    }
                    if (!this.event.event_status) {
                        this.error.status = 'Event Status cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.status = '';
                    }
                    /*if (!this.event.other_information) {
                        this.error.otherInformation = 'Event Other Information cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.otherInformation = '';
                    }*/
                    if (!this.event.category_id) {
                        this.error.category = 'Event Category cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.category = '';
                    }
                    window.scrollTo(0, 0);
                    return false;
                } else if (this.event.is_recurring) {
                    if (!this.event.occurrence_start_time || !this.event.occurrence_end_time
                        || !this.event.occurrence_off_the_day || !this.event.occurrence_from_date
                        || !this.event.occurence_to_date || !this.event.event_occurrence_type
                    ) {
                        if (!this.event.occurrence_start_time) {
                            this.error.occurrence_start_time = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurrence_start_time = '';
                        }
                        if (!this.event.occurrence_end_time) {
                            this.error.occurrence_end_time = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurrence_end_time = '';
                        }
                        if (!this.event.occurrence_off_the_day) {
                            this.error.occurrence_off_the_day = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurrence_off_the_day = '';
                        }

                        if (!this.event.occurrence_from_date) {
                            this.error.occurrence_from_date = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurrence_from_date = '';
                        }

                        if (!this.event.occurence_to_date) {
                            this.error.occurence_to_date = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurence_to_date = '';
                        }
                        if (!this.event.event_occurrence_type) {
                            this.error.event_occurrence_type = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.event_occurrence_type = '';
                        }
                        window.scrollTo(0, 0);
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            },
            /*------------------------------------------------------*/
            /* add ticket dynamic rows */
            addRow: function () {
                this.event.r_e_l_event_ticket.push({});
            },
            /*------------------------------------------------------*/
            /* remove ticket dynamic rows */
            removeRow(index) {
                this.event.r_e_l_event_ticket.splice(index, 1);
            },
            /*------------------------------------------------------*/
            /* get all event categories */
            getCategories: function () {
                let self = this;
                axios.post(apiurl + 'category-list', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.categories = data.payload;
                        /*self.event.categories = data.payload;
                        console.warn(self.event.categories);*/
                    }
                });
            },
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /* delete event ( under construction ) */
            deleteEvent(eventId) {
                alert('this feature is under construction :)');
                /*if (confirm('Are you sure you want to delete this event')) {
                    let self = this;
                    axios.post(apiurl + 'delete-event', {id: eventId}, header).then(function (response) {
                        if (response.data.code === 1) {
                            self.getLiveEvents();
                        }
                    });
                } else {
                    return false;
                }*/
            },
            /*------------------------------------------------------*/
            /* create slug */
            sanitizeTitle: function (title) {
                let slug = "";
                // Change to lower case
                let titleLower = title.toLowerCase();
                // Letter "e"
                slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
                // Letter "a"
                slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
                // Letter "o"
                slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
                // Letter "u"
                slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
                // Letter "d"
                slug = slug.replace(/đ/gi, 'd');
                // Trim the last whitespace
                slug = slug.replace(/\s*$/g, '');
                // Change whitespace to "-"
                slug = slug.replace(/\s+/g, '-');
                /*this.event.url = slug;*/
                return slug;
            },
            /*------------------------------------------------------*/
            /* edit slug */
            sanitizeTitleEventUrl: function (title) {
                let slug = "";
                // Change to lower case
                let titleLower = title.toLowerCase();
                // Letter "e"
                slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
                // Letter "a"
                slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
                // Letter "o"
                slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
                // Letter "u"
                slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
                // Letter "d"
                slug = slug.replace(/đ/gi, 'd');
                // Trim the last whitespace
                slug = slug.replace(/\s*$/g, '');
                // Change whitespace to "-"
                slug = slug.replace(/\s+/g, '-');
                /*this.event.url = slug;*/
                this.event.event_url = slug;
            },
            /*------------------------------------------------------*/
            getInsightRevenueDetails(event_id) {
                let self = this;
                axios.post(apiurl + 'event-insights', {event_id: event_id}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.insights = data.payload;
                    } else {
                        self.insights = {};
                    }
                });
            },
            /*------------------------------------------------------------------*/
            addressChanged() {
                let self = this;
                this.autocomplete.addListener('place_changed', function (val) {
                    let place = self.autocomplete.getPlace();
                    self.event.address = '';
                    /*self.event.address = place.address_components[0]["long_name"];*/
                    place.address_components.forEach(function (val) {
                        if (val.short_name) {
                            self.event.address += val.short_name + ', ';
                        }
                        if (val.types[0] === 'country') {
                            self.event.location = val.long_name;
                        }
                    });
                    self.event.cityLat = place.geometry.location.lat();
                    self.event.cityLng = place.geometry.location.lng();
                });
            },
            /*------------------------------------------------------------------*/
            /*------------------------------------------------------------------*/
            getTags() {
                let self = this;
                axios.post(baseurl + 'get-tags', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.tags = data.payload;
                    }
                });
            },
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
        },
        created() {
            this.getLiveEvents();
            /* get all category for event */
            this.getCategories();
            this.getTags();
        },
    });
}
/*------------------------------------------------------*/
/* draft events list for organizer dashboard */
if ($("#draft-events").length > 0) {
    new Vue({
        el: '#draft-events',
        data: {
            event: {},
            edit: false,
            events: {},
            imageUrl: imageurl,
            error: {
                title: '',
                url: '',
                location: '',
                address: '',
                startDate: '',
                startTime: '',
                endDate: '',
                endTime: '',
                description: '',
                status: '',
                otherInformation: '',
                selectCategory: '',
                occurrence_start_time: '',
                occurrence_end_time: '',
                occurrence_off_the_day: '',
                occurrence_from_date: '',
                occurence_to_date: '',
                message: '',
                show: false
            },
            success: {
                message: '',
                show: false
            },
            categories: {},
            subCategories: {},
            additional_information: [],
            images: [],
            rows: [{}],
            autocomplete: {},
            tags: [],
        },
        computed: {
            url: function () {
                this.event.event_url = this.sanitizeTitle(this.event.event_url);
                return basehomeurl;
            },
        },
        methods: {
            /*------------------------------------------------------*/
            disableAmountIfFree(some, index) {
                if (some === '1') {
                    this.event.price[index] = 0;
                    this.event.disableAmount[index] = true;
                } else {
                    this.event.disableAmount[index] = false;
                }
            },
            /*------------------------------------------------------*/
            getDraftEvents(page) {
                if (typeof page == 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'draft-event-list?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;
                        // console.log(data.payload.data);
                    } else {
                        self.events = {};
                        self.error.message = data.message;
                        self.error.show = true;
                        // console.log(data);
                    }
                });
            },
            /*-------------------------------------------------------------------*/
            cancelEdit() {
                this.edit = false;
                this.getDraftEvents();
            },
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*deleteEvent(eventId) {
                if (confirm('Are you sure you want to delete this event')) {
                    let self = this;
                    axios.post(apiurl + 'delete-event', {id: eventId}, header).then(function (response) {
                        if (response.data.code === 1) {
                            self.getDraftEvents();
                        }
                    });
                } else {
                    return false;
                }
            },*/
            /*-------------------------------------------------------------------*/
            /*activateEvent(event_id) {
                let self = this;
                axios.post(apiurl + 'activate-event', {id: event_id}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.success.message = data.message;
                        self.success.show = true;
                        self.getDraftEvents();
                    } else {
                        self.error.message = data.message;
                        self.error.show = true;
                        self.success.show = false;
                    }
                });
            },*/
            /*-------------------------------------------------------------------*/
            /*-----------------------------------------------------------------*/
            editEvent(event) {
                let self = this;
                this.edit = true;
                this.success.show = false;
                this.error.show = false;
                this.event = event;
                this.getSubCategories();
                this.additional_information = this.event.aditional_information.split(',');
                Vue.nextTick(function () {
                    CKEDITOR.replace('event_description');
                    $("#start_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        onSelect: function (selected) {
                            self.event.start_date = selected;
                            self.event.end_date = selected;
                            let dt = new Date(selected);
                            /*dt.setDate(dt.getDate() + 1);*/
                            dt.setDate(dt.getDate());
                            $("#end_date").datepicker("option", "minDate", dt);
                            self.error.start_date = '';
                        },
                        minDate: 0
                    });
                    $("#end_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        onSelect: function (selected) {
                            if (self.event.start_date === '') {
                                self.event.end_date = '';
                                $("#end_date").val('');
                                self.error.endDate = 'Please select start date first';
                                self.error.show = true;
                            } else {
                                let dt = new Date(selected);
                                self.event.end_date = selected;
                                dt.setDate(dt.getDate() - 1);
                                $("#start_date").datepicker("option", "maxDate", dt);
                            }
                        }
                    });
                    $("#start_time").timepicker({
                        timeFormat: 'HH:mm',
                        interval: 15,
                        zindex: 999999999,
                        change: function (time) {
                            // the input field
                            var element = $(this), text;
                            // get access to this Timepicker instance
                            var timepicker = element.timepicker();
                            text = 'Selected time is: ' + timepicker.format(time);
                            self.event.start_time = timepicker.format(time);
                        },
                    });
                    $("#end_time").timepicker({
                        timeFormat: 'HH:mm',
                        interval: 15,
                        zindex: 999999999,
                        change: function (time) {
                            // the input field
                            var element = $(this), text;
                            // get access to this Timepicker instance
                            var timepicker = element.timepicker();
                            text = 'Selected time is: ' + timepicker.format(time);
                            self.event.end_time = timepicker.format(time);
                        },
                    });
                    $("#occurrence_from_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        onSelect: function (selected) {
                            self.event.occurrence_from_date = selected;
                            let dt = new Date(selected);
                            dt.setDate(dt.getDate() + 1);
                            $("#occurrence_to_date").datepicker("option", "minDate", dt);
                            self.error.occurrence_from_date = '';
                        },
                        minDate: 0
                    });
                    $("#occurrence_to_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        onSelect: function (selected) {
                            if (self.event.occurrence_from_date === '') {
                                self.event.occurence_to_date = '';
                                $("#occurrence_to_date").val('');
                                self.error.occurence_to_date = 'Please select start date first';
                                self.error.show = true;
                            } else {
                                let dt = new Date(selected);
                                self.event.occurence_to_date = selected;
                                dt.setDate(dt.getDate() - 1);
                                $("#occurrence_from_date").datepicker("option", "maxDate", dt);
                            }
                        }
                    });
                    $("#occurrence_start_time").timepicker({
                        timeFormat: 'HH:mm',
                        interval: 15,
                        zindex: 999999999,
                        change: function (time) {
                            // the input field
                            var element = $(this), text;
                            // get access to this Timepicker instance
                            var timepicker = element.timepicker();
                            text = 'Selected time is: ' + timepicker.format(time);
                            self.event.occurrence_start_time = timepicker.format(time);
                        },
                    });
                    $("#occurrence_end_time").timepicker({
                        timeFormat: 'HH:mm',
                        interval: 15,
                        zindex: 999999999,
                        change: function (time) {
                            // the input field
                            var element = $(this), text;
                            // get access to this Timepicker instance
                            var timepicker = element.timepicker();
                            text = 'Selected time is: ' + timepicker.format(time);
                            self.event.occurrence_end_time = timepicker.format(time);
                        },
                    });

                    let input = self.$refs.eventAddressField;
                    self.autocomplete = new google.maps.places.Autocomplete(input);

                });
                this.sanitizeTitleEventUrl(this.event.event_url);
                // jquery multiple image upload

            },
            /*------------------------------------------------------*/
            removeImage(index) {
                this.event.r_e_l__event__image.splice(index, 1);
            },
            /*------------------------------------------------------*/
            onImageChange(e) {
                // console.log(e.target.files);
                this.images = [];
                let files = e.target.files || e.dataTransfer.files;
                for (let i = files.length - 1; i >= 0; i--) {
                    this.images.push(files[i]);
                }

            },
            /*------------------------------------------------------*/
            editDraftEvent() {
                this.event.event_description = CKEDITOR.instances['event_description'].getData();
                this.success.show = false;
                if (this.validateForm()) {
                    let formData = new FormData();
                    if (this.images.length > 0) {
                        for (let i = 0; i < this.images.length; i++) {
                            let image = this.images[i];
                            formData.append('event_image[]', image);
                        }
                    }
                    formData.append('event_id', this.event.id);
                    formData.append('event_title', this.event.event_title);
                    formData.append('event_url', this.event.event_url);
                    formData.append('event_image', this.event_image);
                    formData.append('event_location', this.event.event_location);
                    formData.append('address', this.event.address);
                    formData.append('start_date', this.event.start_date);
                    formData.append('start_time', this.event.start_time);
                    formData.append('end_date', this.event.end_date);
                    formData.append('end_time', this.event.end_time);
                    formData.append('event_description', this.event.event_description);
                    formData.append('category_id', this.event.category_id);
                    formData.append('subcategory_id', this.event.subcategory_id);
                    if(this.event.other_information == null || this.event.other_information === 'null'){
                        this.event.other_information = '';
                    }
                    formData.append('other_information', this.event.other_information);
                    formData.append('aditional_information', this.event.aditional_information);
                    if(this.event.address_2 == null){
                        this.event.address_2 = '';
                    }
                    formData.append('address_2', this.event.address_2);
                    formData.append('is_recurring', this.event.is_recurring);
                    formData.append('event_occurrence_type', this.event.event_occurrence_type);
                    formData.append('occurrence_from_date', this.event.occurrence_from_date);
                    formData.append('show_no_of_available_tickets', this.event.show_no_of_available_tickets);
                    formData.append('occurence_to_date', this.event.occurence_to_date);
                    formData.append('occurrence_start_time', this.event.occurrence_start_time);
                    formData.append('occurrence_off_the_day', this.event.occurrence_off_the_day);
                    formData.append('occurrence_end_time', this.event.occurrence_end_time);
                    formData.append('event_status', this.event.event_status);
                    formData.append('refund_policy', this.event.refund_policy);
                    formData.append('ticket_fees', this.event.ticket_fees);
                    formData.append('is_private', this.event.is_private);
                    if(this.event.tags){
                        this.event.tags.forEach(function (val, index) {
                            formData.append('tags[' + index + ']', val.id);
                        });
                    }
                    for (let i = 0; i < this.event.r_e_l_event_ticket.length; i++) {
                        formData.append('event_type[' + i + ']', this.event.r_e_l_event_ticket[i].event_type);
                        formData.append('ticket_type[' + i + ']', this.event.r_e_l_event_ticket[i].ticket_type);
                        formData.append('price[' + i + ']', this.event.r_e_l_event_ticket[i].price);
                        formData.append('quantity[' + i + ']', this.event.r_e_l_event_ticket[i].quantity);
                    }

                    formData.append('cityLat', this.event.cityLat);
                    formData.append('cityLng', this.event.cityLng);

                    let self = this;
                    axios.post(apiurl + 'update-event', formData, header).then(function (response) {
                        self.error = {};
                        let data = response.data;
                        if (data.code === 1) {
                            // console.log(data);
                            self.event = data.payload;
                            swal.fire({
                                title: 'Success',
                                text: data.message,
                                type: 'success',
                                allowOutsideClick: false
                            }).then(function (val) {
                                if (val) {
                                    self.cancelEdit();
                                }
                            });
                        } else {
                            self.success.show = false;
                            if (data.message === 'Validation failed') {
                                self.error.message = data.dev_message;
                                self.error.show = true;
                            } else {
                                self.error.message = data.message;
                                self.error.show = true;
                            }
                        }
                        window.scrollTo(0, 0);
                        // console.log(data);
                    });

                }
            },
            /*------------------------------------------------------*/
            getSubCategories() {
                /* get all subcategory for selected category */
                if (this.event.category_id !== '') {
                    let sendData = {
                        category_id: this.event.category_id,
                    };
                    let self = this;
                    axios.post(apiurl + 'subcategory-list', sendData, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            self.subCategories = data.payload;
                        } else {
                            self.subCategories = null;
                        }
                    });
                }
            },
            /*------------------------------------------------------*/
            /* form validation */
            validateForm() {
                if (!this.event.event_title || !this.event.event_url ||
                    !this.event.event_location || !this.event.address ||
                    !this.event.start_date || !this.event.start_time ||
                    !this.event.end_date || !this.event.end_time ||
                    !this.event.event_description || !this.event.other_information ||
                    !this.event.category_id || this.event.event_status === null
                ) {
                    if (!this.event.event_title) {
                        this.error.title = 'Event Name cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.title = '';
                    }
                    if (!this.event.event_url) {
                        this.error.url = 'Event unique url cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.url = '';
                    }
                    if (!this.event.event_location) {
                        this.error.location = 'Event Location cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.location = '';
                    }
                    if (!this.event.address) {
                        this.error.address = 'Event Address cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.address = '';
                    }
                    if (!this.event.start_date) {
                        this.error.startDate = 'Event Start Date cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.startDate = '';
                    }
                    if (!this.event.start_time) {
                        this.error.startTime = 'Event Start Time cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.startTime = '';
                    }
                    if (!this.event.end_date) {
                        this.error.endDate = 'Event End Date cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.endDate = '';
                    }
                    if (!this.event.end_time) {
                        this.error.endTime = 'Event End Time cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.endTime = '';
                    }
                    if (!this.event.event_description) {
                        this.error.description = 'Event Event Description cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.description = '';
                    }
                    if (this.event.event_status === null) {
                        this.error.status = 'Event Status cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.status = '';
                    }
                    if (!this.event.other_information) {
                        this.error.otherInformation = 'Event Other Information cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.otherInformation = '';
                    }
                    if (!this.event.category_id) {
                        this.error.category = 'Event Category cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.category = '';
                    }
                    window.scrollTo(0, 0);
                    return false;
                } else if (this.event.is_recurring) {
                    if (!this.event.occurrence_start_time || !this.event.occurrence_end_time
                        || !this.event.occurrence_off_the_day || !this.event.occurrence_from_date
                        || !this.event.occurence_to_date || !this.event.event_occurrence_type
                    ) {
                        if (!this.event.occurrence_start_time) {
                            this.error.occurrence_start_time = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurrence_start_time = '';
                        }
                        if (!this.event.occurrence_end_time) {
                            this.error.occurrence_end_time = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurrence_end_time = '';
                        }
                        if (!this.event.occurrence_off_the_day) {
                            this.error.occurrence_off_the_day = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurrence_off_the_day = '';
                        }

                        if (!this.event.occurrence_from_date) {
                            this.error.occurrence_from_date = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurrence_from_date = '';
                        }

                        if (!this.event.occurence_to_date) {
                            this.error.occurence_to_date = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.occurence_to_date = '';
                        }
                        if (!this.event.event_occurrence_type) {
                            this.error.event_occurrence_type = 'This field is required';
                            this.error.show = true;
                        } else {
                            this.error.event_occurrence_type = '';
                        }
                        window.scrollTo(0, 0);
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            },
            /*------------------------------------------------------*/
            addRow: function () {
                this.event.r_e_l_event_ticket.push({});
            },
            /*------------------------------------------------------*/
            removeRow(index) {
                this.event.r_e_l_event_ticket.splice(index, 1);
            },
            /*------------------------------------------------------*/
            getCategories: function () {
                let self = this;
                axios.post(apiurl + 'category-list', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.categories = data.payload;
                        /*self.event.categories = data.payload;
                        console.warn(self.event.categories);*/
                    }
                });
            },
            /*------------------------------------------------------*/
            /* create slug */
            sanitizeTitle: function (title) {
                let slug = "";
                // Change to lower case
                let titleLower = title.toLowerCase();
                // Letter "e"
                slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
                // Letter "a"
                slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
                // Letter "o"
                slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
                // Letter "u"
                slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
                // Letter "d"
                slug = slug.replace(/đ/gi, 'd');
                // Trim the last whitespace
                slug = slug.replace(/\s*$/g, '');
                // Change whitespace to "-"
                slug = slug.replace(/\s+/g, '-');
                /*this.event.url = slug;*/
                return slug;
            },
            /*------------------------------------------------------*/
            /* edit slug */
            sanitizeTitleEventUrl: function (title) {
                let slug = "";
                // Change to lower case
                let titleLower = title.toLowerCase();
                // Letter "e"
                slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
                // Letter "a"
                slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
                // Letter "o"
                slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
                // Letter "u"
                slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
                // Letter "d"
                slug = slug.replace(/đ/gi, 'd');
                // Trim the last whitespace
                slug = slug.replace(/\s*$/g, '');
                // Change whitespace to "-"
                slug = slug.replace(/\s+/g, '-');
                /*this.event.url = slug;*/
                this.event.event_url = slug;
            },
            /*------------------------------------------------------------------*/
            /*------------------------------------------------------------------*/
            addressChanged() {
                let self = this;
                this.autocomplete.addListener('place_changed', function (val) {
                    let place = self.autocomplete.getPlace();
                    self.event.address = '';
                    /*self.event.address = place.address_components[0]["long_name"];*/
                    place.address_components.forEach(function (val) {
                        if (val.short_name) {
                            self.event.address += val.short_name + ', ';
                        }
                        if (val.types[0] === 'country') {
                            self.event.location = val.long_name;
                        }
                    });
                    self.event.cityLat = place.geometry.location.lat();
                    self.event.cityLng = place.geometry.location.lng();
                });
            },
            /*------------------------------------------------------------------*/
            getTags() {
                let self = this;
                axios.post(baseurl + 'get-tags', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.tags = data.payload;
                    }
                });
            },
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
            /*-------------------------------------------------------------------*/
        },
        mounted() {
            this.getDraftEvents();
            this.getCategories();
            this.getTags();
        },
    });
}
/*------------------------------------------------------*/
/* draft events list for organizer dashboard */
if ($("#past-events").length > 0) {
    new Vue({
        el: '#past-events',
        data: {
            events: {},
            insight: false,
            insights: {},
            imageUrl: imageurl,
            error: {
                message: '',
                show: false
            },
            success: {
                message: '',
                show: false
            },
            event: {},
        },
        methods: {
            getPastEvents(page) {
                if (typeof page == 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'past-event-list?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;
                    } else {
                        self.error.message = data.message;
                        self.error.show = true;
                    }
                });
            },
            /*-------------------------------------------------------*/
            deleteEvent(eventId) {
                if (confirm('Are you sure you want to delete this event')) {
                    let self = this;
                    axios.post(apiurl + 'delete-event', {id: eventId}, header).then(function (response) {
                        if (response.data.code === 1) {
                            self.getPastEvents();
                        }
                    });
                } else {
                    return false;
                }
            },
            /*-----------------------------------------------------------------*/
            /* go back to event list from event insight page */
            cancelInsight() {
                this.insight = false;
                this.success.show = false;
                this.event = {};
            },
            /*-------------------------------------------------------*/
            /* show event insight page */
            showInsight(event) {
                this.insight = true;
                this.success.show = false;
                this.error.show = false;
                this.event = event;
                this.getInsightRevenueDetails(event.id);
            },
            /*-------------------------------------------------------*/
            getInsightRevenueDetails(event_id) {
                let self = this;
                axios.post(apiurl + 'event-insights', {event_id: event_id}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.insights = data.payload;
                    } else {
                        self.insights = {};
                    }
                });
            },
            /*-------------------------------------------------------*/
            /*-------------------------------------------------------*/
            /*-------------------------------------------------------*/
            /*-------------------------------------------------------*/
            /*-------------------------------------------------------*/
            /*-------------------------------------------------------*/
        },
        created() {
            this.getPastEvents();
        }
    });
}
/*------------------------------------------------------*/
/* contact page contains contact list edit
    contact, delete contact, send mail to single contact,
    send mail to multiple contacts
 */
if ($("#contact-list").length > 0) {
    new Vue({
        el: '#contact-list',
        data: {
            search: false,
            sortPage: false,
            keywords: null,
            events: {},
            contacts: {},
            error: {
                eventIdForImportContacts: '',
                importFileForContacts: '',
                message: '',
                show: false
            },
            success: {
                message: '',
                show: false
            },
            edit: false,
            contact: {},
            sortBy: '',
            contactsEvent: false,
            event_id: '',
            emailText: '',
            sendMailSection: false,
            allSelected: false,
            emailContact: [],
            importContacts: false,
            liveEventsForImportContacts: {},
            eventIdForImportContacts: '',
            importFileForContacts: null,
            sendingMail: false,
        },
        watch: {
            keywords: function (val) {
                this.searchContacts();
            },
            allSelected: function (val) {
                this.selectAll();
            }
        },
        methods: {
            /*---------------------------------------------------------*/
            /* get all contact details of logged in organizer */
            getContacts(page) {
                if (typeof page == 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'contact-list?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.contacts = data.payload;
                    } else {
                        self.contacts = data;
                        self.error.message = data.message;
                        self.error.show = true;
                    }
                });
            },
            /*---------------------------------------------------------*/
            /* display edit contact section */
            editContact(contact) {
                this.edit = true;
                this.contact = contact;
            },
            /*---------------------------------------------------------*/
            /* cancel display edit contact section */
            cancelEditContact() {
                this.edit = false;
                this.success.show = false;
                this.error.show = false;
                this.getContacts();
            },
            /*---------------------------------------------------------*/
            /* update single contact */
            updateContact() {
                if (this.validateContact()) {
                    let self = this;
                    axios.post(apiurl + 'update-contact', this.contact, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1) {
                            self.contact = data.payload;
                            swal.fire('Success', data.message, 'success');
                            self.error.show = false;
                        } else {
                            swal.fire('Oops!', data.message, 'error');
                            self.success.show = false;
                        }
                    });
                }
            },
            /*---------------------------------------------------------*/
            /* delete contact */
            deleteContact(contact_id) {
                let self = this;
                swal.fire({
                    title: 'Are you sure you want to delete this contact?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.post(apiurl + 'delete-contact', {id: contact_id}, header).then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                swal.fire('Success', data.message, 'success');
                                self.getContacts();
                            }
                        });
                    }
                });
            },
            /*---------------------------------------------------------*/
            /* search contacts */
            searchContacts: function (page) {
                if (this.keywords === '' || this.keywords === null) {
                    this.sortPage = false;
                    this.search = false;
                    this.getContacts();
                } else {
                    this.sortPage = false;
                    this.search = true;
                    if (typeof page === 'undefined') {
                        page = 1;
                    }
                    let self = this;
                    let searchurl = apiurl + 'search-contact?key=' + this.keywords + '&page=' + page;
                    axios.get(searchurl, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1)
                            self.contacts = data.payload;
                        else
                            self.contacts = data;
                    });
                }
            },
            /*---------------------------------------------------------*/
            /* sort contacts */
            sortContacts: function (page) {
                if (this.sortBy === '' || this.sortBy === null) {
                    this.search = false;
                    this.sortPage = false;
                    this.getContacts();
                } else {
                    this.search = false;
                    this.sortPage = true;
                    if (typeof page === 'undefined') {
                        page = 1;
                    }
                    let self = this;
                    let searchUrl = apiurl + 'search-contact?key=' + this.sortBy + '&page=' + page;
                    axios.get(searchUrl, header).then(function (response) {
                        let data = response.data;
                        if (data.code === 1)
                            self.contacts = data.payload;
                        else
                            self.contacts = data;
                    });
                }
            },
            /*-----------------------------------------------------------------*/
            /* live event list for contact list page */
            getLiveEvents(page) {
                if (typeof page == 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'live-event-list?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;
                    } else {
                        self.events = {};
                        self.error.message = data.message;
                        self.error.show = true;
                    }
                });
            },
            /*-----------------------------------------------------------------*/
            /* set event id to get contacts list based on event id */
            setContactsByEvent(event_id) {
                this.event_id = event_id;
                this.getContactsByEvent();
            },
            /*-----------------------------------------------------------------*/
            /* get contacts linked to events */
            getContactsByEvent(page) {
                this.search = false;
                this.sortPage = false;
                this.contactsEvent = true;
                if (typeof page == 'undefined') {
                    page = 1
                }
                let self = this;
                axios.get(apiurl + 'contact-list-by-event?event_id=' + this.event_id + '&page=' + page, header)
                    .then(function (response) {
                        let data = response.data;
                        if (data.code === 1)
                            self.contacts = data.payload;
                        else
                            self.contacts = data;
                    });

            },
            /*-----------------------------------------------------------------*/
            showSendMail(contactId) {
                this.sendMailSection = true;
                this.emailContact = [contactId];
            },
            /*-----------------------------------------------------------------*/
            showSendBulkMail() {
                this.sendMailSection = true;
            },
            /*-----------------------------------------------------------------*/
            /* send mail to user/users */
            sendMail() {
                if (!this.emailText) {
                    this.error.emailText = 'This field is required';
                    this.error.show = true;
                    return false;
                }
                this.error.emailText = '';
                let self = this;
                if (this.emailContact.length < 1) {
                    alert('Please select at least one contacts');
                    return false;
                }
                let sendData = {
                    contacts: this.emailContact,
                    message: this.emailText
                };
                this.sendingMail = true;
                axios.post(apiurl + 'send-bulk-mail-to-contact', sendData, header).then(function (response) {
                    let data = response.data;
                    /*console.log(data);*/
                    if (data.code === 1) {
                        swal.fire('Success', data.message, 'success');
                        self.emailText = '';
                        self.cancelSendEmail();
                        self.sendingMail = false;
                    } else {
                        swal.fire('Oops!', data.message, 'error');
                        /*self.error.message = data.message;
                        self.error.show = true;*/
                        self.message.show = false;
                        self.sendingMail = false;
                    }
                });
            },
            /*-----------------------------------------------------------------*/
            cancelSendEmail() {
                this.emailContact = [];
                this.emailText = '';
                this.sendMailSection = false;
            },
            /*-----------------------------------------------------------------*/
            validateContact() {
                if (!this.contact.first_name || !this.contact.last_name
                    || !this.contact.email
                ) {
                    if (!this.contact.first_name) {
                        this.error.firstName = 'First name cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.firstName = '';
                    }
                    if (!this.contact.last_name) {
                        this.error.lastName = 'Last name cannot be emapty';
                        this.error.show = true;
                    } else {
                        this.error.lastName = '';
                    }
                    if (!this.contact.email) {
                        this.error.email = 'Email cannot be emapty';
                        this.error.show = true;
                    } else {
                        this.error.email = '';
                    }
                } else {
                    this.error.show = false;
                    return true;
                }
            },
            /*-----------------------------------------------------------------*/
            selectAll: function () {
                let self = this;
                this.emailContact = [];
                if (this.allSelected) {
                    this.contacts.data.forEach(function (value) {
                        self.emailContact.push(value.id);
                    });
                }
            },
            select: function () {
                this.allSelected = false;
            },
            /*-----------------------------------------------------------------*/
            /* cancel import contacts with excel file */
            cancelImportContact: function () {
                this.error.show = false;
                this.success.show = false;
                this.importContacts = false;
                this.getContacts();
            },
            /*-----------------------------------------------------------------*/
            /* show import contacts with excel file section*/
            showImportContacts: function () {
                this.edit = false;
                this.sendMailSection = false;
                this.importContacts = true;
                this.getEventsForImportContacts();
            },
            /*-----------------------------------------------------------------*/
            /*setting excel file*/
            contactExcelFileUpload: function (e) {
                this.importFileForContacts = e.target.files[0];
            },
            /*-----------------------------------------------------------------*/
            /* import contacts with excel file */
            importContactsToDb: function () {
                let self = this;
                if (this.validateImportContacts()) {
                    if (this.importFileForContacts !== null && this.importFileForContacts !== '') {
                        if (this.importFileForContacts.size > 1024 * 1024) {
                            this.error.importFileForContacts = 'File too big (> 1MB)';
                            this.error.show = true;
                            document.getElementById("import_file").value = '';
                            this.importFileForContacts = null;
                            return false;
                        } else if (this.importFileForContacts
                            && this.importFileForContacts.type !== 'application/vnd.ms-excel'
                            && this.importFileForContacts.type
                            !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        ) {
                            this.error.importFileForContacts = 'please select an excel file only';
                            this.error.show = true;
                            document.getElementById("import_file").value = '';
                            this.importFileForContacts = null;
                            return false;
                        }
                        this.error.importFileForContacts = '';

                        let formData = new FormData();
                        formData.append('event_id', this.eventIdForImportContacts);
                        formData.append('file', this.importFileForContacts);
                        axios.post(apiurl + 'import-contact', formData, header).then(function (response) {
                            let data = response.data;
                            if (data.code === 1) {
                                swal.fire('Success', data.message, 'success');
                                self.getContacts();
                                self.eventIdForImportContacts = '';
                                self.importFileForContacts = null;
                                document.getElementById('import_file').value = '';
                            } else {
                                swal.fire('Oops!', data.message, 'error');
                                self.getContacts();
                            }
                        });
                    }
                }
            },
            /*-----------------------------------------------------------------*/
            /* event list for contacts to select */
            getEventsForImportContacts: function () {
                let self = this;
                axios.post(apiurl + 'get-events-for-import-contacts', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.liveEventsForImportContacts = data.payload;
                    } else {
                        self.liveEventsForImportContacts = {};
                    }
                });
            },
            /*-----------------------------------------------------------------*/
            validateImportContacts: function () {
                if (!this.eventIdForImportContacts || !this.importFileForContacts
                ) {
                    if (!this.eventIdForImportContacts) {
                        this.error.eventIdForImportContacts = 'Please select an event';
                        this.error.show = true;
                    } else {
                        this.error.eventIdForImportContacts = '';
                    }
                    if (this.importFileForContacts === null || typeof this.importFileForContacts === 'undefined'
                        || this.importFileForContacts === ''
                    ) {
                        this.error.importFileForContacts = 'Please select an excel file';
                        this.error.show = true;
                    } else {
                        this.error.importFileForContacts = '';
                    }
                    return false;
                } else {
                    this.error.eventIdForImportContacts = '';
                    this.error.importFileForContacts = '';
                    this.error.show = false;
                    return true;
                }
            },
            /*-----------------------------------------------------------------*/
            /*-----------------------------------------------------------------*/
            /*-----------------------------------------------------------------*/
            /*-----------------------------------------------------------------*/
            /*-----------------------------------------------------------------*/
        },

        created() {
            this.getLiveEvents();
            this.getContacts();
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
/* attendee list page search attendee export attendee
    get list by give date, sort by ticket type and date
    of purchase
    resend ticket action.
 */
if ($("#attendee-list").length > 0) {
    new Vue({
        el: '#attendee-list',
        data: {
            attendees: {},
            attendee: {},
            error: {},
            success: {},
            search: false,
            sort: false,
            byDate: false,
            keywords: null,
            search_by_date: null,
            sortBy: '',
        },
        watch: {
            sortBy: function () {
                this.sortAttendeesData();
            },
            search_by_date: function () {
                this.searchByDate();
            }
        },
        methods: {
            sortAttendeesData(page) {
                if (this.sortBy === '' || this.sortBy === null) {
                    this.sort = false;
                    this.search = false;
                    this.byDate = false;
                    this.getAttendees();
                } else {
                    this.sort = true;
                    this.search = false;
                    this.byDate = false;
                    if (typeof page === 'undefined') {
                        page = 1;
                    }
                    let self = this;
                    let searchurl = apiurl + 'search-attendee?key=' + this.sortBy + '&page=' + page;
                    axios.get(searchurl, header).then(function (response) {
                        if (response.data.code === 1)
                            self.attendees = response.data.payload;
                        else
                            self.attendees = response.data;
                    });
                }
            },
            searchByDate(page) {
                if (this.byDate === '' || this.byDate === null) {
                    this.sort = false;
                    this.search = false;
                    this.byDate = false;
                    this.getAttendees();
                } else {
                    this.sort = false;
                    this.search = false;
                    this.byDate = true;
                    if (typeof page === 'undefined') {
                        page = 1;
                    }
                    let self = this;
                    let searchurl = apiurl + 'search-attendee-by-date?key=' + this.search_by_date + '&page=' + page;
                    axios.get(searchurl, header).then(function (response) {
                        if (response.data.code === 1)
                            self.attendees = response.data.payload;
                        else
                            self.attendees = response.data;
                    });
                }
            },
            getAttendees(page) {
                this.sort = false;
                this.byDate = false;
                this.search = false;
                if (typeof page == 'undefined') {
                    page = 1
                }
                let self = this;
                axios.get(apiurl + 'attendee-list?&page=' + page, header)
                    .then(function (response) {
                        let data = response.data;
                        if (data.code === 1)
                            self.attendees = data.payload;
                        else
                            self.attendees = data;
                    });
            },
            /* search coupons */
            searchAttendees(page) {
                if (this.keywords === '' || this.keywords === null) {
                    this.search = false;
                    this.sort = false;
                    this.byDate = false;
                    this.getAttendees();
                } else {
                    this.search = true;
                    this.sort = false;
                    this.byDate = false;
                    if (typeof page === 'undefined') {
                        page = 1;
                    }
                    let self = this;
                    let searchurl = apiurl + 'search-attendee?key=' + this.keywords + '&page=' + page;
                    axios.get(searchurl, header).then(function (response) {
                        if (response.data.code === 1)
                            self.attendees = response.data.payload;
                        else
                            self.attendees = response.data;
                    });
                }
            },
        },
        beforeUpdate: function () {
            let self = this;
            $("#search-by-date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    self.search_by_date = selected;
                },
            });
        },
        mounted() {
            this.getAttendees();
        }
    });
}
/*------------------------------------------------------*/
/* promoters requests to promote events */
if ($("#promotion-requests-list").length > 0) {
    new Vue({
        el: '#promotion-requests-list',
        data: {
            promoRequests: {},
            promoRequest: {},
            error: {
                message: '',
                show: false,
            },

        },
        methods: {
            getMyPromoRequests(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                let sendData = {
                    page: page,
                };
                axios.post(apiurl + 'all-promo', sendData, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.promoRequests = data.payload;
                    } else {
                        self.promoRequests = data;
                    }
                });
            },
            updatePromoStatus(promo_id, promo_status) {
                console.log(promo_status);
                let self = this;
                let sendData = {
                    promo_id: promo_id,
                    promo_status: promo_status
                };
                axios.post(apiurl + 'update-promo-status', sendData, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        swal.fire('Success', data.message, 'success');
                        self.getMyPromoRequests();
                    } else {
                        swal.fire('Oops!', data.message, 'error');
                    }
                });
            },
            /*rejectPromo(promo_id, promo_status){
                let self = this;
                let sendData = {
                    promo_id: promo_id,
                    promo_status: promo_stats
                };
                axios.post(apiurl + 'update-promo-status', sendData, header).then(function(response){
                    let data = response.data;
                    if(data.code === 1){
                        swal.fire('Success', data.message, 'success');
                        self.getMyPromoRequests();
                    }else{
                        swal.fire('Oops!', data.message, 'error');
                    }
                });
            }*/
        },
        created() {
            this.getMyPromoRequests();
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
                        self.myPromotions = data;
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
if ($("#my-followers-list").length > 0) {
    new Vue({
        el: '#my-followers-list',
        data: {
            followers: {},
            user: {},
            searchFollowers: '',
            error: {
                message: '',
                show: false,
            }
        },
        watch: {
            searchFollowers: function (val) {
                this.getFollowers();
            }
        },
        methods: {
            /*------------------------------------------------------*/
            getFollowers(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                let sendData = {
                    search_followers: this.searchFollowers,
                    page: page
                };
                axios.post(apiurl + 'followers', sendData, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.followers = data.payload;
                    } else {
                        self.followers = data;
                    }
                });
            },
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            showUserDetails(user) {
                this.user = user;
            }
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
        },
        created() {
            this.getFollowers();
        }
    });
}
/*------------------------------------------------------*/
if ($("#orders-list").length > 0) {
    new Vue({
        el: '#orders-list',
        data: {
            orders: {},
            orderTickets: {},
            order: {},
            searchOrder: '',
            order_from_date: '',
            order_to_date: '',
            error: {
                message: '',
                show: false,
            }
        },
        watch: {
            searchOrder: function () {
                this.getOrders();
            },
            order_from_date: function () {
                this.getOrders();
            },
            order_to_date: function () {
                this.getOrders();
            }
        },
        methods: {
            /*--------------------------------------------------*/
            /*--------------------------------------------------*/
            getOrders(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                let sendData = {
                    search: this.searchOrder,
                    order_from_date: this.order_from_date,
                    order_to_date: this.order_to_date,
                    page: page
                };
                axios.post(apiurl + 'orders', sendData, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.orders = data.payload;
                    } else {
                        self.orders = data;
                    }
                })
            },
            /*--------------------------------------------------*/
            singleOrder(order) {
                this.order = order;
            }
            /*--------------------------------------------------*/
            /*--------------------------------------------------*/
            /*--------------------------------------------------*/
            /*--------------------------------------------------*/
            /*--------------------------------------------------*/
        },
        created() {
            this.getOrders();
        },
        beforeUpdate() {
            let self = this;
            $("#order_from_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    self.order_from_date = selected;
                    let dt = new Date(selected);
                    dt.setDate(dt.getDate() + 1);
                    $("#order_to_date").datepicker("option", "minDate", dt);
                },
                maxDate: 0
            });
            $("#order_to_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    if (self.order_from_date === '') {
                        self.order_to_date = '';
                        $("#order_to_date").val('');
                    } else {
                        let dt = new Date(selected);
                        self.order_to_date = selected;
                        dt.setDate(dt.getDate() - 1);
                    }
                },
                maxDate: 0
            });
        }
    });
}
/*------------------------------------------------------*/
if ($("#sales-list").length > 0) {
    new Vue({
        el: '#sales-list',
        data: {
            sales: {},
            events: {},
            event_id: '',
            errors: {
                message: '',
                show: false,
            }
        },
        watch: {
            event_id: function (val) {
                /*console.log(val);*/
                this.getSales(val);
            }
        },
        methods: {
            /*------------------------------------------------------*/
            getMyEvents() {
                let self = this;
                axios.post(apiurl + 'my-events-all', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;
                    } else {
                        self.events = {};
                    }
                });
            },
            /*------------------------------------------------------*/
            getSales(event_id) {
                let self = this;
                axios.post(apiurl + 'sales', {event_id: event_id}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.sales = data.payload;
                    } else {
                        self.sales = {};
                    }
                });
            }
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/

        },
        created() {
            this.getMyEvents();
        }
    });
}
/*------------------------------------------------------*/
/* organizer dashboard */
if ($("#organizer-dashboard").length > 0) {
    new Vue({
        el: '#organizer-dashboard',
        data: {
            events: {},
            ticketSales: {},
            recentSells: {},
            thisWeekGraph: [],
            lastWeekGraph: [],
        },
        methods: {
            /*------------------------------------------------------*/
            getUpcomingEvents(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let self = this;
                axios.get(apiurl + 'live-event-list?page=' + page, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.events = data.payload;
                    }
                });
            },
            /*------------------------------------------------------*/
            getTicketSales() {
                let self = this;
                axios.post(apiurl + 'ticket-sales', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.ticketSales = data.payload;
                    }
                });
            },
            /*------------------------------------------------------*/
            getRecentSells() {
                let self = this;
                axios.post(apiurl + 'recent-sells', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.recentSells = data.payload;
                        self.recentSells.thisWeek.forEach(function (val) {
                            val.total_quantity = 0;
                            val.order_tickets.forEach(function (value) {
                                val.total_quantity += value.quantity;
                            });
                        });
                        self.thisWeekGraph = self.recentSells.thisWeek.map(function (val) {
                            val.total_quantity = 0;
                            val.order_tickets.forEach(function (value) {
                                val.total_quantity += value.quantity;
                            });
                            return val.total_quantity;
                        });
                        self.lastWeekGraph = self.recentSells.lastWeek.map(function (val) {
                            val.total_quantity = 0;
                            val.order_tickets.forEach(function (value) {
                                val.total_quantity += value.quantity;
                            });
                            return val.total_quantity;
                        });
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
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/

        },
        created() {
            this.getUpcomingEvents();
            this.getTicketSales();
            this.getRecentSells();
        },
        mounted() {

        },
        updated() {
            let self = this;
            new Chartist.Line('#simple-line-chart', {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                series: [
                    self.thisWeekGraph,
                    self.lastWeekGraph
                    /*[1, 9, 7, 8, 5, 12, 5],
                    [2, 12, 9, 11, 7, 10, 3]*/
                ]
            }, {
                fullWidth: true,
                /*axisY: {
                    labelInterpolationFnc: function (value) {
                        return (value * 100);
                    }
                },*/
                chartPadding: {
                    right: 40
                },
                plugins: [
                    Chartist.plugins.tooltip()
                ]
            });
        }
    })
}
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
