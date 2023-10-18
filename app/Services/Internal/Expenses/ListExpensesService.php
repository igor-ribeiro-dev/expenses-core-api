<?php

namespace App\Services\Internal\Expenses;

use App\Models\Expenses;

class ListExpensesService {
    public function run($ownerId = null) {

        $query = Expenses::query();

        $query->with(['last_recurrence', 'budget']);

        if($ownerId) {
            $query->where('created_by', $ownerId);
        }

        return $query->get();
    }
}
