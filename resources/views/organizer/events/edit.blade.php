<div class="form-group row">
    <label class="col-lg-4 col-form-label" for="event_title">Event Name *</label>
    <div class="col-lg-8">
        <input type="text" class="form-control" id="event_title"
               v-model="event.event_title" placeholder="Short Name Preferred" required>
        <p class="error" v-if="error.show" v-cloak>@{{ error.event_title }}</p>
    </div>
</div>
<div class="form-group row">
    <label for="event_url" class="col-lg-4 col-form-label">Unique URL *</label>
    <div class="col-lg-8">
        <input type="text" class="form-control" id="event_url" v-model="event.event_url"
               placeholder="Type Slug For Event" required>
        <p class="error" v-if="error.show" v-cloak>@{{ error.url }}</p>
        <span>@{{ url + 'event/' + event.event_url }}</span>
    </div>
</div>
{{--<div class="form-group row">
    <label for="event_location" class="col-lg-4 col-form-label">Location Name*</label>
    <div class="col-lg-8">
        <select class="form-control" id="event_location"
                v-model="event.event_location" required>
            <option value="">Select Location</option>
            <option value="United States">United States</option>
            <option value="Canada">Canada</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Ghana">Ghana</option>
            <option value="Nigeria">Nigeria</option>
        </select>
        --}}{{--<input type="text" class="form-control" id="event_location"
               placeholder="Venue Name, Rm, Apt." required
               v-model="event.event_location">--}}{{--
        <p class="error" v-if="error.show" v-cloak>@{{ error.location }}</p>
    </div>
</div>--}}
<hr>
<div class="form-group row">
    <label for="searchTextField" class="col-lg-4 col-form-label">Address *</label>
    <div class="col-lg-8 input_icon_parent">
        <input type="text" class="form-control" name="address"
               placeholder="Search Location" id="eventAddressField" required
               ref="eventAddressField" v-model="event.address" @change="addressChanged">
        <i class="fa fa-crosshairs input_icon_child" aria-hidden="true"></i>
        <p class="error" v-if="error.show" v-cloak>@{{ error.address }}</p>
    </div>
    <input type="hidden" id="cityLat" name="cityLat"/>
    <input type="hidden" id="cityLng" name="cityLng"/>
</div>
<div class="form-group row">
    <label for="address_2" class="col-lg-4 col-form-label">Address 2</label>
    <div class="col-lg-8 input_icon_parent">
        <input type="text" class="form-control" id="address_2" placeholder=""
               v-model="event.address_2">
    </div>
</div>
<div class="form-group row">
    <div class="col-xl-4">&nbsp;</div>
    <label for="start_date" class="col-sm-2 col-form-label">Start Date *</label>
    <div class="col-sm-2">
        <input type="text" class="form-control" id="start_date" required
               v-model="event.start_date">
        <p class="error" v-if="error.show" v-cloak>@{{ error.startDate }}</p>
    </div>
    <label for="start_time" class="col-sm-2 col-form-label">From *</label>
    <div class="col-lg-2">
        <input type="text" class="form-control" id="start_time" required
               v-model="event.start_time">
        <p class="error" v-if="error.show" v-cloak>@{{ error.startTime }}</p>
    </div>
</div>

