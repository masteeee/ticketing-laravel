<?php
namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index() {
        $articles = Article::paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'created_by' => Auth::id(), 
        ]);
    
        return redirect()->route('admin.articles.index')->with('success', 'Artikel ditambahkan');
    }

    public function edit(Article $article) {
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        $article->update($request->all());
        return redirect()->route('admin.articles.index')->with('success', 'Artikel diupdate');
    }

    public function destroy(Article $article) {
        $article->delete();
        return back()->with('success', 'Artikel dihapus');
    }

    public function show(\App\Models\Article $article) {
        return view('articles.show', compact('article'));
    }
}
