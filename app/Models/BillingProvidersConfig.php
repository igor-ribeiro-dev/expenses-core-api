<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingProvidersConfig extends Model {
    use HasFactory;

    protected $fillable = [
        'created_by',
        'billing_provider_id',
        'config',
    ];

    protected $casts = [
        'config' => 'array'
    ];
}
