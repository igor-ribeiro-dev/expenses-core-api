<?php

namespace App\Http\Controllers;

use App\Services\Internal\Budgets\DestroyBudgetService;
use App\Services\Internal\Budgets\ListBudgetsService;
use App\Services\Internal\Budgets\ShowBudgetsService;
use App\Services\Internal\Budgets\StoreBudgetParam;
use App\Services\Internal\Budgets\StoreBudgetService;
use App\Services\Internal\Budgets\UpdateBudgetParam;
use App\Services\Internal\Budgets\UpdateBudgetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BudgetsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response|JsonResponse
     */
    public function index(Request $request, ListBudgetsService $service) {
        $user = $request->user();

        $budgets = $service->run($user->isAdmin() ? null : $user->getKey());

        return response()->json($budgets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, StoreBudgetService $service, StoreBudgetParam $budgetParam) {

        $this->validate($request, [
            'description' => ['required', 'min:3']
        ]);

        $budgetParam
            ->setDescription($request->description)
            ->setOwner(auth()->id());

        $service->run($budgetParam);

        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id, ShowBudgetsService $service) {
        $budget = $service->run($id, auth()->user()->isAdmin() ? null : auth()->id());

        if($budget) {
            return response($budget);
        }

        return response()->noContent(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param Request $request
     * @param UpdateBudgetService $service
     * @param UpdateBudgetParam $budgetParam
     * @return Response
     */
    public function update($id, Request $request, UpdateBudgetService $service, UpdateBudgetParam $budgetParam) {

        $this->validate($request, [
            'budget' => 'exists:budgets,id',
            'description' => ['required', 'min:3']
        ]);

        $budgetParam->setDescription($request->description);

        $service->run($id, $budgetParam, auth()->user()->isAdmin() ? null : auth()->id());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id, DestroyBudgetService $service) {
        $service->run($id, auth()->user()->isAdmin() ? null : auth()->id());
        return response()->noContent();
    }
}
