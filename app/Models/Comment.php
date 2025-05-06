<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    protected $fillable = [
        'comment_text',
        'commented_at',
        'news_id',
        'user_id',
    ];

    public function news()
{
    return $this->belongsTo(News::class, 'news_id', 'news_id'); // Asumsi primary key tabel 'news' adalah 'id'
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}