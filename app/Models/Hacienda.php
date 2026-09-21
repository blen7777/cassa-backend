<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hacienda extends Model
{
    protected $table = 'haciendas';

    protected $fillable = [
        'nombre',
        'ubicacion',
        'estatus',
    ];

    protected function casts(): array
    {
        return [
            'estatus' => 'boolean',
        ];
    }
}
