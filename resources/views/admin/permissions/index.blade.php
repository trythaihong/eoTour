@extends('layouts.admin')

@section('title', 'Permission Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
           @can('create permissions')
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Permission
        </a>
        @endcan
    </div>

    <!-- Permissions Table -->
    <div class="card">
        <div class="card-body">
            @foreach($permissions as $group => $groupPermissions)
            <div class="mb-4">
                <h5 class="mb-3">{{ $group }}</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Permission Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupPermissions as $permission)
                            <tr>
                                <td>#{{ $permission->id }}</td>
                                <td>
                                    <strong>{{ $permission->name }}</strong>
                                </td>
                                <td>{{ $permission->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                         @can('edit permissions')
                                        <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                             @can('delete permissions')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endcan
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection