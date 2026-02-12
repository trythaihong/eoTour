@extends('layouts.app')

@section('title', 'EO Tour - Explore Amazing Tours')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Discover Amazing Tours With EO Tour</h1>
            <p class="lead mb-4">Explore the world's most beautiful destinations with our curated tour packages</p>
            <a href="#tours" class="btn btn-primary btn-lg">Explore Tours</a>
        </div>
    </section>

  

    <!-- All Tours -->
    <section id="tours" class="py-5">
        <div class="container">
            <h2 class="section-title">Available Tours</h2>
            
            <div class="row">
                @foreach($tours as $tour)
                <div class="col-md-4 mb-4">
                    <div class="tour-card">
                        @if($tour->image)
                            <img src="{{ asset('storage/' . $tour->image) }}" class="card-img-top" alt="{{ $tour->name }}">
                        @else
                            <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="{{ $tour->name }}">
                        @endif
                        <div class="card-body">
                            <span class="badge-status badge-{{ $tour->status }}">{{ ucfirst($tour->status) }}</span>
                            <h5 class="card-title">{{ $tour->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($tour->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="price">${{ number_format($tour->price, 2) }}</span>
                                    <span class="duration ms-2">{{ $tour->duration }} days</span>
                                </div>
                                <div>
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $tour->start_date->format('M d') }}
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('tour.show', $tour) }}" class="btn btn-outline-primary">View Details</a>
                                @auth
                                    <a href="{{ route('booking.create', $tour) }}" class="btn btn-primary">Book Now</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">Login to Book</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tours->links() }}
            </div>
        </div>
    </section>

    
@endsection


