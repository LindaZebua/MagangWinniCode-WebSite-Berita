<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Tambahkan ini

class News extends Model
{
    use HasFactory;

    protected $primaryKey = 'news_id'; // Primary key diset ke 'news_id'
    protected $table = 'news'; // Nama tabel database
     public function getRouteKeyName()
    {
        return 'news_id'; // Ini harus cocok dengan nama kolom di DB
    }

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'content',
        'gambar_berita', // Kolom untuk nama file gambar
        'views',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the category that owns the news.
     */
    public function category()
    {
        // Relasi many-to-one dengan Category. foreign_key: category_id, owner_key: category_id
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Get the user that authored the news.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // 'id' adalah primary key default untuk model User
    }

    /**
     * Get the comments for the news.
     */
    public function comments()
    {
        // Relasi one-to-many dengan Comment. foreign_key: news_id, local_key: news_id
        return $this->hasMany(Comment::class, 'news_id', 'news_id');
    }


    public function media()
    {
        // Contoh relasi one-to-many dengan Media. foreign_key: news_id, local_key: news_id
        return $this->hasMany(Media::class, 'news_id', 'news_id');
    }

  
}
