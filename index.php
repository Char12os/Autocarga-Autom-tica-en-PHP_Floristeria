<?php

require_once 'vendor/autoload.php';

use App\Modelos\Producto;
use App\Modelos\Usuario;
use App\Servicios\Carrito;

// Productos de la florería
$rosas   = new Producto('Ramo de Rosas Rojas', 25.00, 10);
$tulipan = new Producto('Arreglo de Tulipanes', 30.00, 5);
$girasol = new Producto('Girasoles', 15.00, 0);

// Cliente
$cliente = new Usuario('Ana López', 'ana@email.com');

// Carrito
$carrito = new Carrito($cliente);

// Agregar flores
$carrito->agregar($rosas, 2);
$carrito->agregar($tulipan, 1);
$carrito->agregar($girasol, 1);

// Mostrar resumen
$carrito->mostrarResumen();

echo "\n Sistema de Florería funcionando correctamente \n";