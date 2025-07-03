<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('numero_factura')->unique(); //autogenerado
            $table->string('periodo_mes');
            $table->string('periodo_anio');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->text('detalle');
            $table->decimal('importe_total',10,2);
            $table->date('fecha_emision');
            $table->string('condicion_pago');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
