<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $table ='clientes';

    protected $fillable=[
        'cuit',
        'razon_social',
        'direccion',
        'email',
        'telefono',
        'condicion_iva',


    ];

    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class);
    }

    
    public function tieneFacturasAdeudadas(): bool
    {
        foreach ($this->facturas as $factura) {
            if ($factura->estado() === 'Pendiente') {
                return true;
            }
        }

        return false;
    }

}
