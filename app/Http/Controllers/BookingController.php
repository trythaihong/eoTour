<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Tour $tour)
    {
        return view('frontend.booking.create', compact('tour'));
    }

    public function store(Request $request, Tour $tour)
    {
       $validated = $request->validate([
    'people_count' => 'required|integer|min:1',
    'special_requests' => 'nullable|string'
    ]);

        $booking = Booking::create([
            'tour_id' => $tour->id,
            'user_id' => auth()->id(),
            'customer_name' => auth()->user()->name,
            'customer_email' => auth()->user()->email,
            'people_count' => $validated['people_count'],
            'total_price' => $tour->price * $validated['people_count'],
            'special_requests' => $validated['special_requests'] ?? null,
            'status' => 'pending'
        ]);

        return redirect()->route('booking.history')
            ->with('success', 'Booking created successfully. Please wait for confirmation.');
    }
}