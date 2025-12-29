@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4 text-center">
        📅 {{ __('messages.my_bookings') }}
    </h3>

    @if($bookings->isEmpty())
        <div class="alert alert-info text-center">
            {{ __('messages.no_bookings') }}
        </div>
    @else
        @foreach($bookings as $booking)

            @php
                $status = booking_status_badge($booking->status);
            @endphp

            <div class="card mb-3 shadow-sm">
                <div class="card-body {{ app()->getLocale() === 'ar' ? 'text-end' : 'text-start' }}">

                    <p>
                        <strong>{{ __('messages.service') }}:</strong>
                        {{ $booking->service->name }}
                    </p>

                    <p>
                        <strong>{{ __('messages.price') }}:</strong>
                        {{ number_format($booking->service->price, 2) }}
                        {{ __('messages.currency') }}
                    </p>

                    <p>
                        <strong>{{ __('messages.date') }}:</strong>
                        {{ $booking->booking_date }}
                    </p>

                    <p>
                        <strong>{{ __('messages.time') }}:</strong>
                        {{ substr($booking->start_time, 0, 5) }}
                    </p>

                    {{-- الحالة --}}
                    <p>
                        <strong>{{ __('messages.status') }}:</strong>
                        <span class="badge bg-{{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </p>

                    {{-- ✅ أزرار التعديل والحذف (فقط إذا مؤكد) --}}
                    @if($booking->status === 'confirmed')
    <div class="d-flex gap-2 mt-3">

        {{-- تعديل الموعد --}}
        <a href="{{ route('customer.bookings.edit', $booking) }}"
           class="btn btn-sm btn-outline-primary w-50">
            ✏️ {{ __('messages.edit_booking') }}
        </a>

        {{-- إلغاء الموعد --}}
        <form method="POST"
              action="{{ route('customer.bookings.cancel', $booking) }}"
              class="w-50">
            @csrf
            @method('PATCH')

            <button type="submit"
                    class="btn btn-sm btn-outline-danger w-100"
                    onclick="return confirm('{{ __('messages.confirm_cancel_booking') }}')">
                🗑 {{ __('messages.cancel_booking') }}
            </button>
        </form>

    </div>
@endif


                    {{-- ⭐ التقييم (فقط بعد التنفيذ) --}}
                    @if($booking->status === 'completed' && !$booking->review)
                        <div class="mt-3">
                            <a href="{{ route('reviews.create', $booking) }}"
                               class="btn btn-sm btn-outline-warning">
                                ⭐ {{ __('messages.leave_review') }}
                            </a>
                        </div>
                    @endif

                </div>
            </div>

        @endforeach
    @endif

</div>
@endsection
