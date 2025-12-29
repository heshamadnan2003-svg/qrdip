<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\WorkingHour;
use App\Models\BusyTime;
use Illuminate\Http\Request;

class WorkingHourController extends Controller
{
    public function index()
    {
        $organization = auth()->user()->organization;

        // إنشاء سجل لكل يوم (مرة واحدة فقط)
        for ($day = 0; $day <= 6; $day++) {
            WorkingHour::firstOrCreate(
                [
                    'organization_id' => $organization->id,
                    'day_of_week'     => $day,
                ],
                [
                    'start_time' => null,
                    'end_time'   => null,
                ]
            );
        }

        $workingHours = WorkingHour::where('organization_id', $organization->id)
            ->get()
            ->keyBy('day_of_week');

        $busyTimes = BusyTime::where('organization_id', $organization->id)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('manager.working-hours.index', compact(
            'workingHours',
            'busyTimes'
        ));
    }

    public function store(Request $request)
    {
        $organization = auth()->user()->organization;
        $days = $request->input('days', []);

        foreach ($days as $dayOfWeek => $data) {

            $isHoliday = !empty($data['is_holiday']);

            if (!$isHoliday) {
                if (empty($data['start_time']) || empty($data['end_time'])) {
                    return back()
                        ->withErrors([
                            "days.$dayOfWeek" =>
                                'يجب إدخال وقت البداية ووقت النهاية أو تحديد يوم عطلة'
                        ])
                        ->withInput();
                }

                if ($data['end_time'] <= $data['start_time']) {
                    return back()
                        ->withErrors([
                            "days.$dayOfWeek" =>
                                'وقت النهاية يجب أن يكون بعد وقت البداية'
                        ])
                        ->withInput();
                }
            }
        }

        foreach ($days as $dayOfWeek => $data) {

            $isHoliday = !empty($data['is_holiday']);

            WorkingHour::updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'day_of_week'     => $dayOfWeek,
                ],
                [
                    'start_time' => $isHoliday ? null : $data['start_time'],
                    'end_time'   => $isHoliday ? null : $data['end_time'],
                ]
            );
        }

        return back()->with('success', 'تم حفظ أوقات الدوام بنجاح');
    }
}
