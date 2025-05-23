<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'news_id';
    protected $fillable = ['title', 'content', 'published_at', 'category_id', 'user_id', 'gambar_berita'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'news_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'news_id');
    }
}