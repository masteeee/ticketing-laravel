<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('departments', 'public');
        }
    
        Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'logo_url' => $logoPath,
        ]);
    
        return redirect()->route('admin.departments.index')->with('success', 'Department berhasil ditambahkan.');
    }

    public function edit(Request $request, Department $department)
    {
        
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('departments', 'public');
            $department->logo_url = $logoPath;
        }
    
        $department->name = $request->name;
        $department->description = $request->description;
        $department->save();
        return redirect()->route('admin.departments.index')->with('success', 'Department updated!');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted!');
    }
}
