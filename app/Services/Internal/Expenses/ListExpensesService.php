<?php

namespace App\Services\Internal\Expenses;

use App\Models\Expenses;

class ListExpensesService {
    public function run($budgetId, $ownerId = null) {
        $query = Expenses::query()->where('budget_id', $budgetId);

        $query->with('last_recurrence');

        if($ownerId) {
            $query->where('created_by', $ownerId);
        }

        return $query->get();
    }
}