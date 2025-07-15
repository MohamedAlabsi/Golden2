<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'entertainment_id',
        'user_id',
        'active',

    ];

    public function entertainment()
    {
        return $this->belongsTo(Entertainment::class);
    }




}
