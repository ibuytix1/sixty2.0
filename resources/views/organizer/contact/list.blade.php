@extends('organizer.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Contacts</h1>
                </div>
                <div class="col-7">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Contacts</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" id="contact-list">
        <div class="row justify-content-between">
            <div class="col-xl-8">
                <div class="alert alert-success" v-cloak v-if="success.show">
                    <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="input-group custom-search">
                            <input type="text" class="form-control" placeholder="Search Contacts"
                                   v-model="keywords" @keyup.enter="searchContacts">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control custom-dropdown" id="sort_by"
                                v-model="sortBy" @change.prevent="sortContacts">
                            <option selected="selected" value="">Sort</option>
                            <option value="byName">Name A-Z</option>
                            <option value="byEmail">Email A-Z</option>
                            <option value="byDate">Date Added</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="table-wrapper table-responsive col-sm-12">
                    <!--Table-->
                    <table class="table table-hover mb-0">
                        <!--Table head-->
                        <thead>
                        <tr>
                            <th>
                                <input class="form-check-input" type="checkbox" v-model="allSelected"
                                       id="select-all">
                                <label class="form-check-label" for="select-all">Select</label>
                            </th>
                            <th class="th-lg">First Name</th>
                            <th class="th-lg">Last Name</th>
                            <th class="th-lg">Email Address</th>
                            <th class="th-lg">Date Added</th>
                            <th class="th-lg">Actions</th>
                        </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                        {{-- contact loop --}}
                        <tr v-if="contacts.data" v-cloak v-for="contact in contacts.data">
                            <th scope="row">
                                <input class="form-check-input checkbox" type="checkbox"
                                       v-model="emailContact" :value="contact.id" @click="select">
                            </th>
                            <td>@{{ contact.first_name }}</td>
                            <td>@{{ contact.last_name }}</td>
                            <td>@{{ contact.email }}</td>
                            <td>@{{ contact.created_at | eventCreatedDate }}</td>
                            <td>
                                <a href="#" @click.prevent="editContact(contact)"
                                   data-toggle="modal"
                                   data-target="#edit-contact-modal">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" data-toggle="modal" data-target="#send-email-contact"
                                   @click.prevent="showSendMail(contact.id)">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                </a>
                                <a href="#" @click.prevent="deleteContact(contact.id)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        {{-- if no record found --}}
                        <tr v-if="contacts.code == 0" class="text-center">
                            <td colspan="8">@{{ contacts.message }}</td>
                        </tr>
                        {{-- // contact loop --}}
                        </tbody>
                    </table>
                </div>
                <div class="pagination" style="float:right; margin-top: 10px;">
                    <span v-if="!contactsEvent">
                        <pagination :data="contacts" @pagination-change-page="getContacts"></pagination>
                    </span>
                </div>
                <div class="pagination" style="float:right; margin-top: 10px;">
                    <span v-if="contactsEvent">
                        <pagination :data="contacts" @pagination-change-page="getContactsByEvent"></pagination>
                    </span>
                </div>
                <div class="clearfix"></div>
                <!-- Button -->
                <div class="col-md-12 text-center">
                    <a href="#" class="btn btn-danger" id="blast_email_button"
                       @click="showSendBulkMail" data-toggle="modal" data-target="#send-email-contact"
                       style="margin-top: 20px">Blast Email</a>
                </div>
            </div>
            <div class="col-xl-3 left-line">
                <div class="event-sideber-category">
                    <h4>Contacts By Event</h4>
                    <ul class="contact_by_event">
                        <li class="by_event" v-for="event in events.data" v-if="events.data" v-cloak>
                            <a href="#" @click.prevent="setContactsByEvent(event.id)">@{{ event.event_title }}</a>
                        </li>
                    </ul>
                    <pagination :data="events" @pagination-change-page="getLiveEvents"></pagination>
                    <br>
                    <h4>Manage Contacts</h4>
                    <div class="contact_attendees">
                        <div class="form-group">
                            <a class="btn btn-danger" data-toggle="modal" @click="showImportContacts"
                               data-target="#import-contact">Upload </a>
                            {{--<a href="#" class="btn btn-danger" @click.prevent="exportContacts">Export</a>--}}
                            <a href="{{ route('export-contacts',['type'=>'xls']) }}" class="btn btn-danger">Export</a>
                        </div>
                        <div class="form-group">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- edit contact --}}

        {{-- send email --}}

        <div id="edit-contact-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Update Contact</b></h3>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="#">
                            <div class="clearfix"></div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="first_name">First Name</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="first_name"
                                           v-model="contact.first_name" placeholder="First Name"/>
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.firstName }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="last_name">Last Name</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="last_name"
                                           v-model="contact.last_name" placeholder="Last Name">
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.lastName }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="email">Email</label>
                                <div class="col-lg-8">
                                    <input type="email" class="form-control" id="email"
                                           v-model="contact.email" placeholder="Email">
                                    <p class="error" v-if="error.show" v-cloak>@{{ error.email }}</p>
                                </div>
                            </div>
                            <div class="text-center"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click.prevent="updateContact">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                @click="cancelEditContact">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- //edit contact --}}

        {{-- send email --}}

        <div id="send-email-contact" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Compose Mail</b></h3>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <textarea class="form-control" placeholder="Compose Mail"
                                      style="height: 200px;" v-model="emailText">
                            </textarea>
                            <p class="error" v-if="error.show" v-cloak>@{{ error.emailText }}</p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click.prevent="sendMail"
                                v-if="!sendingMail"
                                class="btn btn-danger">Send</button>
                        <button type="button" v-if="sendingMail" class="btn btn-danger" disabled>Sending
                            <i class="fa fa-spinner fa-spin"></i></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                @click="cancelSendEmail">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- //send email --}}




        <div id="import-contact" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Import / Export Contacts</b></h3>
                    </div>
                    <div class="modal-body">
                        <div class="setting-billing">
                            <form method="POST" action="#" @keydown.enter="importContactsToDb">
                                <div class="list-group">
                                    <div class="">
                                        <a href="#">Download Example Xls</a>
                                        <div class="clearfix"></div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label"
                                                   for="for-event">For Event</label>
                                            <div class="col-lg-8 toggle-btn">
                                                <select class="form-control" id="for-event"
                                                        v-model="eventIdForImportContacts">
                                                    <option value="">Select Event</option>
                                                    <option v-for="(value, index) in liveEventsForImportContacts"
                                                            :value="index">
                                                        @{{ value }}</option>
                                                </select>
                                                <p class="error" v-if="error.show" v-cloak>
                                                    @{{ error.eventIdForImportContacts }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="import_file">
                                                Select File to Import:</label>
                                            <div class="col-lg-8 toggle-btn">
                                                <input class="form-control" type="file" id="import_file"
                                                       @change="contactExcelFileUpload" accept=".xls,.xlsx">
                                                <p class="error" v-if="error.show" v-cloak>
                                                    @{{ error.importFileForContacts }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"
                                        @click.prevent="importContactsToDb">Upload</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            {{-- //import contact --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection