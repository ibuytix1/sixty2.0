@extends('user.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Support</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container" id="support-tickets">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <br>
                <div class="table-wrapper table-responsive col-sm-12">
                    <!--Table-->
                    <table class="table table-hover mb-0">
                        <!--Table head-->
                        <thead>
                        <tr>
                            <th scope="col">Organizer Name</th>
                            <th scope="col">Organizer Email</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                            <th scope="col">Reply from Support</th>
                            <th scope="col">Ticket Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <!-- //Table head-->
                        <!--Table body-->
                        <tbody>
                        <tr v-if="allTickets.data" v-for="ticket in allTickets.data">
                            <td>@{{ ticket.organizer.first_name }} @{{ ticket.organizer.last_name }}</td>
                            <td><a :href="'mailto:' + ticket.organizer.first_name">@{{ ticket.organizer.email }}</a></td>
                            <td>@{{ ticket.subject }}</td>
                            <td :title="ticket.message">@{{ ticket.message | readMore(10, '...') }}</td>
                            <td :title="ticket.organizer_message">@{{ ticket.organizer_message | readMore(20, '...') }}</td>
                            <td>@{{ ticket.status }}</td>
                            <td>
                                <a href="#" title="View Your Support Ticket Details"
                                   data-toggle="modal" data-target="#ticket-modal"
                                   @click="showTicketDetails(ticket)">
                                    <i class="fa fa-eye" style="font-size:20px"></i>
                                </a>
                                <a href="#" title="Edit your message" data-toggle="modal"
                                   data-target="#edit-message" @click="showEditMessage(ticket)">
                                    <i class="fa fa-pencil-square-o" style="font-size:20px"></i>
                                </a>
                            </td>
                        </tr>
                        <tr v-if="!allTickets.data">
                            <td colspan="9" class="text-center">data not available</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <pagination2 :data="allTickets" @pagination-change-page="getMySupportTickets"
                            style="float: right; margin-top: 10px;"></pagination2>
                <div class="clearfix"></div>
                <div class="text-center">
                    <a href="#" data-toggle="modal"
                       data-target="#create-support-ticket" class="btn btn-danger">Create Support Ticket</a>
                </div>
            </div>

        </div>

        {{-- view coupon details --}}
        <div class="modal fade" role="dialog" id="ticket-modal">
            <div class="modal-dialog">
                {{-- Modal content--}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" style="margin-top: 0;">Organizer Details</h2>
                        <button type="button" class="close" id="close_add_coupon" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <br><br>
                    <div class="modal-body" v-if="ticket.organizer" v-cloak>
                        <div class="setting-billing">
                            <div class="list-group">
                                <div class="clearfix"></div>
                                <div class="form-group row">
                                    <label class="col-lg-4">Organizer Name: </label>
                                    <div class="col-lg-8">
                                        @{{ ticket.organizer.first_name }} @{{ ticket.organizer.last_name }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">About Organizer: </label>
                                    <div class="col-sm-8">
                                        @{{ ticket.organizer.about_organizer }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Organizer Email: </label>
                                    <div class="col-lg-8">
                                        @{{ ticket.organizer.email }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Screenshots: </label>
                                    <div class="col-sm-8">
                                        sdfjklks
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Subject: </label>
                                    <div class="col-lg-8">
                                        @{{ ticket.subject }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">Your message: </label>
                                    <div class="col-lg-8">
                                        @{{ ticket.message }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4">Support Message: </label>
                                    <div class="col-lg-8">
                                        @{{ ticket.organizer_message }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4">Support ticket status: </label>
                                    <div class="col-lg-8">
                                        @{{ ticket.status }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //view coupon details --}}

        {{-- edit message --}}
        <div id="edit-message" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Edit Your Message</b></h3>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <textarea class="form-control" placeholder="Message..."
                                      style="height: 200px;" v-model="ticket.message">
                            </textarea>
                            <p class="error" v-if="error.show" v-cloak>@{{ error.message }}</p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click.prevent="updateMessage" class="btn btn-danger">update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                @click="cancelEditTicketMessage">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- //edit message --}}

        {{-- create Helpdesk Ticket --}}
        <div id="create-support-ticket" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><b>Create Support Ticket</b></h3>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="#">
                            <div class="clearfix"></div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="organizer_id">Select organizer</label>
                                <div class="col-lg-8">
                                    <select class="form-control" id="organizer_id"
                                            v-model="createTicket.organizer_id">
                                        <option value="">Please select organizer</option>
                                        <option v-for="organizer in organizers"
                                                :value="organizer.id">
                                            @{{ organizer.first_name }} @{{ organizer.last_name }}
                                        </option>
                                    </select>
                                    <p class="error" v-if="error.ticket.show" v-cloak>@{{ error.ticket.organizer_id }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="helpdesk_category">Select category</label>
                                <div class="col-lg-8">
                                    <select id="helpdesk_category" class="form-control"
                                            v-model="createTicket.category_id">
                                        <option value="">Select a category</option>
                                        <option v-for="category in helpdeskCategories" :value="category.id">
                                            @{{ category.name }}
                                        </option>
                                    </select>
                                    <p class="error" v-if="error.ticket.show" v-cloak>@{{ error.ticket.category_id }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="subject">Subject</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="subject"
                                           v-model="createTicket.subject" placeholder="subject">
                                    <p class="error" v-if="error.ticket.show" v-cloak>@{{ error.ticket.subject }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="subject">Message</label>
                                <div class="col-lg-8">
                                    <textarea class="form-control" id="subject"
                                              v-model="createTicket.message" placeholder="message..."></textarea>
                                    <p class="error" v-if="error.ticket.show" v-cloak>@{{ error.ticket.message }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="ticket_image">Upload Image</label>
                                <div class="col-lg-8">
                                    <input type="file" class="form-control" id="ticket_image"
                                           @change="onImageChange" placeholder="Select an image" accept='image/*'>
                                </div>
                            </div>
                            <div class="text-center"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click.prevent="createSupportTicket"
                                id="create-support-ticket-button">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- //create helpdesk ticket --}}



    </div>
@endsection