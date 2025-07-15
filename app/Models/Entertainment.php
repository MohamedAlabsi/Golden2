<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Spatie\Translatable\HasTranslations;
use Spatie\Translatable\HasTranslations;

class Entertainment extends Model
{
    use HasFactory;
   use HasTranslations;
   public $translatable = ['title', 'overview'];
    protected $fillable = [
        'user_id',
        'tmdb_id',
        'collection_id',
        'adult',
        'check',
        'media_type',
        'media_type_id',
        'title',
        'video',
        'overview',
        'genre_ids',
        'popularity',
        'vote_count',
        'poster_path',
        'release_date',
        'vote_average',
        'backdrop_path',
        'original_title',
        'original_language',
        'is_slider'
    ];

    // تحويل الحقول إلى أنواع البيانات الصحيحة
    protected $casts = [
        'adult' => 'boolean',
        'check' => 'boolean',
        'video' => 'boolean',
        'genre_ids' => 'array',
        'popularity' => 'float',
        'vote_count' => 'integer',
        'vote_average' => 'float',
        'release_date' => 'date',
        'title' => 'array',
        'overview' => 'array',
    ];
    public function getGenreNamesAttribute()
    {
        return Genres::whereIn('tm_id', $this->genre_ids)->pluck('name')->toArray();
    }

//    public function details()
//    {
//        return $this->hasOne(EntertainmentsDetails::class, 'tmdb_id', 'tmdb_id');
//    }
    public function details()
    {
        return $this->hasOne(EntertainmentsDetails::class, 'tmdb_id', 'tmdb_id') ;
    }
    public function mediaType()
    {
        return $this->belongsTo(Category::class, 'media_type_id');
    }
    public function originalLanguage()
    {
        return $this->belongsTo(OriginalLanguage::class, 'original_language_id');
    }

    public function similarCollection()
    {

        return $this->hasMany(self::class, 'collection_id', 'collection_id')
            ->where('id', '<>', $this->id);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'media_type_id');
    }
}
