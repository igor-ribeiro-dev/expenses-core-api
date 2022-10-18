<?php

namespace App\Services\Internal\Budgets;

use App\Models\Budget;

class StoreBudgetService {

    public function run(StoreBudgetParam $budgetParam) {

        $budget = new Budget();

        $budget->fill([
            'description' => $budgetParam->getDescription(),
            'created_by' => $budgetParam->getOwner(),
        ]);

        $budget->save();
    }
}