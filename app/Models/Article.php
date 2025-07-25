<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
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
}
