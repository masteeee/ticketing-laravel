<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index() {
        $permissions = Permission::paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create() {
        return view('admin.permissions.create');
    }

    public function store(Request $request) {
        $request->validate(Permission::rules());
        Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission ditambahkan');
    }

    public function edit(Permission $permission) {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission) {
        $request->validate(Permission::updateRules($permission->id));
        $permission->update(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission diupdate');
    }

    public function destroy(Permission $permission) {
        $permission->delete();
        return back()->with('success', 'Permission dihapus');
    }
} 