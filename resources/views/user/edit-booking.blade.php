@extends('layouts.app')

@section('content')
<div class="container" style="max-width:400px">

    <h4 class="mb-4 text-center">
        ✏️ {{ __('messages.edit_booking') }}
    </h4>

    <form method="POST"
          action="{{ route('customer.bookings.update', $booking) }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label class="form-label">
                {{ __('messages.date') }}
            </label>
            <input type="date"
                   name="booking_date"
                   class="form-control"
                   value="{{ $booking->booking_date }}">
        </div>

        <div class="mb-3">
            <label class="form-label">
                {{ __('messages.time') }}
            </label>
            <input type="time"
                   name="start_time"
                   class="form-control"
                   value="{{ $booking->start_time }}">
        </div>

        <button class="btn btn-primary w-100">
            💾 {{ __('messages.save') }}
        </button>

    </form>
</div>
@endsection
