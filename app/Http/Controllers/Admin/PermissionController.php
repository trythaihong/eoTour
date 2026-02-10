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
            if (!auth()->user()->hasRole('admin')) {
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
        $permission->delete();
        
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}