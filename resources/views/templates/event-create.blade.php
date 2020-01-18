<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCX76RWTDMQxUEfW0xtiQmjVELZwBA-o6A&libraries=places"></script>
<div class="container" id="event-create">
    <div class="row justify-content-between">
        <div class="col-xl-12">
            <h3><b>Basic Information</b></h3>
            <div class="setting-billing">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="alert alert-danger text-center" v-if="error.dev" v-cloak>
                            <i class="icon fa fa-close"></i>
                            {{--@{{ error.message }}--}}
                            <li v-for="message in error.message">
                                <span v-for="index in message">@{{ index }}</span>
                            </li>
                        </div>

                        <div class="alert alert-success" v-cloak v-if="success.show">
                            <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                        </div>

                        <form action="#" enctype='multipart/form-data' @keydown.prevent.enter=""
                              id="create-event-form">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="event_title">Event Name *</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="event_title"
                                           v-model="event.title" placeholder="Short Name Preferred" required>
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.title }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="event_url" class="col-lg-4 col-form-label">Unique URL *</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="event_url" v-model="event.url"
                                           placeholder="Customize your event name" required>
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.url }}</p>
                                    <span>@{{ url + 'event/' + event.url }}</span>
                                </div>
                            </div>
                            {{--<div class="form-group row">
                                <label for="event_location" class="col-lg-4 col-form-label">Location*</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="event_location"
                                            v-model="event.location" required>
                                        <option value="">Select Location</option>
                                        <option value="United States">United States</option>
                                        <option value="Canada">Canada</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Nigeria">Nigeria</option>
                                    </select>
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.location }}</p>
                                </div>
                            </div>--}}
                            <hr>
                            <div class="form-group row">
                                <label for="searchTextField" class="col-lg-4 col-form-label">Address *</label>
                                <div class="col-lg-8 input_icon_parent">
                                    <input type="text" class="form-control" name="address"
                                           placeholder="Search Location" id="searchTextField" required
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
                                           v-model="event.addressTwo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xl-4">&nbsp;</div>
                                <label for="start_date" class="col-sm-2 col-form-label">Start Date *</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="start_date" required
                                           v-model="event.startDate" placeholder="YYYY-MM-DD">
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.startDate }}</p>
                                </div>
                                <label for="start_time" class="col-sm-2 col-form-label">From *</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" id="start_time" required
                                           v-model="event.startTime" placeholder="HH:MM">
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.startTime }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xl-4">&nbsp;</div>
                                <label for="end_date" class="col-sm-2 col-form-label">End Date *</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="end_date" required
                                           v-model="event.endDate" placeholder="YYYY-MM-DD">
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.endDate }}</p>
                                </div>
                                <label for="end_time" class="col-sm-2 col-form-label">To *</label>
                                <div class="col-lg-2">
                                    <input type="text" class="form-control" id="end_time" required
                                           v-model="event.endTime" placeholder="HH:MM">
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.endTime }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label"
                                       for="recuring_event">Recurring Event?</label>
                                <div class="col-lg-8 toggle-btn">
                                    <label class="switch">
                                        <input type="checkbox" name="event_recurring" id="recuring_event"
                                               v-model="event.isOccur"
                                               :false-value="0"
                                               :true-value="1">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">&nbsp;</label>
                                <div class="col-lg-8 rucuring" style="display: none;">
                                    <h4>Schedule Recurring Event</h4>
                                    <hr>
                                    <label class="col-form-label">How Often Does This Event Occur?</label>
                                    <select required class="form-control" v-model="event.occur">
                                        <option value="">Select</option>
                                        <option>Daily</option>
                                        <option>Once In A Week</option>
                                        <option>Once In A Month</option>
                                    </select>
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label for="occurrence_from_date" class="col-form-label">Occurs
                                                From</label>
                                            <input type="text" class="form-control" id="occurrence_from_date"
                                                   v-model="event.occurrenceFromDate" placeholder="YYYY-MM-DD">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="occurrence_to_date" class="col-form-label">Occurs
                                                Until</label>
                                            <input type="text" class="form-control" id="occurrence_to_date"
                                                   v-model="event.occurrenceToDate" placeholder="YYYY-MM-DD">
                                        </div>
                                        <div class="col-lg-4">
                                            <label class="col-form-label">Off The</label>
                                            <select class="form-control" required v-model="event.occurrenceOffDay">
                                                <option value="">Select Off Day</option>
                                                <option value="0">Same Day</option>
                                                <option value="1">Daily</option>
                                                <option value="2">Once In A Week</option>
                                                <option value="3">Once In A Month</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="occurrence_start_time" class="col-form-label">Start
                                                Time</label>
                                            <input type="text" class="form-control" id="occurrence_start_time"
                                                   v-model="event.occurrenceStartTime" placeholder="HH:MM">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="occurrence_end_time"
                                                   class="col-form-label">End Time</label>
                                            <input type="text" class="form-control" id="occurrence_end_time"
                                                   v-model="event.occurrenceEndTime" placeholder="HH:MM">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{--<div class="form-group row">
                                <label class="col-lg-4 col-form-label">Event image (Max 3 Images) *</label>
                                <div class="col-lg-8 toggle-btn">
                                    <input type="file" class="form-control" name="event_image"
                                           id="event_image" @change="onImageChange" multiple required>
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.images }}</p>
                                </div>
                            </div>--}}



                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Event image (Max 3 Images) *</label>
                                <div class="col-lg-8 toggle-btn">
                                    <div id="demo2"></div>
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.images }}</p>
                                </div>
                            </div>




                            <div class="form-group row">
                                <label for="event_description"
                                       class="col-lg-4 col-form-label">Description *</label>
                                <div class="col-lg-8">
                                        <textarea class="text_area" placeholder="Enter event description"
                                                  id="event_description" v-model="event.description" required></textarea>
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
                                            <tr v-for="(row, index) in rows">
                                                <td>
                                                    <select class="form-control"
                                                            v-model="event.event_type[index]"
                                                            @change="disableAmountIfFree(event.event_type[index], index)"
                                                            required >
                                                        <option value="">Select Ticket Type</option>
                                                        <option value="1">Free</option>
                                                        <option value="2">Paid</option>
                                                        <option value="3">Donation</option>
                                                    </select>
                                                    <p class="error" v-if="error.show" v-cloak>
                                                        @{{ error.event_type }}</p>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                           placeholder="QTY."
                                                           v-model="event.quantity[index]"
                                                    >
                                                    <p class="error" v-if="error.show" v-cloak>
                                                        @{{ error.quantity }}</p>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                           v-model="event.ticket_type[index]"
                                                    >
                                                    <p class="error" v-if="error.show" v-cloak>
                                                        @{{ error.ticket_type }}</p>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                           placeholder="Amount" required
                                                           v-model="event.price[index]"
                                                           :disabled="event.disableAmount[index]"
                                                    >
                                                    <p class="error" v-if="error.show" v-cloak>
                                                        @{{ error.price }}</p>
                                                </td>
                                                <td style="text-align: center;vertical-align: inherit;">
                                                    <a class="btn-remove" v-if="index > 0">
                                                        <i class="fa fa-trash fa-2x" aria-hidden="true"
                                                           @click="removeRow(index, this)"></i>
                                                    </a>&nbsp;
                                                    <a class="btn-copy">
                                                        <i class="fa fa-plus fa-2x" aria-hidden="true"
                                                           @click="addRow"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="checkbox">
                                            <input type="checkbox"
                                                   v-model="event.showAvailableTicketsNo"
                                                   id="show_no_of_available_tickets"
                                                   :false-value="0"
                                                   :true-value="1" />
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
                                        <input type="checkbox" v-model="event.isPrivate"
                                               id="is_private"
                                               :false-value="0"
                                               :true-value="1" />
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
                                    <select required class="form-control"
                                            v-model="event.selectCategory" @change="getSubCategories">
                                        <option value="">Select Category</option>
                                        <option v-for="(item, index) in event.categories"
                                                :value="index">@{{ item }}</option>
                                    </select>
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.category }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Event Sub-Category</label>
                                <div class="col-lg-8 toggle-btn">
                                    <select class="form-control" v-model="event.selectSubCategory">
                                        <option value="">Select Sub-Category</option>
                                        <option v-for="(item, index) in event.subCategories"
                                                :value="index">@{{ item }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Select Tags</label>
                                <div class="col-lg-8 toggle-btn">
                                    <vue-multiselect
                                            v-model="event.selectTags" tag-placeholder="Add this as new tag"
                                            placeholder="Search or add a tag" label="tag"
                                            track-by="tag" :options="event.tags" :multiple="true">
                                    </vue-multiselect>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Refund Policy</label>
                                <div class="col-lg-8 toggle-btn">
                                    <label class="checkbox-inline">
                                        <input type="radio" value="1"
                                               checked v-model="event.refundPolicy"> No Refund
                                    </label>&nbsp;
                                    <label class="checkbox-inline">
                                        <input type="radio" value="2"
                                               v-model="event.refundPolicy"> A Day Before Event
                                    </label>&nbsp;
                                    <label class="checkbox-inline">
                                        <input type="radio" value="3"
                                               v-model="event.refundPolicy"> 1 Week Before Event
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Ticket Fees</label>
                                <div class="col-lg-8 toggle-btn">
                                    <label class="checkbox-inline">
                                        <input type="radio" value="1" v-model="event.ticketFees">
                                        Charge Attendee
                                    </label> &nbsp;
                                    <label class="checkbox-inline">
                                        <input type="radio" value="2" v-model="event.ticketFees">
                                        Charge Organizer
                                    </label> &nbsp;
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="other_information"
                                       class="col-lg-4 col-form-label">Other Information *</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="other_information"
                                           placeholder="Other Information About Your Event..."
                                           v-model="event.otherInformation" required>
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.otherInformation }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">&nbsp;</label>
                                <div class="col-lg-8">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="1" v-model="event.additionalInformation">
                                        Alcohol
                                    </label> &nbsp;
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="2" v-model="event.additionalInformation">
                                        ID card
                                    </label> &nbsp;
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="3" v-model="event.additionalInformation">
                                        Children
                                    </label> &nbsp;
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="4" v-model="event.additionalInformation">
                                        18+
                                    </label> &nbsp;
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="5" v-model="event.additionalInformation">
                                        Parking
                                    </label> &nbsp;
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="6" v-model="event.additionalInformation">
                                        Wheelchair
                                    </label>
                                    &nbsp;
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="7" v-model="event.additionalInformation">
                                        Casual
                                    </label> &nbsp;
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="8" v-model="event.additionalInformation">
                                        Corporate Dressing
                                    </label> &nbsp;
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="9" v-model="event.additionalInformation">
                                        Early Check-in
                                    </label> &nbsp;
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">Event Status</label>
                                <div class="col-lg-8 toggle-btn">
                                    <select required class="form-control" v-model="event.status">
                                        <option value="1">Active</option>
                                        <option value="0">Draft</option>
                                    </select>
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.status }}</p>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-danger" @click.prevent="createEvent">Create Event</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
