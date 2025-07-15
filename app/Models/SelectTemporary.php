<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectTemporary extends Model
{
    use HasFactory;
 
    protected $table =  'selected_temporaries'  ;

    protected $fillable = [
        'user_id',
        'page_id',
        'data',
    ];


    // تعيين data كنوع json
    protected $casts = [
        'data' => 'json',
    ];
}
