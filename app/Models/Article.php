<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'category_id',
        'created_by',
        'thumbnail',
    ];

    // relasi ke kategori
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // (opsional) relasi ke user pembuat
    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
{
    static::creating(function ($article) {
        if (empty($article->slug)) {
            $article->slug = Str::slug($article->title);
        }
    });

    static::updating(function ($article) {
        if (empty($article->slug)) {
            $article->slug = Str::slug($article->title);
        }
    });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
