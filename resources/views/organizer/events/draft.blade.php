@extends('organizer.include.app')

@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Draft Events</h1>
                </div>
                <div class="col-7">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Draft Events</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCX76RWTDMQxUEfW0xtiQmjVELZwBA-o6A&libraries=places"></script>
    <div class="container" id="draft-events">
        <div class="row justify-content-between" v-if="!edit" v-cloak>
            <div class="col-xl-8">
                <div class="alert alert-warning text-center" v-cloak v-if="error.show">
                    <h4><i class="fa fa-warning"></i> @{{ error.message }}</h4>
                </div>
                <div class="alert alert-success text-center" v-cloak v-if="success.show">
                    <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                </div>
                {{-- events loop --}}
                <div class="event-draft-table" v-if="events.data" v-cloak>
                    <div class="table-responsive">
                        <table class="table" id="example1">
                            <tbody>
                            <tr class="" v-for="event in events.data">
                                <td class="name">By @{{ event.r_e_l__event__organizer.first_name }}
                                    @{{ event.r_e_l__event__organizer.last_name }}</td>
                                <td class="evemt-name">@{{  event.event_title }}
                                    <span>(Draft)</span>
                                </td>
                                <td class="date">@{{ event.created_at | eventCreatedDate }}</td>
                                <td>
                                    <a href="#" @click.prevent="editEvent(event)">
                                        <i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px"></i>
                                    </a>
                                </td>
                                <td>
                                    {{--<a href="#" class="delete_event" @click.prevent="deleteEvent(event.id)">
                                        <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                                    </a>--}}
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                {{-- // events loop --}}
                <div class="pagination">
                    <pagination :data="events" @pagination-change-page="getDraftEvents"
                                style="margin: 0 auto;"></pagination>
                </div>
            </div>
            <div class="col-xl-3 left-line">
                <div class="event-sideber m-l-15">
                    <div class="event-sideber-category">
                        <h4 class="text-center">Contact Attendees</h4>
                        <ul class="contact_attendees">
                            <li>
                                <a href="#">Eminem in Delhi</a>
                            </li>
                            <li>
                                <a href="#">Rihanna in Mumbai</a>
                            </li>
                            <li>
                                <a href="#">Holi Celebration</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- edit event section --}}

        <div class="row justify-content-between" v-if="edit" v-cloak>
            <div class="col-xl-12">
                <h3><b>Basic Information</b></h3>
                <div class="setting-billing">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="alert alert-success" v-cloak v-if="success.show">
                                <h4><i class="icon fa fa-check"></i> @{{ success.message }}</h4>
                            </div>
                            <form action="#" enctype='multipart/form-data' @keydown.prevent.enter=""
                                  id="create-event-form">
                                <div class="clearfix"></div>
                                @include('organizer.events.edit')
                                <div class="text-center">
                                    <button class="btn btn-danger" @click.prevent="editDraftEvent">Update Event</button>
                                    <a href="#" class="btn btn-secondary" @click.prevent="cancelEdit" >Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //edit event section --}}
    </div>
@endsection