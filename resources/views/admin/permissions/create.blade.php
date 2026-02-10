@extends('layouts.admin')

@section('title', 'Create Permission')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- <h4 class="mb-0">Create New Permission</h4> -->
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Permissions
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Example: create tours, edit bookings, etc.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="group" class="form-label">Group *</label>
                            <input type="text" class="form-control @error('group') is-invalid @enderror" 
                                   id="group" name="group" value="{{ old('group') }}" required>
                            @error('group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Example: Tour, Booking, User, etc.</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection