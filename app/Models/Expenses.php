<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model {

    use HasFactory;

    protected $fillable = [
        'description',
        'value',
        'barcode_slip',
        'expiration',
        'recurrent',
        'created_by',
        'budget_id',
    ];

    public function budget() {
        return $this->belongsTo(Budget::class, 'budget_id');
    }
}
