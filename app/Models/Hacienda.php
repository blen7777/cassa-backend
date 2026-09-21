<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function lotes(): HasMany
    {
        return $this->hasMany(Lote::class);
    }
}
