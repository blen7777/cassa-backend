<?php

namespace App\Http\Controllers;

use App\Models\Hacienda;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HaciendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Hacienda::query()->orderBy('created_at', 'desc');

        if ($request->filled('estatus')) {
            $query->where('estatus', $request->boolean('estatus'));
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'estatus' => ['boolean'],
        ]);

        $data['estatus'] = $data['estatus'] ?? true;

        $hacienda = Hacienda::create($data);

        return response()->json($hacienda, 201);
    }

    public function show(Hacienda $hacienda)
    {
        return response()->json($hacienda);
    }

    public function update(Request $request, Hacienda $hacienda)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'estatus' => ['boolean'],
        ]);

        $hacienda->update($data);

        return response()->json($hacienda);
    }

    public function destroy(Hacienda $hacienda)
    {
        try {
            $hacienda->delete();
        } catch (QueryException $exception) {
            return response()->json([
                'message' => 'No se puede eliminar la hacienda porque tiene lotes asociados.',
            ], 409);
        }

        return response()->json(null, 204);
    }
}