<div class="form-group row">
    <div class="col-xl-4">&nbsp;</div>
    <label for="end_date" class="col-sm-2 col-form-label">End Date *</label>
    <div class="col-sm-2">
        <input type="text" class="form-control" id="end_date" required
               v-model="event.end_date">
        <p class="error" v-if="error.show" v-cloak>@{{ error.endDate }}</p>
    </div>
    <label for="end_time" class="col-sm-2 col-form-label">To *</label>
    <div class="col-lg-2">
        <input type="text" class="form-control" id="end_time" required
               v-model="event.end_time">
        <p class="error" v-if="error.show" v-cloak>@{{ error.endTime }}</p>
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-4 col-form-label" for="recuring_event">
        Recurring Event?</label>
    <div class="col-lg-8 toggle-btn">
        <label class="switch">
            <input type="checkbox" name="event_recurring" id="recuring_event"
                   v-model="event.is_recurring"
                   :false-value="0"
                   :true-value="1">
            <span class="slider round"></span>
        </label>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-4 col-form-label">&nbsp;</label>
    <div class="col-lg-8 rucuring" v-if="event.is_recurring">
        <h4>Schedule Recurring Event</h4>
        <hr>
        <label class="col-form-label">How Often Does This Event Occur?</label>
        <select required class="form-control" v-model="event.event_occurrence_type">
            <option value="">Select</option>
            <option>Daily</option>
            <option>Once In A Week</option>
            <option>Once In A Month</option>
        </select>
        <p class="error" v-if="error.show" v-cloak>
            @{{ error.event_occurrence_type }}</p>
        <div class="form-group row">
            <div class="col-lg-4">
                <label for="occurrence_from_date" class="col-form-label">Occurs
                    From</label>
                <input type="text" class="form-control" id="occurrence_from_date"
                       v-model="event.occurrence_from_date">
                <p class="error" v-if="error.show" v-cloak>
                    @{{ error.occurrence_from_date }}</p>
            </div>
            <div class="col-lg-4">
                <label for="occurrence_start_time" class="col-form-label">Start
                    Time</label>
                <input type="text" class="form-control" id="occurrence_start_time"
                       v-model="event.occurrence_start_time">
                <p class="error" v-if="error.show" v-cloak>
                    @{{ error.occurrence_start_time }}</p>
            </div>
            <div class="col-lg-4">
                <label class="col-form-label">Off The</label>
                <select class="form-control" required
                        v-model="event.occurrence_off_the_day">
                    <option value="">Select Off Day</option>
                    <option value="0">Same Day</option>
                    <option value="1">Daily</option>
                    <option value="2">Once In A Week</option>
                    <option value="3">Once In A Month</option>
                </select>
                <p class="error" v-if="error.show" v-cloak>
                    @{{ error.occurrence_off_the_day }}</p>
            </div>

            <div class="col-lg-4">
                <label for="occurrence_to_date" class="col-form-label">Occurs
                    Until</label>
                <input type="text" class="form-control" id="occurrence_to_date"
                       v-model="event.occurence_to_date">
                <p class="error" v-if="error.show" v-cloak>
                    @{{ error.occurence_to_date }}</p>
            </div>
            <div class="col-lg-4">
                <label for="occurrence_end_time"
                       class="col-form-label">End Time</label>
                <input type="text" class="form-control" id="occurrence_end_time"
                       v-model="event.occurrence_end_time">
                <p class="error" v-if="error.show" v-cloak>
                    @{{ error.occurrence_end_time }}</p>
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-4 col-form-label">Event images </label>
    <div class="img-wrap" v-for="(image, index) in event.r_e_l__event__image">
        <img class="mr-3 img-fluid event-image" :src="imageUrl + image.image_name"
             alt="Card image">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-4 col-form-label">Event image (Max 3 Images) *</label>
    <div class="col-lg-8 toggle-btn">
        <input type="file" class="form-control" name="event_image"
               id="event_image" @change="onImageChange" multiple required>
        <p class="error" v-if="error.show" v-cloak>@{{ error.images }}</p>
    </div>
</div>


{{--<div class="form-group row">
    <label class="col-lg-4 col-form-label">Event image (Max 3 Images) *</label>
    <div class="col-lg-8 toggle-btn">
        <div id="demo2"></div>
        <p class="error" v-if="error.show" v-cloak>@{{ error.images }}</p>
    </div>
</div>--}}

<div class="form-group row">
    <label for="event_description" class="col-lg-4 col-form-label">Description *</label>
    <div class="col-lg-8">
        <textarea class="text_area" placeholder="Enter event description"
            id="event_description" v-model="event.event_description"
            required></textarea>
        <p class="error" v-if="error.show" v-cloak>@{{ error.description }}</p>
    </div>
</div>

