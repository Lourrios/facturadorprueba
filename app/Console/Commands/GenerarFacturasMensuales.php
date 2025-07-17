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
        $resultados = app(FacturaService::class)->procesarFacturasRecurrentes();

        foreach ($resultados as $dato) {
            $this->info("Factura enviada: {$dato['factura']} a {$dato['email']}");
        }

        $this->info('Facturación recurrente completada.');
    }

}
