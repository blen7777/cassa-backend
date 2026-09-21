<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $table = 'responsables';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'estatus',
    ];

    protected function casts(): array
    {
        return [
            'estatus' => 'boolean',
        ];
    }
}
