<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';

    protected $fillable = [
        'hacienda_id',
        'nombre',
        'hectareas',
        'estatus',
    ];

    protected function casts(): array
    {
        return [
            'hectareas' => 'decimal:2',
            'estatus' => 'boolean',
        ];
    }
}
