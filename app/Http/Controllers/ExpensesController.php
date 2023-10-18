<?php

namespace App\Http\Controllers;

use App\Services\Internal\Expenses\ListExpensesService;
use Illuminate\Http\Request;

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
}
