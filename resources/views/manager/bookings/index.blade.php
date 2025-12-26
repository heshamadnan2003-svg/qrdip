@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4 text-center">
        📅 {{ __('messages.manager_bookings_title') }}
    </h3>

    @if($bookings->isEmpty())
        <div class="alert alert-info text-center">
            {{ __('messages.no_manager_bookings') }}
        </div>
    @else

        <table class="table table-bordered align-middle
            {{ app()->getLocale() === 'ar' ? 'text-center' : 'text-start' }}">
            <thead class="table-light">
                <tr>
                    <th>{{ __('messages.customer') }}</th>
                    <th>{{ __('messages.customer_phone') }}</th>
                    <th>{{ __('messages.service') }}</th>
                    <th>{{ __('messages.service_price') }}</th>
                    <th>{{ __('messages.booking_date') }}</th>
                    <th>{{ __('messages.booking_time') }}</th>
                    <th>{{ __('messages.booking_status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->customer_name }}</td>

                        <td>{{ $booking->customer_phone }}</td>

                        <td>
                            {{ $booking->service->name ?? __('messages.not_available') }}
                        </td>

                        <td class="fw-bold text-success">
                            {{ $booking->service->price ?? 0 }}
                            {{ __('messages.currency') }}
                        </td>

                        <td>{{ $booking->booking_date }}</td>

                        <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</td>

                        <td>
                            @if($booking->status === 'confirmed')
                                <span class="badge bg-success mb-2 d-block">
                                    {{ __('messages.booking_confirmed') }}
                                </span>

                                <form method="POST"
                                      action="{{ route('manager.bookings.cancel', $booking->id) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger w-100"
                                            onclick="return confirm('{{ __('messages.cancel_booking_confirm_manager') }}')">
                                        ❌ {{ __('messages.cancel_booking') }}
                                    </button>
                                </form>

                            @elseif($booking->status === 'cancelled')
                                <span class="badge bg-danger">
                                    {{ __('messages.booking_cancelled') }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
