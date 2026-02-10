@extends('layouts.admin')

@section('title', 'Role Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- <h4 class="mb-0">Role Management</h4> -->
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Role
        </a>
    </div>

    <!-- Roles Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>#{{ $role->id }}</td>
                            <td>
                                <strong>{{ $role->name }}</strong>
                            </td>
                            <td>
                                @if($role->permissions->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($role->permissions as $permission)
                                            <span class="badge bg-secondary">{{ $permission->name }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">No permissions</span>
                                @endif
                            </td>
                            <td>{{ $role->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline delete-form">
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
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection