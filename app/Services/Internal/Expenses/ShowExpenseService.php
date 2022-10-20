<?php

namespace App\Services\Internal\Expenses;

use App\Models\Expenses;

class ShowExpenseService {

    public function run($expenseId) {
        return Expenses::find($expenseId);
    }
}