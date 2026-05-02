<?php

namespace App\Modelos;

// Representa una flor o arreglo floral
class Producto
{
    private $nombre;
    private $precio;
    private $stock;

    // Inicializa los datos del producto floral
    public function __construct($nombre, $precio, $stock)
    {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock  = $stock;
    }

    // Getters
    public function getNombre() { return $this->nombre; }
    public function getPrecio() { return $this->precio; }
    public function getStock()  { return $this->stock; }

    // Verifica disponibilidad
    public function hayStock($cantidad)
    {
        return $this->stock >= $cantidad;
    }

    // Representación en texto
    public function __toString()
    {
        return sprintf(
            '[Flor] %s | Precio: $%.2f | Stock: %d unidades',
            $this->nombre, $this->precio, $this->stock
        );
    }
}