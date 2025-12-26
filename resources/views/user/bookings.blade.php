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
                <div class="card-body text-end">

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
                        {{ $booking->start_time }}
                    </p>

                    <p>
                        <strong>{{ __('messages.status') }}:</strong>

                        @if($booking->status === 'confirmed')
                            <span class="badge bg-success">
                                {{ __('messages.booking_confirmed') }}
                            </span>
                        @else
                            <span class="badge bg-danger">
                                {{ __('messages.booking_cancelled') }}
                            </span>
                        @endif
                    </p>

                    {{-- أزرار التحكم --}}
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
