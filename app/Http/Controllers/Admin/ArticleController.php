<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index() {
        $articles = Article::with('category')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:10240', // Increased to 10MB
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $validated['created_by'] = Auth::id();

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article) {
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:10240', // Increased to 10MB
        ]);

        if ($request->hasFile('thumbnail')) {
            // Hapus file lama jika ada
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article) {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();
        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    public function show(Article $article)
{
    // ambil category parent dan breadcrumb
    $category = $article->category;
    $breadcrumbs = collect([]);

    if ($category) {
        while ($category) {
            $breadcrumbs->prepend($category);
            $category = $category->parent;
        }
    }

    return view('public.articles.show', compact('article', 'breadcrumbs'));
}


    
}
