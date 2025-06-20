<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Define the primary key if it's not 'id'
    protected $primaryKey = 'news_id';
      protected $dates = ['updated_at'];

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'news';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'content',
        'gambar_berita', // Assuming this is the column for the image
        'views',
        'published_at',
    ];

    // Cast attributes to native types
    protected $casts = [
        'published_at' => 'datetime', // This is the crucial line to add or ensure it's present
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the category that owns the news.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Get the user that authored the news.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the comments for the news.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'news_id', 'news_id');
    }
public function media()
    {
        return $this->hasMany(Media::class, 'news_id', 'news_id');
    }

    // Mutator for slug generation (optional, but good practice)
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = \Str::slug($value);
    }
}