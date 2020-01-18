@extends('organizer.include.app')
@section('before-content')
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Create your Event</h1>
                    <h3>Enter your event details to start selling tickets</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('templates.event-create')
@endsection

@section('after-script')
    @include('templates.event-create-script');
@endsection