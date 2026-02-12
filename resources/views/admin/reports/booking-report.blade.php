@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Booking Report</h2>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">Search & Filters</div>
        <div class="card-body">
            <form action="{{ route('admin.booking-report') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label>Customer Search</label>
                        <input type="text" name="customer_search" class="form-control" 
                               placeholder="Name or Email" value="{{ request('customer_search') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" 
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Tour</label>
                        <select name="tour_id" class="form-control">
                            <option value="">All Tours</option>
                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}" {{ request('tour_id') == $tour->id ? 'selected' : '' }}>
                                    {{ $tour->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary mt-4">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Export Button -->
    <div class="mb-3">
        <form action="{{ route('admin.export-booking-report') }}" method="POST">
            @csrf
            <input type="hidden" name="customer_search" value="{{ request('customer_search') }}">
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="hidden" name="tour_id" value="{{ request('tour_id') }}">
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export to PDF
            </button>
        </form>
    </div>

    <!-- Report Table -->
    <div class="card">
        <div class="card-header">Booking List</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Tour</th>
                            <th>Booking Date</th>
                            <th>Travel Dates</th>
                            <th>People</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Special Requests</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>
                                    <div><strong>{{ $booking->customer_name }}</strong></div>
                                    <small>{{ $booking->customer_email }}</small>
                                </td>
                                <td>{{ $booking->tour->name }}</td>
                                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    {{ $booking->tour->start_date->format('M d') }} - 
                                    {{ $booking->tour->end_date->format('M d, Y') }}
                                </td>
                                <td>{{ $booking->people_count }}</td>
                                <td>${{ number_format($booking->total_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->special_requests)
                                        <button class="btn btn-sm btn-info" data-bs-toggle="tooltip" 
                                                title="{{ $booking->special_requests }}">
                                            View
                                        </button>
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No bookings found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $bookings->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endsection