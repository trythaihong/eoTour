<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:subAdmin|admin');
    }

    /**
     * Booking by Tour Report
     */
    public function bookingByTour(Request $request)
    {
         if (!auth()->user()->can('view_report_by_tour')) {
                    abort(403,"don't have permission to view report by tour");
                }
        $query = Tour::withCount(['bookings' => function($q) use ($request) {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
            }
        }])->with(['bookings' => function($q) use ($request) {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
            }
        }]);

        // Filter by tour type (status)
        if ($request->filled('tour_type')) {
            $query->where('status', $request->tour_type);
        }

        $tours = $query->paginate(10);

        return view('admin.reports.booking-by-tour', compact('tours'));
    }

    /**
     * Show tour booking details
     */
    public function tourBookingDetails($id, Request $request)
    {
        $tour = Tour::findOrFail($id);
        
        $query = $tour->bookings()->with('user');

        // Apply date filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $bookings = $query->paginate(10);

        return view('admin.reports.tour-details', compact('tour', 'bookings'));
    }

    /**
     * Booking Report with filters
     */
    public function bookingReport(Request $request)
    {
        if (!auth()->user()->can('View_report_bookings')) {
                    abort(403,"don't have permission to view report bookings");
                }
        $query = Booking::with(['tour', 'user']);

        // Search by customer
        if ($request->filled('customer_search')) {
            $search = $request->customer_search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by tour
        if ($request->filled('tour_id')) {
            $query->where('tour_id', $request->tour_id);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        $tours = Tour::all(); // For filter dropdown

        return view('admin.reports.booking-report', compact('bookings', 'tours'));
    }

    /**
     * Export Booking Report to PDF
     */
    public function exportBookingReportPDF(Request $request)
    {
        $query = Booking::with(['tour', 'user']);

        // Apply same filters as bookingReport
        if ($request->filled('customer_search')) {
            $search = $request->customer_search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        $data = [
            'bookings' => $bookings,
            'filters' => $request->all(),
            'export_date' => now()->format('Y-m-d H:i:s'),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.booking-report', $data);

        return $pdf->download('booking-report-' . now()->format('Y-m-d') . '.pdf');
    }
}