<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortOption extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'key', 'name','is_default'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
