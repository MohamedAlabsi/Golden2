<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movies2 extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $schema = [
        'none' => 'string',
    ];

    public function getRows()
    {
        return [];
    }
}
