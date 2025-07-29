<?php

namespace App\Services;

use App\Models\Cliente;
use Carbon\Carbon;

class BonificacionService
{
    /**
     * Devuelve el porcentaje de descuento según la antigüedad del cliente
     */
    public function obtenerPorcentajeDescuento(Cliente $cliente): float
    {
        if (!$cliente->fecha_membresia) {
            return 0.0;
        }

        $meses = Carbon::parse($cliente->fecha_membresia)->diffInMonths(now()) + 1;

        if ($meses >= 1 && $meses <= 3) {
            return 0.10; // 10% en los primeros 3 meses
        } elseif ($meses >= 4) {
            return 0.05; // 5% a partir del mes 4 en adelante
        }

        return 0.0; // sin descuento
    }

    /**
     * Aplica el descuento a un importe base y devuelve el resultado
     */
    public function aplicarBonificacion(float $importe, Cliente $cliente): array
    {
        $porcentaje = $this->obtenerPorcentajeDescuento($cliente);
        $importeConDescuento = round($importe * (1 - $porcentaje), 2);

        return [
            'importe_final' => $importeConDescuento,
            'porcentaje' => $porcentaje,
        ];
    }
}
