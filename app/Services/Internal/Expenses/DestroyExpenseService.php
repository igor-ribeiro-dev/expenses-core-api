<?php

namespace App\Services\Internal\Expenses;

use App\Models\Expenses;

class DestroyExpenseService {

    public function run($expenseId) {
        Expenses::query()->whereKey($expenseId)->delete();
    }

}