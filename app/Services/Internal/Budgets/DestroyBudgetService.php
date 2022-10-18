<?php

namespace App\Services\Internal\Budgets;

use App\Models\Budget;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyBudgetService {

    public function run($budgetId, $ownerId) {

        $query = Budget::query()->whereKey($budgetId);

        if($ownerId) {
            $query->where('created_by', $ownerId);
        }

        if($query->doesntExist()) {
            throw new ModelNotFoundException('Budget not found.');
        }

        $query->delete();
    }
}