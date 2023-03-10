<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'tag',
    ];

    protected $casts = [
        'params' => 'array'
    ];
}
