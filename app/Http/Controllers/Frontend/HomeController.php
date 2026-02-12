<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        

        $tours = Tour::where('status', 'active')->paginate(9);

        return view('frontend.home', compact( 'tours'));
    }

    public function showTour(Tour $tour)
    {
        return view('frontend.tour-detail', compact('tour'));
    }

    public function bookingHistory()
    {
        $bookings = auth()->user()->bookings()->with('tour')->latest()->paginate(10);
        return view('frontend.booking-history', compact('bookings'));
    }
}