<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Spatie\Translatable\HasTranslations;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;
   use HasTranslations;

    protected $fillable = [
        'name',
        'in_home'
    ];

    public $translatable = ['name','is_default'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'array',
    ];

    public function genres()
    {
        return $this->hasMany(Genres::class);
    }
}
