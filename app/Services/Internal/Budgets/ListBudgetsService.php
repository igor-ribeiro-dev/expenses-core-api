<?php

namespace App\Services\Internal\Budgets;

use App\Models\Budget;

class ListBudgetsService {

    public function run($ownerId = null) {
        $query = Budget::query();

        if($ownerId) {
            $query->where('created_by', $ownerId);
        }

        return $query->get(['id', 'description', 'created_at']);
    }

}