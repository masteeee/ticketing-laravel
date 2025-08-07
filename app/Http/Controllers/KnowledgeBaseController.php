<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $keyword    = $request->query('search');
        $categoryId = $request->query('category');

        // Eager-load tree sampai 3 level + filter keyword pada relasi articles
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
            'children.children.children' // supaya chain rekursifnya lengkap
        ])->get();

        $recentArticles  = Article::latest()->take(5)->get();
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();

        // ===== Halaman kategori spesifik (?category=ID) =====
        if ($categoryId) {
            // cari kategori di tree root
            $roots            = $tree->where('parent_id', null);
            $currentCategory  = $this->findCategoryRecursive($roots, (int) $categoryId);

            if (!$currentCategory) {
                // tidak ketemu, tampilkan kosong supaya tidak error
                return view('public.knowledge-base', [
                    'categories'      => collect(),
                    'articles'        => collect(),
                    'currentCategory' => null,
                    'recentArticles'  => $recentArticles,
                    'popularArticles' => $popularArticles,
                    'keyword'         => $keyword,
                ]);
            }

            $totalArticles = $this->countArticlesRecursive($currentCategory);

            // jika hanya 1 artikel → langsung ke artikel itu
            if ($totalArticles === 1) {
                $first = $this->getFirstArticleRecursive($currentCategory);
                if ($first) {
                    return redirect()->route('articles.show', $first->id);
                }
            }

            // tampilkan grid sub-kategori + grid artikel (recursive)
            $articles = $this->collectArticlesRecursive($currentCategory);

            // filter lagi berdasarkan keyword bila ada (karena collectArticlesRecursive mengambil semua)
            if ($keyword) {
                $articles = $articles->filter(function ($a) use ($keyword) {
                    $hay = mb_strtolower(($a->title ?? '').' '.($a->content ?? ''));
                    return str_contains($hay, mb_strtolower($keyword));
                })->values();
            }

            return view('public.knowledge-base', [
                // Sections untuk panel atas:
                'categories'      => $currentCategory->children ?? collect(),
                // Artikel grid:
                'articles'        => $articles,
                'currentCategory' => $currentCategory,
                'recentArticles'  => $recentArticles,
                'popularArticles' => $popularArticles,
                'keyword'         => $keyword,
            ]);
        }

        // ===== Halaman root (tanpa ?category) =====
        $roots = $tree->where('parent_id', null);

        // Jika ada keyword, hanya tampilkan kategori yang punya hasil (di level mana pun)
        if ($keyword) {
            $roots = $roots->filter(fn ($c) => $this->hasArticlesRecursive($c))->values();
        }

        return view('public.knowledge-base', [
            'categories'      => $roots,      // grid kategori root
            'articles'        => collect(),   // root tidak tampilkan artikel grid
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

    private function collectArticlesRecursive($category): Collection
    {
        $all = collect();
        if ($category->articles) {
            $all = $all->merge($category->articles);
        }
        foreach (($category->children ?? collect()) as $child) {
            $all = $all->merge($this->collectArticlesRecursive($child));
        }
        // unik berdasarkan id (jaga-jaga jika eager load ganda)
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

    public function showCategory(Request $request)
    {
        $categoryId = $request->query('category');
        $keyword    = $request->query('search');
    
        $category = Category::with(['articles', 'children.articles', 'children.children', 'parent'])
            ->findOrFail($categoryId);
    
        // Artikel **hanya di kategori ini** (tanpa anak-anak)
        $articles = $category->articles;
    
        // Filter jika ada keyword
        if ($keyword) {
            $articles = $articles->filter(function ($a) use ($keyword) {
                $hay = strtolower(($a->title ?? '') . ' ' . ($a->content ?? ''));
                return str_contains($hay, strtolower($keyword));
            });
        }
    
        // Jika kategori tidak punya sub-kategori dan hanya 1 artikel → langsung redirect
        if ($articles->count() === 1 && $category->children->count() === 0) {
            return redirect()->route('public.articles.show', $articles->first()->id);
        }
    
        $recentArticles  = Article::latest()->take(5)->get();
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
    
        // Generate breadcrumb
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
                $category = $category->parent; // relasi parent
            }

            return $breadcrumbs;
        }
        public function show($slug)
        {
            $article = Article::where('slug', $slug)->firstOrFail();

            // Breadcrumb berdasarkan kategori
            $breadcrumbs = collect([]);
            $cat = $article->category;
            while ($cat) {
                $breadcrumbs->prepend($cat);
                $cat = $cat->parent;
            }

            // Related Articles (kategori yang sama)
            $relatedArticles = Article::where('category_id', $article->category_id)
                ->where('id', '!=', $article->id)
                ->limit(5)
                ->get();

            // Ambil heading H2 / H3 dari konten untuk sidebar dan tambahkan ID
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
