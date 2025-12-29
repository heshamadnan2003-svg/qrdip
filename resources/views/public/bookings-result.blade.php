@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="text-center mb-4">📅 حجوزاتك السابقة</h3>

    @if(session('error'))
        <div class="alert alert-warning text-center">
            {{ session('error') }}
        </div>
    @endif

    @if($bookings)
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
    @endif

</div>
@endsection
