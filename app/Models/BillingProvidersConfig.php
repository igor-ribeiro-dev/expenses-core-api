<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function provider(): BelongsTo
    {
        return $this->belongsTo(BillingProvider::class, 'billing_provider_id');
    }
}
