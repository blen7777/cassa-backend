<?php

namespace App\Http\Controllers;

use App\Models\Hacienda;
use App\Models\Lote;
use App\Models\Responsable;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function summary(): JsonResponse
    {
        return response()->json([
            'haciendas_activas' => Hacienda::where('estatus', true)->count(),
            'lotes_activos' => Lote::where('estatus', true)->count(),
            'responsables_activos' => Responsable::where('estatus', true)->count(),
        ]);
    }
}
