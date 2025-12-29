<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\WorkingHour;
use App\Models\Booking;
use App\Models\Service;



class OrganizationController extends Controller
{
    public function show($slug)
{
    $organization = Organization::with([
        'services',
        'reviews.user' // 👈 تحميل التقييمات مع اسم صاحب التقييم
    ])
    ->where('slug', $slug)
    ->where('is_active', true)
    ->firstOrFail();

    // ⭐ حساب متوسط التقييم
    $averageRating = round($organization->reviews->avg('rating'), 1);
    $reviewsCount  = $organization->reviews->count();

    return view('organization.show', compact(
        'organization',
        'averageRating',
        'reviewsCount'
    ));
}


  public function services($slug)
{
    $organization = Organization::where('slug', $slug)
        ->with('services')
        ->firstOrFail();

    $workingDays = WorkingHour::where('organization_id', $organization->id)
        ->whereNotNull('start_time')
        ->whereNotNull('end_time')
        ->orderBy('day_of_week')
        ->get()
        ->map(function ($day) {
            $day->day_name = $this->arabicDayName($day->day_of_week);
            return $day;
        });

    return view('organization.services', compact(
        'organization',
        'workingDays'
    ));
}

public function times($slug, Service $service, Request $request)
{
    $organization = Organization::where('slug', $slug)->firstOrFail();

    $date = $request->get('date', now()->toDateString());

    $dayNumber = \Carbon\Carbon::parse($date)->dayOfWeek; // 0 = الأحد

    // 🕒 دوام اليوم
    $workingHour = WorkingHour::where('organization_id', $organization->id)
        ->where('day_of_week', $dayNumber)
        ->first();

    if (!$workingHour || !$workingHour->start_time || !$workingHour->end_time) {
        return view('organization.times', [
            'organization' => $organization,
            'service'      => $service,
            'times'        => [],
            'date'         => $date,
        ]);
    }

    $duration = (int) $service->duration;

    $start = \Carbon\Carbon::parse($workingHour->start_time);
    $end   = \Carbon\Carbon::parse($workingHour->end_time);

    // ⛔ الأوقات المشغولة
    $busyTimes = \App\Models\BusyTime::where('organization_id', $organization->id)
        ->where('date', $date)
        ->get();

    $times = [];

    while ($start->copy()->addMinutes($duration)->lte($end)) {

        $currentStart = $start->format('H:i:s');
        $currentEnd   = $start->copy()->addMinutes($duration)->format('H:i:s');

        // ❌ محجوز
        $isBooked = Booking::where('organization_id', $organization->id)
            ->where('booking_date', $date)
            ->where('start_time', $currentStart)
            ->where('status', 'confirmed')
            ->exists();

        // ❌ مشغول
        $isBusy = $busyTimes->contains(function ($busy) use ($currentStart, $currentEnd) {
            return $currentStart < $busy->end_time &&
                   $currentEnd   > $busy->start_time;
        });

        if (!$isBooked && !$isBusy) {
            $times[] = $start->format('H:i');
        }

        $start->addMinutes($duration);
    }

    return view('organization.times', compact(
        'organization',
        'service',
        'times',
        'date'
    ));
}


private function arabicDayName($dayNumber)
{
    return [
        0 => 'السبت',
        1 => 'الأحد',
        2 => 'الاثنين',
        3 => 'الثلاثاء',
        4 => 'الأربعاء',
        5 => 'الخميس',
        6 => 'الجمعة',
    ][$dayNumber] ?? '';
}




}
