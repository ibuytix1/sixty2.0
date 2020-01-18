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
Vue.component('vue-multiselect', window.VueMultiselect.default);
// apiurl = 'http://localhost/decipher/api/organizer/';
// baseurl = 'http://localhost/decipher/api/';
// weburl = 'http://localhost/decipher/organizer/';
// imageurl = 'http://localhost/decipher/public/upload/event_image/';
// basehomeurl = 'http://localhost/decipher/';

apiurl = 'https://thanksgivingdayusa.com/d1/dev/decipher/api/organizer/';
baseurl = 'https://thanksgivingdayusa.com/d1/dev/decipher/api/';
weburl = 'https://thanksgivingdayusa.com/d1/dev/decipher/organizer/';
imageurl = 'https://thanksgivingdayusa.com/d1/dev/decipher/public/upload/event_image/';
basehomeurl = 'https://thanksgivingdayusa.com/d1/dev/decipher/';
if ($("#event-create").length > 0) {
    new Vue({
        el: '#event-create',
        data: {
            event: {
                title: '',
                url: '',
                location: '',
                address: '',
                addressTwo: '',
                startDate: '',
                startTime: '',
                endDate: '',
                endTime: '',
                isOccur: 0,
                occur: '',
                occurrenceStartTime: '',
                occurrenceEndTime: '',
                occurrenceOffDay: '',
                occurrenceFromDate: '',
                occurrenceToDate: '',
                description: '',

                event_type: [],
                quantity: [],
                ticket_type: [],
                price: [],
                disableAmount: [],

                showAvailableTicketsNo: 0,
                showTest: false,
                isPrivate: 0,
                selectCategory: '',
                selectSubCategory: '',
                categories: null,
                subCategories: null,
                refundPolicy: '1',
                ticketFees: '1',
                additionalInformation: [],
                otherInformation: '',
                status: 1,
                cityLat: '',
                cityLng: '',
                selectTags: [],
                tags: [],
            },
            error: {
                message: '',
                images: '',
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
                category: '',
                quantity: '',
                price: '',
                event_type: '',
                ticket_type: '',
                dev: false,
                show: false
            },
            success: {
                message: '',
                show: false
            },
            images: [],
            rows: [{}],
            autocomplete: {},
        },
        computed: {
            url: function () {
                this.event.url = this.sanitizeTitle(this.event.title);
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
            onImageChange(e) {
                // console.log(e.target.files);
                let self = this;
                this.images = [];
                let files = e.target.files || e.dataTransfer.files;
                if (files.length > 3) {
                    this.error.images = 'Images cannot be more then 3';
                    this.error.show = true;
                    $("#event_image").val(null);
                } else {
                    this.error.images = '';
                    for (let i = files.length - 1; i >= 0; i--) {
                        this.images.push(files[i]);
                    }
                }
            },
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            createEvent() {
                this.event.description = CKEDITOR.instances['event_description'].getData();
                if (this.validateForm()) {
                    let formData = new FormData();
                    if (this.images.length > 0) {
                        for (let i = 0; i < this.images.length; i++) {
                            let image = this.images[i];
                            formData.append('event_image[]', image);
                        }
                    }

                    formData.append('event_title', this.event.title);
                    formData.append('event_url', this.event.url);
                    formData.append('event_image', this.image);
                    formData.append('event_location', this.event.location);
                    formData.append('address', this.event.address);
                    formData.append('start_date', this.event.startDate);
                    formData.append('start_time', this.event.startTime);
                    formData.append('end_date', this.event.endDate);
                    formData.append('end_time', this.event.endTime);
                    formData.append('event_description', this.event.description);
                    formData.append('category_id', this.event.selectCategory);
                    formData.append('subcategory_id', this.event.selectSubCategory);
                    formData.append('other_information', this.event.otherInformation);
                    formData.append('aditional_information', this.event.additionalInformation);
                    formData.append('address_2', this.event.addressTwo);
                    formData.append('is_recurring', this.event.isOccur);
                    formData.append('event_occurrence_type', this.event.occur);
                    formData.append('occurrence_from_date', this.event.occurrenceFromDate);
                    formData.append('show_no_of_available_tickets', this.event.showAvailableTicketsNo);
                    formData.append('occurence_to_date', this.event.occurrenceToDate);
                    formData.append('occurrence_start_time', this.event.occurrenceStartTime);
                    formData.append('occurrence_off_the_day', this.event.occurrenceOffDay);
                    formData.append('occurrence_end_time', this.event.occurrenceEndTime);
                    formData.append('event_status', this.event.status);
                    formData.append('refund_policy', this.event.refundPolicy);
                    formData.append('ticket_fees', this.event.ticketFees);
                    formData.append('is_private', this.event.isPrivate);
                    this.event.selectTags.forEach(function (val, index) {
                        formData.append('tags[' + index + ']', val.id);
                    });

                    for (let i = 0; i < this.event.event_type.length; i++) {
                        formData.append('event_type[' + i + ']', this.event.event_type[i]);
                        formData.append('ticket_type[' + i + ']', this.event.ticket_type[i]);
                        formData.append('price[' + i + ']', this.event.price[i]);
                        formData.append('quantity[' + i + ']', this.event.quantity[i]);
                    }

                    formData.append('cityLat', this.event.cityLat);
                    formData.append('cityLng', this.event.cityLng);

                    let self = this;
                    axios.post(apiurl + 'add-event', formData, header).then(function (response) {
                        let data = response.data;
                        self.error = {};
                        if (data.code === 1) {
                            self.event = {
                                title: '',
                                url: '',
                                location: '',
                                address: '',
                                addressTwo: '',
                                startDate: '',
                                startTime: '',
                                endDate: '',
                                endTime: '',
                                isOccur: 0,
                                occur: '',
                                occurrenceStartTime: '',
                                occurrenceEndTime: '',
                                occurrenceOffDay: '',
                                occurrenceFromDate: '',
                                occurrenceToDate: '',
                                description: '',

                                event_type: [],
                                quantity: [],
                                ticket_type: [],
                                price: [],

                                showAvailableTicketsNo: 0,
                                showTest: false,
                                isPrivate: 0,
                                selectCategory: '',
                                selectSubCategory: '',
                                selectTags: [],
                                categories: null,
                                subCategories: null,
                                refundPolicy: '1',
                                changeAttendee: '1',
                                additionalInformation: [],
                                otherInformation: '',
                                status: 0,
                                cityLat: '',
                                cityLng: '',
                                tags: [],
                            };
                            CKEDITOR.instances['event_description'].setData('');
                            self.images = [];
                            self.getCategories();
                            self.getTags();
                            swal.fire({
                                title: 'Success',
                                text: data.message,
                                type: 'success',
                                allowOutsideClick: false
                            }).then(function (val) {
                                window.location = weburl + 'live-events';
                            });
                            /*self.success.message = data.message;
                            self.success.show = true;*/
                            self.error.message = '';
                            self.error.show = false;
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
            getSubCategories() {
                /* get all subcategory for selected category */
                if (this.event.selectCategory !== '') {
                    let sendData = {
                        category_id: this.event.selectCategory,
                    };
                    let self = this;
                    axios.post(apiurl + 'subcategory-list', sendData, header).then(function (response) {
                        let data = response.data;
                        if (data.code !== 1) {
                            self.event.subCategories = '';
                            self.event.selectSubCategory = '';
                            // console.log(self.event.subCategories);
                        } else {
                            self.event.subCategories = data.payload;
                        }
                    });
                }
            },
            /*------------------------------------------------------*/
            /* form validation */
            validateForm() {
                if (!this.event.title || !this.event.url ||
                    !this.event.location || !this.event.address ||
                    !this.event.startDate || !this.event.startTime ||
                    !this.event.endDate || !this.event.endTime ||
                    !this.event.description || !this.event.selectCategory
                    || this.event.ticket_type.length < 1
                    || this.event.event_type.length < 1 || this.event.price.length < 1
                    || this.event.quantity.length < 1 || this.images.length < 0
                ) {
                    if (this.images.length <= 0) {
                        this.error.images = 'Image field cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.images = '';
                    }
                    if (!this.event.title) {
                        this.error.title = 'Event Name cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.title = '';
                    }
                    if (!this.event.url) {
                        this.error.url = 'Event unique url cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.url = '';
                    }
                    if (!this.event.location) {
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
                    if (!this.event.startDate) {
                        this.error.startDate = 'Event Start Date cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.startDate = '';
                    }
                    if (!this.event.startTime) {
                        this.error.startTime = 'Event Start Time cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.startTime = '';
                    }
                    if (!this.event.endDate) {
                        this.error.endDate = 'Event End Date cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.endDate = '';
                    }
                    if (!this.event.endTime) {
                        this.error.endTime = 'Event End Time cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.endTime = '';
                    }
                    if (!this.event.description) {
                        this.error.description = 'Event Event Description cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.description = '';
                    }
                    if (!this.event.status) {
                        this.error.status = 'Event Status cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.status = '';
                    }

                    if (!this.event.selectCategory) {
                        this.error.category = 'Event Category cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.category = '';
                    }


                    if (this.event.ticket_type.length < 1) {
                        this.error.ticket_type = 'Ticket type cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.ticket_type = '';
                    }
                    if (this.event.event_type.length < 1) {
                        this.error.event_type = 'Event type cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.event_type = '';
                    }

                    if (this.event.price.length < 1) {
                        this.error.price = 'Price cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.price = '';
                    }

                    if (this.event.quantity.length < 1) {
                        this.error.quantity = 'Quantity cannot be empty';
                        this.error.show = true;
                    } else {
                        this.error.quantity = '';
                    }

                    window.scrollTo(0, 0);
                    return false;
                } else {
                    return true;
                }
            },
            /*------------------------------------------------------*/
            addRow: function () {
                /*console.log(this.rows);*/
                this.rows.push({});
            },
            /*------------------------------------------------------*/
            removeRow(index, row) {
                this.rows.splice(row, 1);
                this.event.quantity.splice(index, 1);
                this.event.ticket_type.splice(index, 1);
                this.event.event_type.splice(index, 1);
                this.event.price.splice(index, 1);
                this.event.disableAmount.splice(index, 1);
            },
            /*------------------------------------------------------*/
            getCategories: function () {
                let self = this;
                axios.post(apiurl + 'category-list', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.event.categories = data.payload;
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
                this.event.url = slug;
            },
            /*------------------------------------------------------*/
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
            /*------------------------------------------------------*/
            getTags() {
                let self = this;
                axios.post(baseurl + 'get-tags', {}, header).then(function (response) {
                    let data = response.data;
                    if (data.code === 1) {
                        self.event.tags = data.payload;
                    }
                });
            }
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
            /*------------------------------------------------------*/
        },
        mounted() {
            let self = this;
            /* get all category for event */
            this.getCategories();
            this.getTags();
            Vue.nextTick(function () {
                CKEDITOR.replace('event_description');
            });

            this.autocomplete = new google.maps.places.Autocomplete((this.$refs.eventAddressField));

            // jquery multiple image upload
            $("#demo2").spartanMultiImagePicker({
                fieldName: 'fileUpload[]',
                maxCount : 3,
                rowHeight : '200px',
                allowedExt: 'png|jpg|jpeg',
                maxFileSize: 567468,

                onAddRow: function() {
                    $(".fa-times").removeClass("fas").addClass("fa");
                },

                onRenderedPreview: function() {
                    let e = $('.spartan_image_input');
                    e.each(function(i, value){
                        if(value.files.length > 0){
                            self.images[i] = value.files[0];
                        }
                    });
                },

                onRemoveRow: function() {
                    let e = $('.spartan_image_input');
                    e.each(function(i, value){
                        if(value.files.length === 0){
                            self.images.splice(i, 1);
                        }
                    });
                },

                onExtensionErr: function(index, file) {
                    self.error.images = 'Only upload JPG or PNG images';
                    self.error.show = true;
                },
                onSizeErr: function(index, file) {
                    self.error.images = 'Size cannot be more then 500kb';
                    self.error.show = true;
                }
            });
        },
        beforeUpdate() {
            this.sanitizeTitleEventUrl(this.event.url);
            let self = this;
            // date picker for selecting start and end date.
            $("#start_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    self.event.startDate = selected;
                    let dt = new Date(selected);
                    /*dt.setDate(dt.getDate() + 1);*/
                    dt.setDate(dt.getDate());
                    $("#end_date").datepicker("option", "minDate", dt);
                    self.event.endDate = selected;
                    self.error.startDate = '';
                },
                minDate: 0
            });
            $("#end_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    if (self.event.startDate === '') {
                        self.event.endDate = '';
                        $("#end_date").val('');
                        self.error.endDate = 'Please select start date first';
                        self.error.show = true;
                    } else {
                        let dt = new Date(selected);
                        self.event.endDate = selected;
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
                    self.event.startTime = timepicker.format(time);
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
                    self.event.endTime = timepicker.format(time);
                },
            });
            // date picker for recurring event.
            $("#occurrence_from_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    self.event.occurrenceFromDate = selected;
                    let dt = new Date(selected);
                    dt.setDate(dt.getDate() + 1);
                    $("#occurrence_to_date").datepicker("option", "minDate", dt);
                    self.error.occurrenceFromDate = '';
                },
                minDate: 0
            });
            $("#occurrence_to_date").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function (selected) {
                    if (self.event.occurrenceFromDate === '') {
                        self.event.occurrenceToDate = '';
                        $("#occurrence_to_date").val('');
                        self.error.occurrenceToDate = 'Please select start date first';
                        self.error.show = true;
                    } else {
                        let dt = new Date(selected);
                        self.event.occurrenceToDate = selected;
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
                    self.event.occurrenceStartTime = timepicker.format(time);
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
                    self.event.occurrenceEndTime = timepicker.format(time);
                },
            });
        },
        created() {
            let self = this;
            Vue.nextTick(function () {
                let input = self.$refs.eventAddressField;
                self.autocomplete = new google.maps.places.Autocomplete(input);
            });
        },
    });
}