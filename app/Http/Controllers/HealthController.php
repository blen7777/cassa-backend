<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            DB::connection()->getPdo();

            return response()->json([
                'ok' => true,
                'app' => config('app.name'),
                'connection' => config('database.default'),
                'database' => DB::connection()->getDatabaseName(),
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'ok' => false,
                'connection' => config('database.default'),
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
