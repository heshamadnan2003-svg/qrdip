<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Service;
use App\Models\BusyTime;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class BookingController extends Controller
{
    /**
     * عرض حجوزات الزبون
     */
    public function index()
{
    // حالة زائر أو مستخدم – كلاهما يعتمد على الإيميل
    if (session()->has('customer_email')) {

        $bookings = Booking::with('service')
            ->where('customer_email', session('customer_email'))
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();

        return view('user.bookings', compact('bookings'));
    }

    // لا يوجد إيميل محفوظ
    return view('user.bookings', [
        'bookings' => collect()
    ]);
}



    /**
     * حفظ بيانات الحجز في Session
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
     * تثبيت الحجز النهائي
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

        // منع التداخل مع الحجوزات
        $overlapBooking = Booking::where('organization_id', $request->organization_id)
            ->where('booking_date', $request->booking_date)
            ->where('status', 'confirmed')
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            })
            ->exists();

        // منع التداخل مع الأوقات المشغولة
        $overlapBusy = BusyTime::where('organization_id', $request->organization_id)
            ->where('date', $request->booking_date)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            })
            ->exists();

        if ($overlapBooking || $overlapBusy) {
            return back()->withErrors([
                'start_time' => __('messages.time_slot_already_booked')
            ]);
        }
        

        try {
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
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()->withErrors([
                    'start_time' => __('messages.time_slot_already_booked')
                ]);
            }
            throw $e;
        }

        session(['customer_email' => $request->customer_email]);

        return redirect()->route('booking.success');
    }

    /**
     * إلغاء الحجز
     */
    public function cancel(Booking $booking)
{
    if ($booking->user_id !== auth()->id()) {
        abort(403);
    }

    if ($booking->status !== 'confirmed') {
        return back();
    }

    $booking->update([
        'status' => 'cancelled'
    ]);

    return back()->with('success', __('messages.booking_cancelled'));
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

    public function availableTimes(Request $request)
    {
        $organizationId = $request->organization_id;
        $date = $request->date;

        $bookedTimes = Booking::where('organization_id', $organizationId)
            ->where('booking_date', $date)
            ->whereIn('status', ['confirmed'])
            ->pluck('start_time')
            ->map(fn ($time) => substr($time, 0, 5))
            ->toArray();

        $allTimes = [];
        $start = strtotime('09:00');
        $end   = strtotime('17:00');

        while ($start < $end) {
            $allTimes[] = date('H:i', $start);
            $start = strtotime('+30 minutes', $start);
        }

        return response()->json(array_values(array_diff($allTimes, $bookedTimes)));
    }




public function lookup(Request $request)
{
    $request->validate([
        'customer_name'  => 'required',
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

    // التحقق من كلمة المرور (مخزنة hash)
    $valid = Hash::check(
        $request->password,
        $bookings->first()->password
    );

    if (! $valid) {
        return back()->with('error', 'بيانات غير صحيحة');
    }

    session([
        'public_bookings' => $bookings->pluck('id')
    ]);

    return redirect()->route('public.bookings.list');
}


public function publicList()
{
    $ids = session('public_bookings', []);

    if (empty($ids)) {
        abort(403);
    }

    $bookings = Booking::whereIn('id', $ids)->get();

    return view('booking.public-my-bookings', compact('bookings'));
}

}
