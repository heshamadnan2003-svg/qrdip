<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Review;

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        // منع التقييم إن لم يكن الحجز منتهي
        abort_if($booking->status !== 'completed', 403);

        // منع التقييم المكرر
        if ($booking->review) {
            return redirect()
                ->route('customer.bookings')
                ->with('error', __('messages.review_already_submitted'));
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        abort_if($booking->status !== 'completed', 403);

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'booking_id'      => $booking->id,
            'organization_id' => $booking->organization_id,
            'rating'          => $request->rating,
            'comment'         => $request->comment,
        ]);

        return redirect()
            ->route('customer.bookings')
            ->with('success', __('messages.review_submitted'));
    }
}
