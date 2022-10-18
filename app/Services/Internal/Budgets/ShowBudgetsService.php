<?php

namespace App\Services\Internal\Budgets;

use App\Models\Budget;

class ShowBudgetsService {
    public function run($budgetId, $ownerId = null) {

        $query = Budget::query()->whereKey($budgetId);

        if($ownerId) {
            $query->where('created_by', $ownerId);
        }

        return $query->first();
    }
}