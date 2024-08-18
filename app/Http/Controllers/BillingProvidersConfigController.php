<?php

namespace App\Http\Controllers;

use App\Models\BillingProvidersConfig;
use App\Services\Internal\BillingProvidersConfig\ListBillingProvidersConfigService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BillingProvidersConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(ListBillingProvidersConfigService $service)
    {
        return response($service->execute(auth()->id()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param BillingProvidersConfig $billingProvidersConfig
     * @return Response
     */
    public function show(BillingProvidersConfig $billingProvidersConfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BillingProvidersConfig $billingProvidersConfig
     * @return Response
     */
    public function update(Request $request, BillingProvidersConfig $billingProvidersConfig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BillingProvidersConfig $billingProvidersConfig
     * @return Response
     */
    public function destroy(BillingProvidersConfig $billingProvidersConfig)
    {
        //
    }
}
