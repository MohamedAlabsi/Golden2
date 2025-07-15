<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntertainmentExtra extends Model
{
    use HasFactory;
    protected $fillable = [
        'entertainment_id',
        'videos',
        'cast',
        'reviews',
        'images',
        'collection',
        'seasons',
    ];

    protected $casts = [
        'videos' => 'array',
        'cast' => 'array',
        'reviews' => 'array',
        'images' => 'array',
        'seasons' => 'array',
    ];

    public function entertainment()
    {
        return $this->belongsTo(Entertainment::class);
    }
}
