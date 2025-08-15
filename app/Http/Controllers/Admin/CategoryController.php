<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request) {
        // Get all categories for dropdowns and relationships
        $allCategories = Category::all();
        
        // Build query with search and filter
        $query = Category::query();
        
        // Search by name (case-insensitive)
        if ($request->filled('search')) {
            $searchTerm = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        }
        
        // Filter by parent
        if ($request->filled('parent_filter')) {
            if ($request->parent_filter === 'root') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent_filter);
            }
        }
        
        // Paginate results
        $parentCategories = $query->paginate(10)->appends($request->query());
        
        // Pass collections to the view
        return view('admin.categories.index', compact('allCategories', 'parentCategories'));
    }
    
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        // Redirect ke halaman terakhir supaya kategori baru terlihat
        $lastPage = ceil(Category::whereNull('parent_id')->count() / 10);
        return redirect()->route('categories.index', ['page' => $lastPage])
                         ->with('success', 'Kategori ditambahkan');
    }

    public function edit(Category $category)
    {
        $allCategories = Category::all();
        return view('admin.categories.edit', compact('category', 'allCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($request->only('name', 'parent_id'));
        return redirect()->route('categories.index')->with('success', 'Kategori diupdate');
    }

    public function destroy(Category $category)
    {
        // Optional: cek jika memiliki child
        if ($category->children()->count()) {
            return back()->with('error', 'Kategori memiliki subkategori, tidak bisa dihapus');
        }

        $category->delete();
        return back()->with('success', 'Kategori dihapus');
    }
}
