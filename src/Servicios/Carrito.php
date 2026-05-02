<?php

namespace App\Servicios;

use App\Modelos\Producto;
use App\Modelos\Usuario;

// Gestiona el carrito de compras de flores
class Carrito
{
    private $usuario;
    private $items = [];

    public function __construct($usuario)
    {
        $this->usuario = $usuario;
    }

    // Agrega flores al carrito
    public function agregar($producto, $cantidad)
    {
        // Verifica stock
        if (!$producto->hayStock($cantidad)) {
            echo "  No hay suficientes flores para: {$producto->getNombre()}\n";
            return false;
        }

        $this->items[] = ['producto' => $producto, 'cantidad' => $cantidad];

        echo "  Agregado: {$producto->getNombre()} x{$cantidad}\n";
        return true;
    }

    // Calcula el total de la compra
    public function calcularTotal()
    {
        $total = 0.0;

        foreach ($this->items as $item) {
            $total += $item['producto']->getPrecio() * $item['cantidad'];
        }

        return $total;
    }

    // Muestra el resumen del pedido
    public function mostrarResumen()
    {
        echo "\n==============================\n";
        echo "  PEDIDO DE: {$this->usuario->getNombre()}\n";
        echo "==============================\n";

        foreach ($this->items as $item) {
            $subtotal = $item['producto']->getPrecio() * $item['cantidad'];

            echo sprintf("  - %-20s x%d  $%.2f\n",
                $item['producto']->getNombre(),
                $item['cantidad'],
                $subtotal
            );
        }

        echo "------------------------------\n";
        echo sprintf("  TOTAL: $%.2f\n", $this->calcularTotal());
        echo "==============================\n";
    }
}