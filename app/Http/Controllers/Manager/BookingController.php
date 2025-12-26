<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
{
    $organization = auth()->user()->organization;

    $bookings = Booking::with('service')
    ->where('organization_id', $organization->id)
    ->orderBy('booking_date')
    ->orderBy('start_time')
    ->get();


    return view('manager.bookings.index', compact('bookings'));
}


public function cancel(Booking $booking)
    {
        $organization = auth()->user()->organization;

        // حماية: لا يمكن إلغاء حجز لا يخص هذه الجهة
        if ($booking->organization_id !== $organization->id) {
            abort(403);
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'تم إلغاء الموعد بنجاح');
    }

}
