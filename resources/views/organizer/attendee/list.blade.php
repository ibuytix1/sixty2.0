@extends('organizer.include.app')

@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Event Attendees </h1>
                </div>
                <div class="col-7">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Reports</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Attendees</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" id="attendee-list">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="input-group custom-search">
                            <input type="text" class="form-control" placeholder="Fine Attendee"
                                   @keyup="searchAttendees"
                                   v-model="keywords">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control custom-dropdown" v-model="sortBy">
                            <option value="">Sort By</option>
                            <option value="ticket_type">Ticket Type</option>
                            <option value="date_of_purchase">Date of Purchase</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input class="form-control" type="text" id="search-by-date" placeholder="YY/MM/DD">
                    </div>
                </div>
                <br>
                <div class="table-wrapper table-responsive col-sm-12">
                    <!--Table-->
                    <table class="table table-hover mb-0">
                        <!--Table head-->
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Event Name</th>
                            <th scope="col">Ticket Type</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Date of Purchase</th>
                            <th scope="col">Amount</th>
                            {{--<th scope="col">Barcode</th>--}}
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                        <tr v-for="attendee in attendees.data" v-if="attendees.data" v-cloak>
                            <td>@{{ attendee.first_name }} @{{ attendee.last_name }}</td>
                            <td>@{{ attendee.email }}</td>
                            <td>@{{ attendee.event.event_title }}</td>
                            <td>@{{ attendee.ticket_type }}</td>
                            <td>@{{ attendee.quantity }}</td>
                            <td>@{{ attendee.created_at | eventCreatedDate }}</td>
                            <td>$ @{{ attendee.amount }}</td>
                            {{--<td><a href="JavaScript:void(0);">w7700029448</a></td>--}}
                            <td>
                                <a href="#" class="btn btn-danger btn-sm">
                                    Resend Tickets
                                </a>
                            </td>
                        </tr>
                        <tr v-if="attendees.code === 0" class="text-center">
                            <td colspan="9">@{{ attendees.message }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="pagination" style="float:right; margin-top: 10px;">
                        <span v-if="!search && !sort && !byDate">
                            <pagination :data="attendees" @pagination-change-page="getAttendees"></pagination>
                        </span>
                        <span v-if="search && !sort && !byDate">
                            <pagination :data="attendees" @pagination-change-page="searchAttendees"></pagination>
                        </span>
                        <span v-if="!search && sort && !byDate">
                            <pagination :data="attendees" @pagination-change-page="sortAttendeesData"></pagination>
                        </span>
                        <span v-if="!search && !sort && byDate">
                            <pagination :data="attendees" @pagination-change-page="searchByDate"></pagination>
                        </span>
                    </div>
                </div>
                {{--<div class="form-group row">
                    <label class="col-lg-4 col-form-label">Download Information</label>
                    <div class="form-group row">
                        <label class="col-lg-12 col-form-label">&nbsp;</label>
                        <div class="col-lg-12">
                            <label class="checkbox-inline"><input type="checkbox" value=""> Name</label> &nbsp;
                            <label class="checkbox-inline"><input type="checkbox" value=""> Email Address</label> &nbsp;
                            <label class="checkbox-inline"><input type="checkbox" value=""> CTicket Type</label> &nbsp;
                            <label class="checkbox-inline"><input type="checkbox" value=""> Quantity</label> &nbsp;
                            <label class="checkbox-inline"><input type="checkbox" value=""> Date of Purchase</label>
                            &nbsp;
                            <label class="checkbox-inline"><input type="checkbox" value=""> Amount</label> &nbsp;
                            <label class="checkbox-inline"><input type="checkbox" value=""> Barcode</label> &nbsp;
                        </div>
                    </div>
                </div>--}}
                <div class="col-sm-12 text-center">
                    <a href="{{ route('export-attendees', ['type'=>'xls']) }}" class="btn btn-danger">Download CSV</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-script')
    <script>
        $(document).ready(function(){
            $("#example-date-input").datepicker();
        });
    </script>
@endsection