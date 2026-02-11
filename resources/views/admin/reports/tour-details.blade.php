@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Booking Details for: {{ $tour->name }}</h2>
            <a href="{{ route('admin.booking-by-tour') }}" class="btn btn-link">← Back to Tours</a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">Filters</div>
        <div class="card-body">
            <form action="{{ route('admin.tour-details', $tour->id) }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" 
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary mt-4">Apply Filters</button>
                        <a href="{{ route('admin.tour-details', $tour->id) }}" class="btn btn-secondary mt-4">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tour Information -->
    <div class="card mb-4">
        <div class="card-header">Tour Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <strong>Description:</strong>
                    <p>{{ $tour->description }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Duration:</strong>
                    <p>{{ $tour->duration }} days</p>
                </div>
                <div class="col-md-4">
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $tour->status == 'active' ? 'success' : ($tour->status == 'completed' ? 'info' : 'secondary') }}">
                        {{ ucfirst($tour->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card">
        <div class="card-header">Bookings ({{ $bookings->total() }})</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Booking Date</th>
                            <th>People Count</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>{{ $booking->customer_name }}</td>
                                <td>{{ $booking->customer_email }}</td>
                                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $booking->people_count }}</td>
                                <td>${{ number_format($booking->total_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No bookings found</td>
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