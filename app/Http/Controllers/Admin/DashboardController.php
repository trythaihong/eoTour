<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
       public function __construct()
    {
        $this->middleware(function ($request, $next) {
             if (!auth()->user()->hasRole(['admin', 'subAdmin'])) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }
    public function index()
    {
        $stats = [
            'total_tours' => Tour::count(),
            'total_bookings' => Booking::count(),
            'total_income' => Booking::where('status', 'confirmed')->sum('total_price'),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'active_tours' => Tour::where('status', 'active')->count(),
            'completed_tours' => Tour::where('status', 'completed')->count()
        ];

        $recentBookings = Booking::with(['tour', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $popularTours = Tour::withCount(['bookings' => function($query) {
            $query->where('status', 'confirmed');
        }])
        ->orderBy('bookings_count', 'desc')
        ->take(5)
        ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'popularTours'));
    }
}