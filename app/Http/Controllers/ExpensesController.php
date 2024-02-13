<?php

namespace App\Http\Controllers;

use App\Services\Internal\Expenses\ListExpensesService;
use App\Services\Internal\Expenses\TogglePaidExpensesService;
use Illuminate\Http\Response;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListExpensesService $service)
    {
        $expenses = $service->run(auth()->user()->isAdmin() ? null : auth()->id());

        return response($expenses);
    }

    protected function togglePaid($expenseId, TogglePaidExpensesService $service): Response
    {
        $paid = $service->run($expenseId);

        return response(['paid' => $paid], 200);
    }
}
