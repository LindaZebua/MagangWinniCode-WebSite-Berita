<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
   public function getRouteKeyName()
    {
        return 'category_id'; // Ini harus cocok dengan nama kolom di DB
    }
    protected $fillable = [
        'category_name',
    ];

    // App\Models\Category.php
    public function news()
    {
        return $this->hasMany(News::class, 'category_id', 'category_id'); // Sesuaikan kolom kunci jika berbeda
    }
}
