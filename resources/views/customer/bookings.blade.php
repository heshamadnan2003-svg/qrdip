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
            <div class="card mb-3 shadow-sm">
                <div class="card-body {{ app()->getLocale() === 'ar' ? 'text-end' : 'text-start' }}">

                    <p>
                        <strong>{{ __('messages.service') }}:</strong>
                        {{ $booking->service->name ?? '-' }}
                    </p>

                    <p>
                        <strong>{{ __('messages.price') }}:</strong>
                        {{ number_format($booking->service->price ?? 0, 2) }}
                        {{ __('messages.currency') }}
                    </p>

                    <p>
                        <strong>{{ __('messages.date') }}:</strong>
                        {{ $booking->booking_date }}
                    </p>

                    <p>
                        <strong>{{ __('messages.time') }}:</strong>
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                    </p>

                    {{-- حالة الحجز --}}
                    <p>
                        <strong>{{ __('messages.status') }}:</strong>

                        @if($booking->status === 'confirmed')
                            <span class="badge bg-success">
                                {{ __('messages.booking_confirmed') }}
                            </span>

                        @elseif($booking->status === 'completed')
                            <span class="badge bg-primary">
                                {{ __('messages.booking_completed') }}
                            </span>

                        @elseif($booking->status === 'no_show')
                            <span class="badge bg-warning text-dark">
                                {{ __('messages.booking_no_show') }}
                            </span>

                        @else
                            <span class="badge bg-danger">
                                {{ __('messages.booking_cancelled') }}
                            </span>
                        @endif
                    </p>

                    {{-- أزرار التعديل والإلغاء (فقط إذا كان مؤكد) --}}
                    @if($booking->status === 'confirmed')
                        <div class="d-flex gap-2 justify-content-end mt-3">

                            <a href="{{ route('customer.bookings.edit', $booking) }}"
                               class="btn btn-sm btn-outline-primary">
                                ✏️ {{ __('messages.edit') }}
                            </a>

                            <form method="POST"
                                  action="{{ route('customer.bookings.cancel', $booking) }}">
                                @csrf
                                @method('PATCH')

                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('{{ __('messages.cancel_booking_confirm') }}')">
                                    ❌ {{ __('messages.cancel') }}
                                </button>
                            </form>

                        </div>
                    @endif

                </div>
            </div>
        @endforeach
    @endif

</div>
@endsection
