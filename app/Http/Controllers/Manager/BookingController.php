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

    /**
     * إلغاء الموعد (قبل التنفيذ)
     */
    public function cancel(Booking $booking)
    {
        $organization = auth()->user()->organization;

        // حماية: لا يمكن تعديل حجز لا يخص هذه الجهة
        if ($booking->organization_id !== $organization->id) {
            abort(403);
        }

        // لا يمكن الإلغاء بعد اتخاذ قرار
        if ($booking->status !== 'confirmed') {
            return back();
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'تم إلغاء الموعد بنجاح');
    }

    /**
     * تم تنفيذ الموعد (حضر الزبون)
     */
    public function complete(Booking $booking)
    {
        $organization = auth()->user()->organization;

        if ($booking->organization_id !== $organization->id) {
            abort(403);
        }

        // يسمح فقط إذا كان الحجز مؤكدًا
        if ($booking->status !== 'confirmed') {
            return back();
        }

        $booking->update([
            'status' => 'completed',
        ]);

        return back()->with('success', __('messages.booking_completed'));
    }

    /**
     * الزبون لم يحضر الموعد (No Show)
     */
    public function noShow(Booking $booking)
    {
        $organization = auth()->user()->organization;

        if ($booking->organization_id !== $organization->id) {
            abort(403);
        }

        // يسمح فقط إذا كان الحجز مؤكدًا
        if ($booking->status !== 'confirmed') {
            return back();
        }

        $booking->update([
            'status' => 'no_show',
        ]);

        return back()->with('warning', 'تم تسجيل أن الزبون لم يحضر الموعد');
    }
}
