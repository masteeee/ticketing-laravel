<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create() {
        $permissions = Permission::orderBy('name')->get()->groupBy(function($item) {
            return explode(' ', $item->name)[1] ?? $item->name;
        });
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);
        $role = Role::create(['name' => $request->name]);
        $role->permissions()->sync($request->permissions ?? []);
        return redirect()->route('roles.index')->with('success', 'Role ditambahkan');
    }

    public function edit(Role $role) {
        $permissions = Permission::orderBy('name')->get()->groupBy(function($item) {
            return explode(' ', $item->name)[1] ?? $item->name;
        });
        $role->load('permissions');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role) {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);
        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->permissions ?? []);
        return redirect()->route('roles.index')->with('success', 'Role diupdate');
    }

    public function destroy(Role $role) {
        $role->delete();
        return back()->with('success', 'Role dihapus');
    }
}
