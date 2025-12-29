@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="text-center mb-4">📅 حجوزاتك السابقة</h3>

    @forelse($bookings as $booking)
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>الخدمة:</strong> {{ $booking->service->name }}</p>
                <p><strong>التاريخ:</strong> {{ $booking->booking_date }}</p>
                <p><strong>الوقت:</strong> {{ substr($booking->start_time,0,5) }}</p>
                <p><strong>الحالة:</strong> {{ $booking->status }}</p>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            لا يوجد لديك حجوزات سابقة
        </div>
    @endforelse

</div>
@endsection
