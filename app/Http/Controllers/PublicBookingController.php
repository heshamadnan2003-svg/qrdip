<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class PublicBookingController extends Controller
{
    public function lookup(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string',
            'customer_email' => 'required|email',
            'password'       => 'required',
            'organization_id'=> 'required|exists:organizations,id',
        ]);

        $bookings = Booking::where('organization_id', $request->organization_id)
            ->where('customer_name', $request->customer_name)
            ->where('customer_email', $request->customer_email)
            ->get();

        if ($bookings->isEmpty()) {
            return back()->with('error', 'لا يوجد لديك حجوزات سابقة');
        }

        session([
    'public_bookings' => $bookings,
    'public_mode' => true,
]);

return redirect()->route('customer.bookings');
    }

    public function result()
    {
        $bookings = session('public_bookings');

        if (!$bookings) {
            return redirect('/')->with('error', 'انتهت الجلسة');
        }

        return view('public.bookings-result', compact('bookings'));
    }
}
