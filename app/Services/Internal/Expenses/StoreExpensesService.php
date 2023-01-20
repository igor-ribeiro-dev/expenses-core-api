<?php

namespace App\Services\Internal\Expenses;

use App\Models\Expenses;
use Illuminate\Support\Facades\DB;

class StoreExpensesService {
    public function run(StoreExpensesParam $expensesParam) {
        try {
            DB::beginTransaction();
            $expense = new Expenses();
            $expense->fill([
                'description' => $expensesParam->getDescription(),
                'recurrent' => $expensesParam->getRecurrent(),
                'created_by' => $expensesParam->getCreatedBy(),
                'budget_id' => $expensesParam->getBudgetId(),
            ]);
            $expense->save();
            $expense->recurrences()->create([
                'value' => $expensesParam->getValue(),
                'barcode_slip' => $expensesParam->getBarcodeSlip(),
                'expiration' => $expensesParam->getExpiration(true),
                'paid' => $expensesParam->getPaid(),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}