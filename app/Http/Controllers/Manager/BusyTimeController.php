<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusyTime;
use App\Models\Booking;

class BusyTimeController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'date'       => 'required|date',
        'start_time' => 'required',
        'end_time'   => 'required|after:start_time',
    ]);

    $organizationId = auth()->user()->organization->id;

    $conflictingBooking = Booking::where('organization_id', $organizationId)
        ->where('booking_date', $request->date)
        ->where('status', 'confirmed')
        ->where(function ($q) use ($request) {
            $q->whereBetween('start_time', [$request->start_time, $request->end_time])
              ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
              ->orWhere(function ($q) use ($request) {
                  $q->where('start_time', '<=', $request->start_time)
                    ->where('end_time', '>=', $request->end_time);
              });
        })
        ->first();

    // 🟡 يوجد تعارض → نعرض Modal
    if ($conflictingBooking && !$request->has('force')) {
        return back()->with([
            'confirm_block' => true,
            'busy_data'     => $request->all(),
        ]);
    }

    // 🔴 المدير أكد
    if ($conflictingBooking && $request->has('force')) {
        $conflictingBooking->update([
            'status' => 'cancelled',
        ]);
    }

    BusyTime::create([
        'organization_id' => $organizationId,
        'date'            => $request->date,
        'start_time'      => $request->start_time,
        'end_time'        => $request->end_time,
        'reason'          => $request->reason,
    ]);

    return back()->with('success', 'تم إضافة الوقت المحجوب');
}


    public function destroy(BusyTime $busyTime)
    {
        $busyTime->delete();

        return back()->with('success', __('messages.busy_time_deleted'));
    }
}
