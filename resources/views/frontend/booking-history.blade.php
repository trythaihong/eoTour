@extends('layouts.app')

@section('title', 'My Booking History - EO Tour')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">My Booking History</h2>
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Tours
            </a>
        </div>

        @if($bookings->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h4>No Bookings Yet</h4>
                    <p class="text-muted">You haven't made any bookings yet. Explore our amazing tours!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Browse Tours</a>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Tour</th>
                                    <th>Booking Date</th>
                                    <th>People</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>
                                        <strong>{{ $booking->tour->name }}</strong><br>
                                        <small class="text-muted">
                                            {{ $booking->tour->start_date->format('M d, Y') }} - 
                                            {{ $booking->tour->end_date->format('M d, Y') }}
                                        </small>
                                    </td>
                                    <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                    <td>{{ $booking->people_count }}</td>
                                    <td>${{ number_format($booking->total_price, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $booking->status }} text-danger">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                                data-bs-target="#bookingModal{{ $booking->id }}">
                                            <i class="fas fa-eye"></i> Details
                                        </button>
                                    </td>
                                </tr>

                                <!-- Booking Details Modal -->
                                <div class="modal fade" id="bookingModal{{ $booking->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Booking #{{ $booking->id }} Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Tour Information</h6>
                                                        <p class="mb-1"><strong>Tour:</strong> {{ $booking->tour->name }}</p>
                                                        <p class="mb-1"><strong>Duration:</strong> {{ $booking->tour->duration }} days</p>
                                                        <p class="mb-1"><strong>Dates:</strong> {{ $booking->tour->start_date->format('M d, Y') }} to {{ $booking->tour->end_date->format('M d, Y') }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Booking Information</h6>
                                                        <p class="mb-1"><strong>Booking Date:</strong> {{ $booking->created_at->format('M d, Y') }}</p>
                                                        <p class="mb-1"><strong>People:</strong> {{ $booking->people_count }}</p>
                                                        <p class="mb-1"><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
                                                        <p class="mb-1"><strong>Status:</strong> 
                                                            <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                @if($booking->special_requests)
                                                    <div class="mt-3">
                                                        <h6>Special Requests</h6>
                                                        <p class="mb-0">{{ $booking->special_requests }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        @endif
    </div>
</section>
@endsection