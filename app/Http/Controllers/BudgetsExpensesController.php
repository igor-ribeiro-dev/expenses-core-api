<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Rules\BelongsToUser;
use App\Services\Internal\Expenses\DestroyExpenseService;
use App\Services\Internal\Expenses\ListExpensesService;
use App\Services\Internal\Expenses\ShowExpenseService;
use App\Services\Internal\Expenses\StoreExpensesParam;
use App\Services\Internal\Expenses\StoreExpensesService;
use App\Services\Internal\Expenses\UpdateExpenseParam;
use App\Services\Internal\Expenses\UpdateExpenseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BudgetsExpensesController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(int $budget, ListExpensesService $service) {
        $expenses = $service->run($budget, auth()->user()->isAdmin() ? null : auth()->id());

        return response($expenses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(int $budget, Request $request, StoreExpensesService $service, StoreExpensesParam $expensesParam) {

        $request->merge(compact('budget'));

        $this->validate($request, [
            'description' => ['required', 'min:3'],
            'value' => ['required', 'numeric', 'gte:1'],
            'barcode_slip' => ['numeric', 'digits_between:48,49'],
            'expiration' => ['required', 'date_format:d/m/Y'],
            'recurrent' => ['required', 'boolean'],
            'budget' => new BelongsToUser('budgets')
        ]);


        $expensesParam
            ->setDescription($request->description)
            ->setValue($request->value)
            ->setBarcodeSlip($request->barcode_slip)
            ->setExpiration($request->expiration)
            ->setRecurrent($request->recurrent)
            ->setCreatedBy(auth()->id())
            ->setBudgetId($budget);

        $service->run($expensesParam);

        return response($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $expense
     * @return Response
     */
    public function show(int $budget, int $expense, Request $request, ShowExpenseService $service) {

        $request->merge(compact('budget', 'expense'));

        $this->validate($request, [
            'budget' => new BelongsToUser('budgets'),
            'expense' => [
                new BelongsToUser('expenses'),
                $this->getExpenseBelongsToBudgetValidation($budget)
            ],
        ]);

        $expense = $service->run($expense);

        return response($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $budget, $expense, UpdateExpenseService $service, UpdateExpenseParam $expenseParam) {
        $request->merge(compact('budget', 'expense'));

        $this->validate($request, [
            'budget' => new BelongsToUser('budgets'),
            'expense' => [
                new BelongsToUser('expenses'),
                $this->getExpenseBelongsToBudgetValidation($budget)
            ],
        ]);

        $expenseParam->fill($request->all())->setId($expense);

        $service->run($expenseParam);

        return response()->noContent(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $budget, $expense, DestroyExpenseService $service) {

        $request->merge(compact('budget', 'expense'));

        $this->validate($request, [
            'expense' => [
                'exists:expenses,id',
                $this->getExpenseBelongsToBudgetValidation($budget),
                new BelongsToUser('expenses')
            ]
        ]);

        $service->run($expense);

        return response()->noContent(204);
    }

    /**
     * Obtém a implementação que valida se a despesa pertence ao orçamento.
     * @param $budgetId
     * @return Closure
     */
    protected function getExpenseBelongsToBudgetValidation($budgetId): Closure {
        return function(string $attribute, $value, callable $fail) use ($budgetId) {
            $belongs = $this->doesExpenseBelongsToBudget($budgetId, $value);

            if( ! $belongs) {
                $fail('The '.$attribute.' does not belongs to given budget');
            }
        };
    }

    protected function doesExpenseBelongsToBudget($budgetId, $expenseId): bool {
        return Expenses::query()
            ->whereKey($expenseId)
            ->where('budget_id', $budgetId)
            ->exists();
    }

}
