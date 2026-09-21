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

    public function haciendasOverview(): JsonResponse
    {
        $haciendas = Hacienda::withCount([
            'lotes',
            'lotes as lotes_activos_count' => fn ($query) => $query->where('estatus', true),
        ])
            ->withSum('lotes', 'hectareas')
            ->orderBy('nombre')
            ->get()
            ->map(fn ($hacienda) => [
                'id' => $hacienda->id,
                'nombre' => $hacienda->nombre,
                'ubicacion' => $hacienda->ubicacion,
                'estatus' => $hacienda->estatus,
                'lotes_count' => $hacienda->lotes_count,
                'lotes_activos_count' => $hacienda->lotes_activos_count,
                'hectareas_totales' => $hacienda->lotes_sum_hectareas ?? 0,
            ]);

        return response()->json($haciendas);
    }
}
