<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Service;
use App\Models\BusyTime;

class BookingController extends Controller
{
    /**
     * عرض حجوزات الزبون (حسب البريد)
     */
    public function index()
    {
        $customerEmail = session('customer_email');

        if (!$customerEmail) {
            return view('customer.bookings', ['bookings' => collect()]);
        }

        $bookings = Booking::with('service')
    ->where('customer_email', $customerEmail)
    ->orderBy('booking_date')
    ->orderBy('start_time')
    ->get();


        return view('customer.bookings', compact('bookings'));
    }

    /**
     * 1️⃣ حفظ الوقت المختار في session
     */
    public function storeSession(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'service_id'      => 'required|exists:services,id',
            'booking_date'    => 'required|date',
            'start_time'      => 'required',
        ]);

        session([
            'booking' => $request->only(
                'organization_id',
                'service_id',
                'booking_date',
                'start_time'
            )
        ]);

        return redirect()->route('booking.confirm');
    }

    /**
     * 2️⃣ صفحة إدخال بيانات الزبون
     */
    public function confirmView()
    {
        if (!session()->has('booking')) {
            return redirect('/')->withErrors('لا توجد بيانات حجز');
        }

        return view('booking.confirm');
    }

    /**
     * 3️⃣ تثبيت الحجز النهائي (مع منع التداخل)
     */
    public function store(Request $request)
    {
        $request->validate([
            'organization_id'  => 'required|exists:organizations,id',
            'service_id'       => 'required|exists:services,id',
            'booking_date'     => 'required|date',
            'start_time'       => 'required',
            'customer_name'    => 'required|string',
            'customer_phone'   => 'required|string',
            'customer_email'   => 'required|email',
            'customer_address' => 'nullable|string',
        ]);

        $service = Service::findOrFail($request->service_id);

        $startTime = Carbon::parse($request->start_time);
        $endTime   = $startTime->copy()->addMinutes($service->duration);

        // ❌ منع التداخل مع حجوزات أخرى
        $overlapBooking = Booking::where('organization_id', $request->organization_id)
            ->where('booking_date', $request->booking_date)
            ->where('status', 'confirmed')
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            })
            ->exists();

        // ❌ منع التداخل مع أوقات مشغولة
        $overlapBusy = BusyTime::where('organization_id', $request->organization_id)
            ->where('date', $request->booking_date)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            })
            ->exists();

        if ($overlapBooking || $overlapBusy) {
            return back()->withErrors([
                'start_time' => '❌ هذا الوقت غير متاح'
            ]);
        }

        Booking::create([
            'organization_id' => $request->organization_id,
            'service_id'      => $request->service_id,
            'booking_date'    => $request->booking_date,
            'start_time'      => $startTime->format('H:i:s'),
            'end_time'        => $endTime->format('H:i:s'),
            'customer_name'   => $request->customer_name,
            'customer_phone'  => $request->customer_phone,
            'customer_email'  => $request->customer_email,
            'customer_address'=> $request->customer_address,
            'status'          => 'confirmed',
        ]);

        // ⭐ حفظ البريد لعرض حجوزاته فقط
        session([
            'customer_email' => $request->customer_email
        ]);

        return redirect()->route('booking.success');
    }
    public function cancel(Booking $booking)
{
    // حماية: فقط صاحب الحجز
    if ($booking->customer_email !== session('customer_email')) {
        abort(403);
    }

    $booking->update([
        'status' => 'cancelled'
    ]);

    return back()->with('success', 'تم إلغاء الحجز بنجاح');
}

public function edit(Booking $booking)
{
    if ($booking->customer_email !== session('customer_email')) {
        abort(403);
    }

    return view('user.edit-booking', compact('booking'));
}

public function update(Request $request, Booking $booking)
{
    if ($booking->customer_email !== session('customer_email')) {
        abort(403);
    }

    $request->validate([
        'booking_date' => 'required|date',
        'start_time'   => 'required',
    ]);

    $booking->update([
        'booking_date' => $request->booking_date,
        'start_time'   => $request->start_time,
    ]);

    return redirect()
        ->route('customer.bookings')
        ->with('success', 'تم تعديل الحجز بنجاح');
}

}
