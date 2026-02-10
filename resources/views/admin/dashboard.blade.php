@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total Tours</h6>
                            <h3 class="stat-number mb-0">{{ $stats['total_tours'] }}</h3>
                        </div>
                        <div class="icon-circle bg-primary-light">
                            <i class="fas fa-route text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total Bookings</h6>
                            <h3 class="stat-number mb-0">{{ $stats['total_bookings'] }}</h3>
                        </div>
                        <div class="icon-circle bg-success-light">
                            <i class="fas fa-calendar-check text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total Income</h6>
                            <h3 class="stat-number mb-0">${{ number_format($stats['total_income'], 2) }}</h3>
                        </div>
                        <div class="icon-circle bg-warning-light">
                            <i class="fas fa-dollar-sign text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Pending Bookings</h6>
                            <h3 class="stat-number mb-0">{{ $stats['pending_bookings'] }}</h3>
                        </div>
                        <div class="icon-circle bg-info-light">
                            <i class="fas fa-clock text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Bookings</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Customer</th>
                                    <th>Tour</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->customer_name }}</td>
                                    <td>{{ $booking->tour->name }}</td>
                                    <td>${{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                    <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Tours -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Popular Tours</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($popularTours as $tour)
                        <div class="list-group-item border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $tour->name }}</h6>
                                    <small class="text-muted">{{ $tour->bookings_count }} bookings</small>
                                </div>
                                <span class="badge bg-primary">${{ number_format($tour->price, 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection