@extends('layouts.app')

@section('content')
<div class="container text-center">

    <div class="alert alert-success p-4" role="alert" aria-live="polite">
        <h4 class="mb-3">
            🎉 {{ __('messages.booking_success_title') }}
        </h4>

        <p>
            {{ __('messages.booking_success_message') }}<br>
            {{ __('messages.booking_success_note') }}
        </p>

        <a href="{{ route('customer.bookings') }}" class="btn btn-primary mt-3">
            📅 {{ __('messages.view_my_bookings') }}
        </a>
    </div>

</div>
@endsection
