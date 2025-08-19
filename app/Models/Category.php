<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Article;

class Category extends Model
{
    protected $fillable = ['name' , 'parent_id'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
                    ->with(['children', 'articles']);;
    }
    public function totalArticlesCount()
{
    // Hitung semua artikel di kategori ini termasuk anak-anaknya
    $count = $this->articles->count();

    foreach ($this->children as $child) {
        $count += $child->totalArticlesCount();
    }

    return $count;
}

public function firstArticleView()
{
    // Kalau tidak ada child, dan ada artikel → ambil artikel pertama
    if ($this->children->count() === 0 && $this->articles->count() > 0) {
        return route('public.articles.show', $this->articles->first()->id);
    }

    // Kalau ada child → arahkan ke list kategori
    return route('public.knowledge.category', ['category' => $this->id]);
}

}