@extends('organizer.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <h1>Sales by Event</h1>
                </div>
                <div class="col-7">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('org-home') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Sales by Event</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" id="sales-list">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-sm-8 space-bottom-15">
                        <select class="form-control custom-dropdown" v-model="event_id">
                            <option selected="selected" value="">Select Event</option>
                            <option v-for="event in events" :value="event.id">@{{ event.event_title }}</option>
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
                            <th scope="col">Ticket Type</th>
                            <th scope="col">Total Sold</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total Refunds</th>
                            <th scope="col">Amount Refunded</th>
                            <th scope="col">Total Price</th>
                        </tr>
                        </thead>
                        <!--Table head-->
                        <tbody>
                        <tr v-for="sale in sales" v-if="sales" v-cloak>
                            <td>@{{ sale.ticket_type }}</td>
                            <td><a href="JavaScript:void(0)">@{{ sale.quantity }}/@{{ sale.ticket.original_quantity }}</a></td>
                            <td>$ @{{ sale.ticket.price }}</td>
                            <td>0</td>
                            <td>$0</td>
                            <td>$ @{{ sale.total_price }}</td>
                        </tr>
                        <tr v-if="!event_id" v-cloak>
                            <td colspan="6" class="text-center" v-cloak>Please select an event</td>
                        </tr>
                        <tr v-if="!sales.length && event_id">
                            <td colspan="6" class="text-center" v-cloak>Data not found</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection