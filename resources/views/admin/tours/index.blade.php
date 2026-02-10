@extends('layouts.admin')

@section('title', 'Tour Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- <h4 class="mb-0">Tour Management</h4> -->
        <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Tour
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.tours.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search tours..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tours Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Tour Name</th>
                            <th>Price</th>
                            <th>Dates</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tours as $tour)
                        <tr>
                            <td>#{{ $tour->id }}</td>
                            <td>
                                @if($tour->image)
                                    <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}" width="50" height="50" class="rounded">
                                @else
                                    <img src="https://via.placeholder.com/50" alt="No image" class="rounded">
                                @endif
                            </td>
                            <td>
                                <strong>{{ $tour->name }}</strong><br>
                                <small class="text-muted">{{ Str::limit($tour->description, 50) }}</small>
                            </td>
                            <td>${{ number_format($tour->price, 2) }}</td>
                            <td>
                                {{ $tour->start_date->format('M d, Y') }}<br>
                                <small>to {{ $tour->end_date->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <span class="badge badge-{{ $tour->status }}">{{ ucfirst($tour->status) }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tour.show', $tour) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.tours.edit', $tour) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
                {{ $tours->links() }}
            </div>
        </div>
    </div>
</div>
@endsection