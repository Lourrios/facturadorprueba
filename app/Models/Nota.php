<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable=['factura_id','tipo','importe','motivo'];

    public function factura(){
        return $this->belongsTo(Factura::class);
    }
}
