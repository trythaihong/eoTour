@extends('layouts.admin')

@section('title', 'Create Booking')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- <h4 class="mb-0">Create New Booking</h4> -->
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Bookings
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tour_id" class="form-label">Select Tour *</label>
                            <select class="form-select @error('tour_id') is-invalid @enderror" 
                                    id="tour_id" name="tour_id" required>
                                <option value="">Select a tour</option>
                                @foreach($tours as $tour)
                                    <option value="{{ $tour->id }}" 
                                            data-price="{{ $tour->price }}"
                                            {{ old('tour_id') == $tour->id ? 'selected' : '' }}>
                                        {{ $tour->name }} - ${{ number_format($tour->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tour_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name *</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                   id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Customer Email *</label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                   id="customer_email" name="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" required>
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="people_count" class="form-label">Number of People *</label>
                            <input type="number" class="form-control @error('people_count') is-invalid @enderror" 
                                   id="people_count" name="people_count" value="{{ old('people_count', 1) }}" min="1" required>
                            @error('people_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Booking Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Special Requests</label>
                            <textarea class="form-control @error('special_requests') is-invalid @enderror" 
                                      id="special_requests" name="special_requests" rows="3">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Price Calculation</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small>Tour Price:</small>
                                        <h5 id="tour-price">$0.00</h5>
                                    </div>
                                    <div class="col-6">
                                        <small>Total Price:</small>
                                        <h5 id="total-price">$0.00</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function calculateTotalPrice() {
        const tourSelect = document.getElementById('tour_id');
        const peopleCount = document.getElementById('people_count').value;
        const selectedOption = tourSelect.options[tourSelect.selectedIndex];
        
        if (selectedOption && selectedOption.value) {
            const tourPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const people = parseInt(peopleCount) || 1;
            const totalPrice = tourPrice * people;
            
            document.getElementById('tour-price').textContent = '$' + tourPrice.toFixed(2);
            document.getElementById('total-price').textContent = '$' + totalPrice.toFixed(2);
        }
    }

    // Event listeners
    document.getElementById('tour_id').addEventListener('change', calculateTotalPrice);
    document.getElementById('people_count').addEventListener('input', calculateTotalPrice);
    
    // Initial calculation
    calculateTotalPrice();
</script>
@endsection
@endsection