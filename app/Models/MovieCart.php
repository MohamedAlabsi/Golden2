<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'device',
        'user_id',
        'status',
        'note',
    ];



    public function items()
    {
        return $this->hasMany(MovieCartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
