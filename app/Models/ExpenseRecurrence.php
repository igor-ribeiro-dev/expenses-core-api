<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRecurrence extends Model {
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'value',
        'barcode_slip',
        'expiration',
        'paid',
    ];

    protected $casts = [
        'expiration' => 'date'
    ];

    public function expense() {
        return $this->belongsTo(Expenses::class, 'expense_id');
    }
}
