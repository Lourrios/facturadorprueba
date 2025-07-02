<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    protected $table ='pagos';

    protected $fillable=[
        'monto',
        'fecha_pago',
        'metodo_pago',
        'observaciones',
        'factura_id',

    ];

    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }
}
