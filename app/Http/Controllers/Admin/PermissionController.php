<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
              if (!auth()->user()->hasRole(['admin', 'subAdmin'])) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }
    public function index()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        if (!auth()->user()->can('create permissions')) {
                    abort(403,"don't have permission to create permission");
                }
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'group' => 'required|string'
        ]);

        Permission::create([
            'name' => $request->name,
            'group' => $request->group,
            'guard_name' => 'web'
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        if (!auth()->user()->can('edit permissions')) {
                    abort(403,"don't have permission to edit permission");
                }
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'group' => 'required|string'
        ]);

        $permission->update([
            'name' => $request->name,
            'group' => $request->group
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        if (!auth()->user()->can('delete permissions')) {
                    abort(403,"don't have permission to delete permission");
                }
        $permission->delete();
        
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}