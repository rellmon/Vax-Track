<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class HealthCheckController extends Controller
{
    /**
     * Application health check endpoint
     * Simple check - just verify the application is responsive
     * Heavy database checks happen during migrations
     */
    public function check(): JsonResponse
    {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now()->toIso8601String(),
            'application' => config('app.name'),
            'version' => '1.0.0',
        ], 200);
    }
}
