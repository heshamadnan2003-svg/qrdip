@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4 text-center">📅 حجوزاتي السابقة</h3>

    @foreach($bookings as $booking)
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>الخدمة:</strong> {{ $booking->service->name ?? '-' }}</p>
                <p><strong>التاريخ:</strong> {{ $booking->booking_date }}</p>
                <p><strong>الوقت:</strong> {{ substr($booking->start_time,0,5) }}</p>
                <p><strong>الحالة:</strong> {{ $booking->status }}</p>
            </div>
        </div>
    @endforeach

</div>
@endsection
