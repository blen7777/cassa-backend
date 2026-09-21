<?php

namespace App\Http\Controllers;

use App\Models\Hacienda;
use App\Models\Lote;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index(Request $request, Hacienda $hacienda)
    {
        $query = $hacienda->lotes()->orderBy('created_at', 'desc');

        if ($request->filled('estatus')) {
            $query->where('estatus', $request->boolean('estatus'));
        }

        return response()->json($query->get());
    }

    public function store(Request $request, Hacienda $hacienda)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'hectareas' => ['nullable', 'numeric', 'min:0'],
            'estatus' => ['boolean'],
        ]);

        $data['estatus'] = $data['estatus'] ?? true;
        $data['hacienda_id'] = $hacienda->id;

        $lote = Lote::create($data);

        return response()->json($lote, 201);
    }

    public function update(Request $request, Hacienda $hacienda, Lote $lote)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'hectareas' => ['nullable', 'numeric', 'min:0'],
            'estatus' => ['boolean'],
        ]);

        $lote->update($data);

        return response()->json($lote);
    }

    public function destroy(Hacienda $hacienda, Lote $lote)
    {
        $lote->delete();

        return response()->json(null, 204);
    }
}
