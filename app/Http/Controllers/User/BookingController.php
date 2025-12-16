<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($slug, Service $service)
{
    $organization = Organization::where('slug', $slug)->firstOrFail();
    $availableTimes = [];

    return view('booking.create', compact(
        'organization',
        'service',
        'availableTimes'
    ));
}


    /**
     * Store a newly created resource in storage.
     */
   
        public function store(Request $request)
{
    $request->validate([
        'organization_id' => 'required',
        'service_id' => 'required',
        'date' => 'required|date',
        'start_time' => 'required',
    ]);

    $service = Service::findOrFail($request->service_id);

    $startTime = $request->start_time;
    $endTime = date(
        'H:i:s',
        strtotime($startTime . " + {$service->duration_minutes} minutes")
    );

    // 🔴 منع التداخل
    $hasConflict = Booking::where('organization_id', $request->organization_id)
        ->where('date', $request->date)
        ->where('status', 'accepted')
        ->where(function ($q) use ($startTime, $endTime) {
            $q->where('start_time', '<', $endTime)
              ->where('end_time', '>', $startTime);
        })
        ->exists();

    if ($hasConflict) {
        return redirect()->back()
            ->withErrors(['time' => 'هذا الوقت محجوز، الرجاء اختيار وقت آخر']);
    }

    Booking::create([
        'user_id' => Auth::id(),
        'organization_id' => $request->organization_id,
        'service_id' => $service->id,
        'date' => $request->date,
        'start_time' => $startTime,
        'end_time' => $endTime,
        'status' => 'pending',
    ]);

    return redirect()->back()->with('success', 'تم إرسال طلب الحجز');


    }

    private function generateAvailableTimes($organization, $service, $date)
{
    $dayName = date('l', strtotime($date));

    $slots = $organization->timeSlots()
        ->where('day', $dayName)
        ->get();

    $bookings = Booking::where('organization_id', $organization->id)
        ->where('date', $date)
        ->where('status', 'accepted')
        ->get();

    $availableTimes = [];

    foreach ($slots as $slot) {
        $current = strtotime($slot->start_time);
        $end = strtotime($slot->end_time);

        while ($current + ($service->duration_minutes * 60) <= $end) {

            $start = date('H:i:s', $current);
            $finish = date(
                'H:i:s',
                $current + ($service->duration_minutes * 60)
            );

            $conflict = false;

            foreach ($bookings as $booking) {
                if (
                    $start < $booking->end_time &&
                    $finish > $booking->start_time
                ) {
                    $conflict = true;
                    break;
                }
            }

            if (!$conflict) {
                $availableTimes[] = $start;
            }

            $current += 15 * 60; // كل 15 دقيقة
        }
    }

    return $availableTimes;
}


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
