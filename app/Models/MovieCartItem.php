<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_cart_id',
        'movie_id',
        'name',
        'image',
        'note',
        'user_id'
    ];

    public function cart()
    {
        return $this->belongsTo(MovieCart::class, 'movie_cart_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
