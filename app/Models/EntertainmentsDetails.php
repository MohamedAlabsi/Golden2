<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntertainmentsDetails extends Model
{
    use HasFactory;
    protected $table = 'entertainments_details';

    protected $fillable = ['tmdb_id', 'details','from_admin'];

    protected $casts = [
        'details' => 'array',
        'from_admin' => 'boolean',
    ];
}
