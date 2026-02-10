@extends('layouts.app')

@section('title', $tour->name . ' - EO Tour')

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $tour->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    @if($tour->image)
                        <img src="{{ asset('storage/' . $tour->image) }}" class="card-img-top" alt="{{ $tour->name }}">
                    @else
                        <img src="https://via.placeholder.com/800x400" class="card-img-top" alt="{{ $tour->name }}">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h1 class="h3 mb-2">{{ $tour->name }}</h1>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-{{ $tour->status }} me-2">{{ ucfirst($tour->status) }}</span>
                                    <span class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $tour->start_date->format('M d, Y') }} - {{ $tour->end_date->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="price h3">${{ number_format($tour->price, 2) }}</div>
                                <small class="text-muted">per person</small>
                            </div>
                        </div>

                        <h5 class="mt-4">Tour Description</h5>
                        <p class="card-text">{{ $tour->description }}</p>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Tour Details</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <strong>Duration:</strong> {{ $tour->duration }} days
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <strong>Start Date:</strong> {{ $tour->start_date->format('F d, Y') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <strong>End Date:</strong> {{ $tour->end_date->format('F d, Y') }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>Quick Facts</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-tag text-primary me-2"></i>
                                        <strong>Status:</strong> 
                                        <span class="badge badge-{{ $tour->status }}">{{ ucfirst($tour->status) }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-users text-primary me-2"></i>
                                        <strong>Bookings:</strong> {{ $tour->bookings_count ?? $tour->bookings->count() }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Book This Tour</h5>
                    </div>
                    <div class="card-body">
                        @auth
                            @if($tour->status == 'active')
                                <form action="{{ route('booking.store', $tour) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="people_count" class="form-label">Number of People</label>
                                        <input type="number" class="form-control" id="people_count" name="people_count" 
                                               min="1" value="1" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="special_requests" class="form-label">Special Requests</label>
                                        <textarea class="form-control" id="special_requests" name="special_requests" 
                                                  rows="3" placeholder="Any special requirements?"></textarea>
                                    </div>

                                    <div class="alert alert-info">
                                        <div class="d-flex justify-content-between">
                                            <span>Total Price:</span>
                                            <strong id="total-price">${{ number_format($tour->price, 2) }}</strong>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                                        <i class="fas fa-calendar-check me-2"></i>Book Now
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-warning">
                                    This tour is not available for booking at the moment.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info">
                                <p class="mb-3">Please login to book this tour.</p>
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">Login</a>
                                <div class="text-center mt-2">
                                    <small>Don't have an account? <a href="{{ route('register') }}">Register here</a></small>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Need Help?</h5>
                    </div>
                    <div class="card-body">
                        <p>Our team is here to help you with any questions about this tour.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                +1 234 567 8900
                            </li>
                            <li>
                                <i class="fas fa-envelope text-primary me-2"></i>
                                info@eotour.com
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
    // Calculate total price based on people count
    const pricePerPerson = {{ $tour->price }};
    const peopleCountInput = document.getElementById('people_count');
    const totalPriceElement = document.getElementById('total-price');

    function calculateTotal() {
        const peopleCount = parseInt(peopleCountInput.value) || 1;
        const totalPrice = pricePerPerson * peopleCount;
        totalPriceElement.textContent = '$' + totalPrice.toFixed(2);
    }

    peopleCountInput.addEventListener('input', calculateTotal);
</script>
@endsection
@endsection