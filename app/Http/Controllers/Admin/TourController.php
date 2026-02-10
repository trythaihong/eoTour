<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasRole('admin')) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $query = Tour::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $tours = $query->latest()->paginate(10);
        
        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        return view('admin.tours.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tours', 'public');
        }

        Tour::create($validated);

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour created successfully.');
    }

    public function edit(Tour $tour)
    {
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($tour->image) {
                Storage::disk('public')->delete($tour->image);
            }
            $validated['image'] = $request->file('image')->store('tours', 'public');
        }

        $tour->update($validated);

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour updated successfully.');
    }

    public function destroy(Tour $tour)
    {
        if ($tour->image) {
            Storage::disk('public')->delete($tour->image);
        }
        
        $tour->delete();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour deleted successfully.');
    }
}