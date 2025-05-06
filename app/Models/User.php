<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Pastikan ini di-import
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Tambahkan HasFactory dan Notifiable

    protected $fillable = [
        'nama_lengkap',
        'full_name',
        'username',
        'email',
        'password',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function news()
    {
        return $this->hasMany(News::class, 'user_id');
    }   

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}