<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusyTime;

class BusyTimeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date'       => 'required|date',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'reason'     => 'nullable|string',
        ]);

        BusyTime::create([
            'organization_id' => auth()->user()->organization->id,
            'date'            => $request->date,
            'start_time'      => $request->start_time,
            'end_time'        => $request->end_time,
            'reason'          => $request->reason,
        ]);

        return back()->with('success', 'تمت إضافة الوقت المشغول بنجاح');
    }

    public function destroy(BusyTime $busyTime)
    {
        $busyTime->delete();

        return back()->with('success', 'تم حذف الوقت المشغول');
    }
}
