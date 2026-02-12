@extends('layouts.app')

@section('title', 'Book ' . $tour->name . ' - EO Tour')

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tour.show', $tour) }}">{{ $tour->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Book Now</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Complete Your Booking</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('booking.store', $tour) }}" method="POST">
                            @csrf
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Tour Information</h6>
                                            <div class="d-flex align-items-start mb-3">
                                                @if($tour->image)
                                                    <img src="{{ asset('storage/' . $tour->image) }}" 
                                                         alt="{{ $tour->name }}" 
                                                         class="rounded me-3" width="80" height="80" style="object-fit: cover;">
                                                @endif
                                                <div>
                                                    <h5 class="mb-1">{{ $tour->name }}</h5>
                                                    <p class="text-muted mb-1">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        {{ $tour->start_date->format('M d, Y') }} - {{ $tour->end_date->format('M d, Y') }}
                                                    </p>
                                                    <p class="mb-0">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $tour->duration }} days
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Your Information</h6>
                                            <p class="mb-1"><strong>Name:</strong> {{ auth()->user()->name }}</p>
                                            <p class="mb-1"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                            <p class="mb-0"><strong>Phone:</strong> {{ auth()->user()->phone ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="people_count" class="form-label">Number of People *</label>
                                        <select class="form-select @error('people_count') is-invalid @enderror" 
                                                id="people_count" name="people_count" required>
                                            <option value="">Select number of people</option>
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ old('people_count') == $i ? 'selected' : '' }}>
                                                    {{ $i }} {{ $i == 1 ? 'person' : 'people' }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('people_count')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="special_requests" class="form-label">Special Requests (Optional)</label>
                                        <textarea class="form-control @error('special_requests') is-invalid @enderror" 
                                                  id="special_requests" name="special_requests" 
                                                  rows="3" placeholder="Any dietary requirements, accessibility needs, or other requests...">{{ old('special_requests') }}</textarea>
                                        @error('special_requests')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                           

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('tour.show', $tour) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Tour
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-lock me-2"></i>Complete Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Booking Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tour Price (per person):</span>
                            <span class="fw-bold">${{ number_format($tour->price, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span>Number of People:</span>
                            <span id="summary-people">1</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="h5">Total Amount:</span>
                            <span class="h4 text-primary" id="summary-total">${{ number_format($tour->price, 2) }}</span>
                        </div>
                        
                        <div class="text-center mt-4">
                            <i class="fas fa-shield-alt fa-2x text-success mb-3"></i>
                            <p class="text-muted small mb-0">Secure booking • Best price guarantee • 24/7 customer support</p>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
    // Update booking summary in real-time
    const pricePerPerson = {{ $tour->price }};
    const peopleCountSelect = document.getElementById('people_count');
    const summaryPeople = document.getElementById('summary-people');
    const summaryTotal = document.getElementById('summary-total');

    function updateSummary() {
        const peopleCount = parseInt(peopleCountSelect.value) || 1;
        const totalPrice = pricePerPerson * peopleCount;
        
        summaryPeople.textContent = peopleCount;
        summaryTotal.textContent = '$' + totalPrice.toFixed(2);
    }

    peopleCountSelect.addEventListener('change', updateSummary);
    
    // Initial update
    updateSummary();
</script>
@endsection
@endsection