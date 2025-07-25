<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;

class KnowledgeBaseController extends Controller
{
    public function index()
    {
        $keyword = request('search');
        $categories = Category::with([
            'articles' => function($q) use ($keyword) {
                if ($keyword) {
                    $q->where(function($q2) use ($keyword) {
                        $q2->where('title', 'like', "%$keyword%")
                           ->orWhere('content', 'like', "%$keyword%");
                    });
                }
            },
            'children.children.children.articles' // load nested recursively
        ])->get();

        // Filter categories: hanya tampilkan kategori yang punya artikel hasil search atau punya child yang punya artikel hasil search
        if ($keyword) {
            $categories = $categories->filter(function($cat) use ($keyword) {
                $hasArticle = $cat->articles->isNotEmpty();
                $hasChildWithArticle = $cat->children->filter(fn($c) => $c->articles->isNotEmpty())->isNotEmpty();
                return $hasArticle || $hasChildWithArticle;
            });
        }

        $recentArticles = Article::latest()->take(5)->get();
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();

        return view('public.knowledge-base', compact('categories', 'recentArticles', 'popularArticles', 'keyword'));
    }
}
