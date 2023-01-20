<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model {

    use HasFactory;

    protected $fillable = [
        'description',
        'recurrent',
        'created_by',
        'budget_id',
        'provider_config_id',
    ];

    protected $hidden = [
        'created_by',
        'budget_id',
        'provider_config_id',
    ];


    public function budget() {
        return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function recurrences() {
        return $this->hasMany(ExpenseRecurrence::class, 'expense_id');
    }

    public function last_recurrence() {
        return $this->hasOne(ExpenseRecurrence::class, 'expense_id')
            ->latest('expiration');
    }

    public function provider_config() {
        return $this->belongsTo(BillingProvidersConfig::class, 'provider_config_id');
    }
}
