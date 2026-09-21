<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    public function index(Request $request)
    {
        $query = Responsable::query()->orderBy('created_at', 'desc');

        if ($request->filled('estatus')) {
            $query->where('estatus', $request->boolean('estatus'));
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'apellido' => ['nullable', 'string', 'max:150'],
            'correo' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'estatus' => ['boolean'],
        ]);

        $data['estatus'] = $data['estatus'] ?? true;

        $responsable = Responsable::create($data);

        return response()->json($responsable, 201);
    }

    public function show(Responsable $responsable)
    {
        return response()->json($responsable);
    }

    public function update(Request $request, Responsable $responsable)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'apellido' => ['nullable', 'string', 'max:150'],
            'correo' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'estatus' => ['boolean'],
        ]);

        $responsable->update($data);

        return response()->json($responsable);
    }

    public function destroy(Responsable $responsable)
    {
        $responsable->delete();

        return response()->json(null, 204);
    }
}
