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
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($bookings as $booking)
                    @php
                        $status = booking_status_badge($booking->status);

                        // ⏱ وقت الحجز الكامل
                        $bookingDateTime = \Carbon\Carbon::parse(
                            $booking->booking_date . ' ' . $booking->start_time
                        );

                        // ⏰ الوقت الحالي (السيرفر)
                        $now = now();
                    @endphp

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

                        <td>
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                        </td>

                        {{-- حالة الحجز --}}
                        <td>
                            <span class="badge bg-{{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>

                        {{-- الإجراءات --}}
                        <td>

                            {{-- يظهر فقط إذا:
                                 1) الحجز مؤكد
                                 2) وقت الحجز دخل أو انتهى --}}
                            @if(
                                $booking->status === 'confirmed'
                                && $now->greaterThanOrEqualTo($bookingDateTime)
                            )

                                {{-- تم تنفيذ الموعد --}}
                                <form method="POST"
                                      action="{{ route('manager.bookings.complete', $booking) }}"
                                      class="mb-1">
                                    @csrf
                                    <button class="btn btn-sm btn-success w-100">
                                        ✅ {{ __('messages.mark_as_completed') }}
                                    </button>
                                </form>

                                {{-- لم يحضر الزبون --}}
                                <form method="POST"
                                      action="{{ route('manager.bookings.noShow', $booking) }}"
                                      class="mb-1">
                                    @csrf
                                    <button class="btn btn-sm btn-warning w-100"
                                            onclick="return confirm('{{ __('messages.confirm_no_show') }}')">
                                        ❌ {{ __('messages.mark_as_no_show') }}
                                    </button>
                                </form>

                            @else
                                <span class="text-muted">—</span>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</div>
@endsection
