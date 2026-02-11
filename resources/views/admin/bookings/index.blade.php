@extends('layouts.admin')

@section('title', 'Booking Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- <h4 class="mb-0">Booking Management</h4> -->
          @can('create bookings')
        <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Booking
        </a>
        @endcan
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" value="{{ request('customer_name') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="customer_email" class="form-control" placeholder="Customer Email" value="{{ request('customer_email') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="tour_name" class="form-control" placeholder="Tour Name" value="{{ request('tour_name') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Tour</th>
                            <th>People</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Booking Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>
                                <strong>{{ $booking->customer_name }}</strong><br>
                                <small>{{ $booking->customer_email }}</small>
                            </td>
                            <td>{{ $booking->tour->name }}</td>
                            <td>{{ $booking->people_count }}</td>
                            <td>${{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                     @can('edit bookings')
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                          @can('delete bookings')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endcan
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection