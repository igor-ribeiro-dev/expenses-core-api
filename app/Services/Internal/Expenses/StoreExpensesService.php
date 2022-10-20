<?php

namespace App\Services\Internal\Expenses;

use App\Models\Expenses;

class StoreExpensesService {
    public function run(StoreExpensesParam $expensesParam) {
        $expense = new Expenses();

        $expense->fill([
            'description' => $expensesParam->getDescription(),
            'value' => $expensesParam->getValue(),
            'barcode_slip' => $expensesParam->getBarcodeSlip(),
            'expiration' => $expensesParam->getExpiration(true),
            'recurrent' => $expensesParam->getRecurrent(),
            'created_by' => $expensesParam->getCreatedBy(),
            'budget_id' => $expensesParam->getBudgetId(),
        ]);

        $expense->save();
    }
}