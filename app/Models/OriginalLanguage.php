<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OriginalLanguage extends Model
{
   use HasTranslations;
    use HasFactory;

    protected $fillable = [
        'name',
        'value'
    ];

    public array $translatable = [
        'name',
     ];


}
