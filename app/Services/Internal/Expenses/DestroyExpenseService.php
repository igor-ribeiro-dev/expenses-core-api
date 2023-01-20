<?php

namespace App\Services\Internal\Expenses;

use App\Models\Expenses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DestroyExpenseService {

    public function run($expenseId) {
        try {
            DB::beginTransaction();
            $expense = Expenses::findOrFail($expenseId);
            $expense->recurrences()->delete();
            $expense->delete();
            DB::commit();
        } catch (QueryException | ModelNotFoundException $e) {
            DB::rollBack();
            throw $e;
        }
    }

}