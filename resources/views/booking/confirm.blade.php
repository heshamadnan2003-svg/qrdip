@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4 text-center">
        📝 {{ __('messages.booking_details') }}
    </h3>

    <form method="POST" action="{{ route('booking.store') }}">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger text-center">
                {{ __('messages.form_error') }}
            </div>
        @endif

        {{-- بيانات الحجز من session --}}
        <input type="hidden" name="organization_id" value="{{ session('booking.organization_id') }}">
        <input type="hidden" name="service_id" value="{{ session('booking.service_id') }}">
        <input type="hidden" name="booking_date" value="{{ session('booking.booking_date') }}">
        <input type="hidden" name="start_time" value="{{ session('booking.start_time') }}">

        <div class="mb-3">
            <label>
                {{ __('messages.customer_name') }}
                <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="customer_name"
                   class="form-control"
                   placeholder="{{ __('messages.placeholder_customer_name') }}"
                   required>
        </div>

        <div class="mb-3">
            <label>
                {{ __('messages.customer_phone') }}
                <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="customer_phone"
                   class="form-control"
                   placeholder="{{ __('messages.placeholder_customer_phone') }}"
                   required>
        </div>

        <div class="mb-3">
            <label>
                {{ __('messages.customer_email') }}
                <span class="text-danger">*</span>
            </label>
            <input type="email"
                   name="customer_email"
                   class="form-control"
                   placeholder="{{ __('messages.placeholder_customer_email') }}"
                   required>
        </div>

        <div class="mb-3">
            <label>{{ __('messages.customer_address_optional') }}</label>
            <input type="text"
                   name="customer_address"
                   class="form-control"
                   placeholder="{{ __('messages.placeholder_customer_address') }}">
        </div>

        <button class="btn btn-success w-100">
            ✅ {{ __('messages.confirm_booking') }}
        </button>
    </form>

</div>
@endsection
