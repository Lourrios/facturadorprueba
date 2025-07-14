<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use App\Models\Factura;
use Illuminate\Console\Command;
use App\Services\FacturaService;

class GenerarFacturasMensuales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generar-facturas-mensuales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
 

    public function handle()
    {
        $clientes = Cliente::whereNotNull('fecha_membresia')->get();
        $facturaService = new FacturaService();

        foreach ($clientes as $cliente) {
            $existe = Factura::where('cliente_id', $cliente->id)
                ->whereMonth('fecha_emision', now()->month)
                ->whereYear('fecha_emision', now()->year)
                ->exists();

            if ($existe) {
                $this->info("Ya existe una factura este mes para {$cliente->razon_social}");
                continue;
            }

            $numero = $facturaService->generarNumeroFactura($cliente);

            $bonificacion = $facturaService->calcularImporteConBonificacion($cliente, 8000); 

            $factura = $facturaService->crearFactura($cliente, $bonificacion['importe'], $bonificacion['descuento'], $numero);

            $facturaService->enviarFacturaPorMail($factura);

            $this->info("Factura enviada a {$cliente->email}");
        }

        $this->info('Facturación mensual completada.');
    }


}
