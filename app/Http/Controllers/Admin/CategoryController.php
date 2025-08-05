<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required']);
        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);
        return redirect()->route('categories.index')->with('success', 'Kategori ditambahkan');
    }

    public function edit(Category $category) {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category) {
        $request->validate(['name' => 'required']);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori diupdate');
    }

    public function destroy(Category $category) {
        $category->delete();
        return back()->with('success', 'Kategori dihapus');
    }
}
