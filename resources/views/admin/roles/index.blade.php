@extends('layouts.admin')

@section('title', 'Role Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
         @can('create role')
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Role
        </a>
        @endcan
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
                                    {{-- Edit Button --}}
                                    @if($role->name !== 'user')
                                        {{-- Show normal edit button for non-user roles --}}
                                         @can('edit role')
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                         @endcan
                                    @else
                                        {{-- Show disabled edit button for user role --}}
                                        <button class="btn btn-sm btn-secondary" disabled title="Cannot edit system role">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endif
                                    
                                    {{-- Delete Button --}}
                                    @if($role->name !== 'user')
                                        {{-- Show delete button for non-user roles --}}
                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                             @can('delete role')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                             @endcan
                                        </form>
                                    @else
                                        {{-- Show disabled delete button for user role --}}
                                        <button class="btn btn-sm btn-secondary" disabled title="Cannot delete system role">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
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