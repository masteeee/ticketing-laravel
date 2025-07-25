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
}