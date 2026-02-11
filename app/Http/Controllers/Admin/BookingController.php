<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;

class BookingController extends Controller
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
    public function index(Request $request)
    {
        $query = Booking::with(['tour', 'user']);
        
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', "%{$request->customer_name}%");
        }
        
        if ($request->filled('customer_email')) {
            $query->where('customer_email', 'like', "%{$request->customer_email}%");
        }
        
        if ($request->filled('tour_name')) {
            $query->whereHas('tour', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->tour_name}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $bookings = $query->latest()->paginate(10);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
         if (!auth()->user()->can('create bookings')) {
                    abort(403,"don't have permission to create bookings");
                }
        $tours = Tour::where('status', 'active')->get();
        return view('admin.bookings.create', compact('tours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'people_count' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled',
            'special_requests' => 'nullable|string'
        ]);

        $tour = Tour::findOrFail($validated['tour_id']);
        $validated['total_price'] = $tour->price * $validated['people_count'];
        $validated['user_id'] = auth()->id();

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking)
    {
          if (!auth()->user()->can('edit bookings')) {
                    abort(403,"don't have permission to edit bookings");
                }
        $tours = Tour::where('status', 'active')->get();
        return view('admin.bookings.edit', compact('booking', 'tours'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'people_count' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled',
            'special_requests' => 'nullable|string'
        ]);

        $tour = Tour::findOrFail($validated['tour_id']);
        $validated['total_price'] = $tour->price * $validated['people_count'];

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        // abort_if(!auth()->user()->can('delete bookings'), 403);
          if (!auth()->user()->can('delete bookings')) {
                    abort(403,"don't have permission to delete bookings");
                }
        $booking->delete();
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}