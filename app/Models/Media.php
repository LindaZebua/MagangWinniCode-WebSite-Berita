<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';
    protected $primaryKey = 'media_id';
    protected $fillable = [
        'file_path',
        'file_type',
        'news_id',
    ];

    /**
     * Get the news that owns the media.
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}