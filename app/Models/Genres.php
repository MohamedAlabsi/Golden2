<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Genres extends Model
{
   use HasTranslations;
    public $translatable = ['name'];
    use HasFactory;
    protected $table='genres';

    protected $fillable = [
        'tm_id',
        'category_id',
        'name',
        'order',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }}
