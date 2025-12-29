@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px">

    <div class="card shadow-sm">
        <div class="card-body text-center">

            <h3 class="mb-3">
                ✅ {{ __('messages.booking_success_title') }}
            </h3>

            <p class="text-muted">
                {{ __('messages.booking_success_message') }}
            </p>

            <hr>

            {{-- التقييم يظهر فقط إذا تم تنفيذ الحجز --}}
            @if(isset($booking) && $booking->is_completed && !$booking->review)

                <h5 class="mb-3">
                    ⭐ {{ __('messages.rate_service') }}
                </h5>

                <form method="POST"
                      action="{{ route('booking.review.store', $booking) }}">
                    @csrf

                    <div class="mb-3">
                        <select name="rating" class="form-control text-center" required>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★</option>
                            <option value="3">★★★</option>
                            <option value="2">★★</option>
                            <option value="1">★</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <textarea name="comment"
                                  class="form-control"
                                  rows="3"
                                  placeholder="{{ __('messages.review_optional') }}"></textarea>
                    </div>

                    <button class="btn btn-primary w-100">
                        {{ __('messages.submit_review') }}
                    </button>
                </form>

            @elseif(isset($booking) && $booking->review)
                <div class="alert alert-success">
                    ⭐ {{ __('messages.review_saved') }}
                </div>
            @else
                <div class="alert alert-info">
                    ⏳ {{ __('messages.wait_for_completion') }}
                </div>
            @endif

            <a href="{{ route('customer.bookings') }}"
               class="btn btn-outline-secondary mt-4 w-100">
                📅 {{ __('messages.view_my_bookings') }}
            </a>

        </div>
    </div>

</div>
@endsection