<div class="form-group row">
    <div class="col-lg-12">
        <div class="table-wrapper table-responsive col-sm-12">
            <!--Table-->
            <table class="table table-hover mb-0">
                <!--Table head-->
                <thead>
                <tr>
                    <th class="th-lg">Event Type *</th>
                    <th class="th-lg">Quantity *</th>
                    <th class="th-lg">Ticket Type *</th>
                    <th class="th-lg">Price *</th>
                    <th class="th-lg">Add/ Delete</th>
                </tr>
                </thead>
                <!--Table head-->
                <!--Table body-->
                <tbody>
                <tr class="example-2" v-for="(ticket, index) in event.r_e_l_event_ticket">
                    <td>
                        <select class="form-control"
                                {{--@change="disableAmountIfFree(ticket.event_type, index)"--}}
                                required v-model="ticket.event_type">
                            <option value="">Select</option>
                            <option value="1">Free</option>
                            <option value="2">Paid</option>
                            <option value="3">Donation</option>
                        </select>
                        <p class="error" v-if="error.show" v-cloak>
                            @{{ error.event_type }}</p>
                    </td>
                    <td>
                        <input type="number" class="form-control"
                               v-model="ticket.quantity"
                               placeholder="QTY.">
                        <p class="error" v-if="error.show" v-cloak>
                            @{{ error.quantity }}</p>
                    </td>
                    <td>
                        <input type="text" class="form-control"
                               v-model="ticket.ticket_type">
                        <p class="error" v-if="error.show" v-cloak>
                            @{{ error.ticket_type }}</p>
                    </td>
                    <td>
                        <input type="number" class="form-control"
                               placeholder="Amount" v-model="ticket.price"
{{--                               :disabled="event.disableAmount[index]"--}}
                               required>
                        <p class="error" v-if="error.show" v-cloak>
                            @{{ error.price }}</p>
                    </td>
                    <td style="text-align: center;vertical-align: inherit;">
                        <a class="btn-remove">
                            <i class="fa fa-trash" aria-hidden="true"
                               v-if="index > 0"
                               @click="removeRow(index)"></i>
                        </a>&nbsp;
                        <a class="btn-copy">
                            <i class="fa fa-plus" aria-hidden="true"
                               @click="addRow"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="checkbox">
                <input type="checkbox"
                       v-model="event.show_no_of_available_tickets"
                       id="show_no_of_available_tickets"
                       :false-value="0"
                       :true-value="1"/>
                <label for="show_no_of_available_tickets">
                    Show Number Of Remaining Tickets
                </label>
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-4 col-form-label" for="is_private">Private Event?</label>
    <div class="col-lg-1 toggle-btn">
        <label class="switch">
            <input type="checkbox" v-model="event.is_private"
                   id="is_private"
                   :false-value="0"
                   :true-value="1"/>
            <span class="slider round"></span>
        </label>
    </div>
    <div class="col-lg-7">
        <br>
        <p>Event URL must Be Shared With Attendees.</p>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-4 col-form-label">Event Category *</label>
    <div class="col-lg-8 toggle-btn">
        <select required class="form-control" v-model="event.category_id"
                @change="getSubCategories">
            <option v-for="(item, index) in categories" :value="index">@{{ item
                }}
            </option>
        </select>
        <p class="error" v-if="error.show" v-cloak>@{{ error.category }}</p>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-4 col-form-label">Event Sub-Category</label>
    <div class="col-lg-8 toggle-btn">
        <select class="form-control" v-model="event.subcategory_id">
            <option v-if="!subCategories" :value="event.subcategory_id = ''">
                No Sub-Category Found
            </option>
            <option v-for="(item, index) in subCategories" :value="index">
                @{{ item }}
            </option>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-4 col-form-label">Select Tags</label>
    <div class="col-lg-8 toggle-btn" v-if="event.tags" v-cloak>
        <vue-multiselect
                v-model="event.tags" tag-placeholder="Add this as new tag"
                placeholder="Search or add a tag" label="tag"
                track-by="tag" :options="tags" :multiple="true">
        </vue-multiselect>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-4 col-form-label">Refund Policy</label>
    <div class="col-lg-8 toggle-btn">
        <label class="checkbox-inline">
            <input type="radio" value="1"
                   checked v-model="event.refund_policy"> No Refund
        </label>&nbsp;
        <label class="checkbox-inline">
            <input type="radio" value="2"
                   v-model="event.refund_policy"> A Day Before Event
        </label>&nbsp;
        <label class="checkbox-inline">
            <input type="radio" value="3"
                   v-model="event.refund_policy"> 1 Week Before Event
        </label>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-4 col-form-label">Ticket Fees</label>
    <div class="col-lg-8 toggle-btn">
        <label class="checkbox-inline">
            <input type="radio" value="1" v-model="event.ticket_fees">
            Charge Attendee
        </label> &nbsp;
        <label class="checkbox-inline">
            <input type="radio" value="2" v-model="event.ticket_fees">
            Charge Organizer
        </label> &nbsp;
    </div>
</div>
<div class="form-group row">
    <label for="other_information" class="col-lg-4 col-form-label">Other Information
        *</label>
    <div class="col-lg-8">
        <input type="text" class="form-control" id="other_information"
               placeholder="Other Information About Your Event..."
               v-model="event.other_information" required>
        <p class="error" v-if="error.show" v-cloak>@{{ error.otherInformation }}</p>
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-4 col-form-label">&nbsp;</label>
    <div class="col-lg-8">
        <label class="checkbox-inline">
            <input type="checkbox" value="1" v-model="additional_information">
            Alcohol
        </label> &nbsp;
        <label class="checkbox-inline">
            <input type="checkbox" value="2" v-model="additional_information">
            ID card
        </label> &nbsp;
        <label class="checkbox-inline">
            <input type="checkbox" value="3" v-model="additional_information">
            Children
        </label> &nbsp;
        <label class="checkbox-inline">
            <input type="checkbox" value="4" v-model="additional_information">
            18+
        </label> &nbsp;
        <label class="checkbox-inline">
            <input type="checkbox" value="5" v-model="additional_information">
            Parking
        </label> &nbsp;
        <label class="checkbox-inline">
            <input type="checkbox" value="6" v-model="additional_information">
            Wheelchair
        </label>
        &nbsp;
        <label class="checkbox-inline">
            <input type="checkbox" value="7" v-model="additional_information">
            Casual
        </label> &nbsp;
        <label class="checkbox-inline">
            <input type="checkbox" value="8" v-model="additional_information">
            Corporate Dressing
        </label> &nbsp;
        <label class="checkbox-inline">
            <input type="checkbox" value="9" v-model="additional_information">
            Early Check-in
        </label> &nbsp;
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-4 col-form-label">Event Status</label>
    <div class="col-lg-8 toggle-btn">
        <select required class="form-control" v-model="event.event_status">
            <option value="0">Draft</option>
            <option value="1">Active</option>
        </select>
        <p class="error" v-if="error.show" v-cloak>@{{ error.status }}</p>
    </div>
</div>