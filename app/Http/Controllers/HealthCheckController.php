<?php

namespace App\Http\Controllers;

use App\Services\External\ExpenseFeederService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    public function check(ExpenseFeederService $queueService)
    {
        $healthy = [
            'app' => 'healthy',
            'database' => 'healthy',
            'queue' =>  $queueService->testConnection() ? 'healthy' : 'unhealthy',
        ];

        try {
            DB::select('SELECT NOW()');
        } catch (\Throwable $e) {
            $healthy['database'] = 'unhealthy';
        }

        return response()->json($healthy);
    }
}
