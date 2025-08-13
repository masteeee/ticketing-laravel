<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $keyword    = $request->query('search');
        $categoryId = $request->query('category');

        // Eager load tree
        $withArticles = function ($q) use ($keyword) {
            if ($keyword) {
                $q->where(function ($s) use ($keyword) {
                    $s->where('title', 'like', "%{$keyword}%")
                      ->orWhere('content', 'like', "%{$keyword}%");
                });
            }
        };

        $tree = Category::with([
            'articles'                       => $withArticles,
            'children.articles'              => $withArticles,
            'children.children.articles'     => $withArticles,
            'children.children.children.articles' => $withArticles,
            'children.children.children'
        ])->get();

        $recentArticles  = Article::latest()->take(5)->get();
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();

        // ===== Jika ada kategori yang dipilih =====
        if ($categoryId) {
            $roots           = $tree->where('parent_id', null);
            $currentCategory = $this->findCategoryRecursive($roots, (int) $categoryId);

            if (!$currentCategory) {
                return view('public.knowledge-base', [
                    'categories'      => collect(),
                    'articles'        => collect(),
                    'currentCategory' => null,
                    'recentArticles'  => $recentArticles,
                    'popularArticles' => $popularArticles,
                    'keyword'         => $keyword,
                ]);
            }

            // ✅ FIX: Hanya redirect jika kategori tidak punya child dan artikelnya hanya 1
            if ($currentCategory->children->count() === 0 && $currentCategory->articles->count() === 1) {
                return redirect()->route('articles.show', $currentCategory->articles->first()->id);
            }

            // Ambil artikel dari kategori + anak-anaknya
            $articles = $this->collectArticlesRecursive($currentCategory);

            // Filter jika ada keyword
            if ($keyword) {
                $articles = $articles->filter(function ($a) use ($keyword) {
                    $hay = mb_strtolower(($a->title ?? '').' '.($a->content ?? ''));
                    return str_contains($hay, mb_strtolower($keyword));
                })->values();
            }

            return view('public.knowledge-base', [
                'categories'      => $currentCategory->children ?? collect(),
                'articles'        => $articles,
                'currentCategory' => $currentCategory,
                'recentArticles'  => $recentArticles,
                'popularArticles' => $popularArticles,
                'keyword'         => $keyword,
            ]);
        }

        // ===== Halaman root =====
        $roots = $tree->where('parent_id', null);
        if ($keyword) {
            $roots = $roots->filter(fn ($c) => $this->hasArticlesRecursive($c))->values();
        }

        return view('public.knowledge-base', [
            'categories'      => $roots,
            'articles'        => collect(),
            'currentCategory' => null,
            'recentArticles'  => $recentArticles,
            'popularArticles' => $popularArticles,
            'keyword'         => $keyword,
        ]);
    }

    /* ================== Helper rekursif ================== */

    private function hasArticlesRecursive($category): bool
    {
        if ($category->articles && $category->articles->isNotEmpty()) return true;
        foreach (($category->children ?? collect()) as $child) {
            if ($this->hasArticlesRecursive($child)) return true;
        }
        return false;
    }

    private function collectArticlesRecursive($category): Collection
    {
        $all = collect();
        if ($category->articles) {
            $all = $all->merge($category->articles);
        }
        foreach (($category->children ?? collect()) as $child) {
            $all = $all->merge($this->collectArticlesRecursive($child));
        }
        return $all->unique('id')->values();
    }

    private function findCategoryRecursive($categories, int $id): ?Category
    {
        foreach ($categories as $cat) {
            if ((int) $cat->id === $id) return $cat;
            $found = $this->findCategoryRecursive(($cat->children ?? collect()), $id);
            if ($found) return $found;
        }
        return null;
    }

    private function countArticlesRecursive($category): int
    {
        $count = ($category->articles ?? collect())->count();
        foreach (($category->children ?? collect()) as $child) {
            $count += $this->countArticlesRecursive($child);
        }
        return $count;
    }

    private function getFirstArticleRecursive($category): ?Article
    {
        if ($category->articles && $category->articles->count() > 0) {
            return $category->articles->first();
        }
        foreach (($category->children ?? collect()) as $child) {
            $a = $this->getFirstArticleRecursive($child);
            if ($a) return $a;
        }
        return null;
    }

    public function showCategory(Request $request)
    {
        $categoryId = $request->query('category');
        $keyword    = $request->query('search');

        $category = Category::with(['articles', 'children.articles', 'children.children', 'parent'])
            ->findOrFail($categoryId);

        $articles = $category->articles;

        if ($keyword) {
            $articles = $articles->filter(function ($a) use ($keyword) {
                $hay = strtolower(($a->title ?? '') . ' ' . ($a->content ?? ''));
                return str_contains($hay, strtolower($keyword));
            });
        }

        // ✅ FIX juga di sini: redirect hanya jika tidak punya child
        if ($category->children->count() === 0 && $articles->count() === 1) {
            return redirect()->route('public.articles.show', $articles->first()->id);
        }

        $recentArticles  = Article::latest()->take(5)->get();
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();

        $breadcrumbs = $this->getCategoryBreadcrumb($category);

        return view('public.knowledge-base-category', [
            'category'        => $category,
            'articles'        => $articles,
            'recentArticles'  => $recentArticles,
            'popularArticles' => $popularArticles,
            'breadcrumbs'     => $breadcrumbs,
        ]);
    }

    private function getCategoryBreadcrumb($category)
    {
        $breadcrumbs = collect([]);
        while ($category) {
            $breadcrumbs->prepend($category);
            $category = $category->parent;
        }
        return $breadcrumbs;
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $breadcrumbs = collect([]);
        $cat = $article->category;
        while ($cat) {
            $breadcrumbs->prepend($cat);
            $cat = $cat->parent;
        }

        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->limit(5)
            ->get();

        preg_match_all('/<h[23].*?>(.*?)<\/h[23]>/', $article->content, $matches);
        $headings = collect($matches[1] ?? [])->map(function ($text, $i) {
            return ['id' => 'heading-'.$i, 'text' => strip_tags($text)];
        });

        $content = $article->content;
        $headingIndex = 0;
        $content = preg_replace_callback('/<h([23])(.*?)>(.*?)<\/h[23]>/', function($matches) use (&$headingIndex) {
            $headingIndex++;
            return '<h' . $matches[1] . $matches[2] . ' id="heading-' . ($headingIndex - 1) . '">' . $matches[3] . '</h' . $matches[1] . '>';
        }, $content);

        $article->content = $content;

        return view('public.articles.show', compact('article', 'breadcrumbs', 'relatedArticles', 'headings'));
    }

    public function search(Request $request)
    {
        $keyword = $request->query('search');
        $articles = Article::where('title', 'like', "%{$keyword}%")
            ->orWhere('content', 'like', "%{$keyword}%")
            ->get();

        $recentArticles  = Article::latest()->take(5)->get();
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();

        return view('public.knowledge-base-search', compact('articles', 'keyword', 'recentArticles', 'popularArticles'));
    }
}
