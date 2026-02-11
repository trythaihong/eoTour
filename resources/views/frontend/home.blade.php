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

    <!-- Featured Tours Slider -->
    <section id="feature" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Featured Tours</h2>
            
            <div id="tourCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($featuredTours as $index => $tour)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                @if($tour->image)
                                    <img src="{{ asset('storage/' . $tour->image) }}" class="d-block w-100 rounded" alt="{{ $tour->name }}">
                                @else
                                    <img src="https://via.placeholder.com/600x400" class="d-block w-100 rounded" alt="{{ $tour->name }}">
                                @endif
                            </div>
                            <div class="col-md-6 ">
                                <div class="carousel-caption position-static pt-5 pb-5">
                                    <h3>{{ $tour->name }}</h3>
                                    <p>{{ Str::limit($tour->description, 200) }}</p>
                                    <div class="mb-3">
                                        <span class="price h4">${{ number_format($tour->price, 2) }}</span>
                                        <span class="duration ms-3"><i class="fas fa-calendar-alt me-1"></i> {{ $tour->duration }} days</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="badge badge-active">{{ ucfirst($tour->status) }}</span>
                                        <span class="ms-2"><i class="fas fa-map-marker-alt me-1"></i> {{ $tour->start_date->format('M d, Y') }}</span>
                                    </div>
                                    <a href="{{ route('tour.show', $tour) }}" class="btn btn-primary">View Details</a>
                                    @auth
                                        <a href="{{ route('booking.create', $tour) }}" class="btn btn-success">Book Now</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#tourCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#tourCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
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

@section('scripts')
<script>
    // Initialize carousel
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = new bootstrap.Carousel(document.getElementById('tourCarousel'), {
            interval: 5000
        });
    });
</script>
@endsection