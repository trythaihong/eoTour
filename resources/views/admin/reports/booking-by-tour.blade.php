@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Booking by Tour Report</h2>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">Filters</div>
        <div class="card-body">
            <form action="{{ route('admin.booking-by-tour') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" 
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label>Tour Type</label>
                        <select name="tour_type" class="form-control">
                            <option value="">All Types</option>
                            <option value="active" {{ request('tour_type') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('tour_type') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="completed" {{ request('tour_type') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mt-4">Apply Filters</button>
                        <a href="{{ route('admin.booking-by-tour') }}" class="btn btn-secondary mt-4">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Table -->
    <div class="card">
        <div class="card-header">Tours with Booking Count</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tour Name</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Price</th>
                            <th>Total Bookings</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tours as $tour)
                            <tr>
                                <td>{{ $tour->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $tour->status == 'active' ? 'success' : ($tour->status == 'completed' ? 'info' : 'secondary') }}">
                                        {{ ucfirst($tour->status) }}
                                    </span>
                                </td>
                                <td>{{ $tour->start_date->format('Y-m-d') }}</td>
                                <td>{{ $tour->end_date->format('Y-m-d') }}</td>
                                <td>${{ number_format($tour->price, 2) }}</td>
                                <td>{{ $tour->bookings_count }}</td>
                                <td>
                                    <a href="{{ route('admin.tour-details', $tour->id) }}" 
                                       class="btn btn-sm btn-info">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No tours found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $tours->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection