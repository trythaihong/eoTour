@extends('layouts.admin')

@section('title', 'Edit Permission')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Permission: {{ $permission->name }}</h4>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Permissions
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $permission->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="group" class="form-label">Group *</label>
                            <input type="text" class="form-control @error('group') is-invalid @enderror" 
                                   id="group" name="group" value="{{ old('group', $permission->group) }}" required>
                            @error('group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection