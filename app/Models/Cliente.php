<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $fillable = [
        'razon_social',
        'cuil',
        'telefono',
        'direccion',
        'email',
        'condicion_iva',
    ];

    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class);
    }
}
