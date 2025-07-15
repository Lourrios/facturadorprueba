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
        'fecha_membresia',

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

    public function mesesDeMembresia(): int
    {
        if (!$this->fecha_membresia) return 0;

        return \Carbon\Carbon::parse($this->fecha_membresia)->diffInMonths(now()) + 1;
    }


    public function obtenerDescuentoPorMembresia(): float
    {
        $meses = $this->mesesDeMembresia();

        if ($meses >= 1 && $meses <= 3) {
            return 0.10; // 10%
        } elseif ($meses >= 4 && $meses <= 12) {
            return 0.05; // 5%
        }

        return 0.0;
    }




}
