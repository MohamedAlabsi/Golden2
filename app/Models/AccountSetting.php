<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountSetting extends Model
{
    use HasFactory;

    protected $table='account_settings';

    protected $fillable = [
        'show_movies_only',
        'show_movies_all',
        'show_series_only',
        'show_series_all',
        'notification',
        'active',
    ]; 
}
