<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Profile extends Model implements HasMedia
{
    use HasFactory ; 
    use InteractsWithMedia;
    protected $fillable = ['user_id', 'shop_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('shop_logo')->singleFile();
    }
}
