<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Factura extends Model
{
    protected $fillable =[
        'cliente_id',
        'numero_factura',
        'periodo_mes',
        'periodo_anio',
        'fecha_desde',
        'fecha_hasta',
        'detalle',
        'importe_total',
        'fecha_emision',
        'condicion_pago',
    ];
  
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
        
    }

}
