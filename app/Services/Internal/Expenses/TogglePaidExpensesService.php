<?php

namespace App\Services\Internal\Expenses;

use App\Models\Expenses;
use LogicException;

class TogglePaidExpensesService
{
    public function run($expenseId)
    {
        $expense = Expenses::query()->with('last_recurrence')->findOrFail($expenseId);

        if( ! $expense->last_recurrence) {
            throw new LogicException(trans('expense_without_recurrence'), 500);
        }

        $expense->last_recurrence->paid = !$expense->last_recurrence->paid;

        if($expense->last_recurrence->paid) {
            $expense->last_recurrence->paid_at = now();
        } else {
            $expense->last_recurrence->paid_at = null;
        }

        $expense->last_recurrence->save();

        return !!$expense->last_recurrence->paid;
    }
}
