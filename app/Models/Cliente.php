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

    public function scopeBuscar($query, $termino)
    {
        if (!empty($termino)) {
            return $query->where(function ($q) use ($termino) {
                $q->where('razon_social', 'like', '%' . $termino . '%')
                ->orWhere('cuil', 'like', '%' . $termino . '%')
                ->orWhere('email', 'like', '%' . $termino . '%')
                ->orWhere('telefono', 'like', '%' . $termino . '%');
            });
        }
        return $query;
    }

}
