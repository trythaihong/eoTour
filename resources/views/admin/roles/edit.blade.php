@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Role: {{ $role->name }}</h4>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Roles
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $role->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="mb-3">Permissions</h5>
                    <div class="row">
                        @foreach($permissions as $group => $groupPermissions)
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">{{ $group }}</h6>
                                </div>
                                <div class="card-body">
                                    @foreach($groupPermissions as $permission)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}" 
                                               id="permission{{ $permission->id }}"
                                               {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection