<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;

class KnowledgeBaseController extends Controller
{
    public function index()
    {
        $categories = Category::with('articles')->get();

        $recentArticles = Article::latest()->take(5)->get();

        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();

        return view('public.knowledge-base', compact('categories', 'recentArticles', 'popularArticles'));
    }
}
