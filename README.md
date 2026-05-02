## Autocarga Automatica en PHP 
Este proyecto consiste en la implementación de la carga automática de clases (Autoload) en PHP utilizando Composer bajo el estándar PSR-4. Su objetivo principal es mejorar la organización del código y la gestión de dependencias, eliminando la necesidad de incluir archivos manualmente mediante include o require.
## Estructura archivo
<img width="210" height="479" alt="image" src="https://github.com/user-attachments/assets/0e74dbb2-2abb-460c-8875-bd4616575973" />

## Creación del proyecto
El proyecto fue creado manualmente mediante comandos en la terminal para definir la estructura base de carpetas y archivos, incluyendo:
```bash
C:\wamp64\www>mkdir php-autoload-psr4

C:\wamp64\www>cd php-autoload-psr4

C:\wamp64\www\php-autoload-psr4>mkdir src\Modelos

C:\wamp64\www\php-autoload-psr4>mkdir src\Servicios

C:\wamp64\www\php-autoload-psr4>type nul > composer.json

C:\wamp64\www\php-autoload-psr4>type nul > index.php

C:\wamp64\www\php-autoload-psr4>type nul > .gitignore

C:\wamp64\www\php-autoload-psr4>type nul > src\Modelos\Producto.php

C:\wamp64\www\php-autoload-psr4>type nul > src\Modelos\Usuario.php

C:\wamp64\www\php-autoload-psr4>type nul > src\Servicios\Carrito.php
```
## Código en VS code 
## Composer.json
Define la configuración del proyecto para Composer, incluyendo la versión de PHP requerida y la implementación del estándar PSR-4 para la autocarga de clases desde la carpeta src/.
```bash
{
    "name": "estudiante/php-autoload-psr4",
    "description": "Laboratorio de Autocarga PSR-4 con Composer",
    "require": {
        "php": ">=7.4"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
```
## .gitignore
Especifica los archivos y carpetas que no deben subirse al repositorio, como vendor/ y configuraciones locales, evitando subir dependencias innecesarias.
```bash
vendor/
.DS_Store
.env
.idea/
.vscode/
```
## index.php
Archivo principal del sistema que carga el autoload de Composer y ejecuta la aplicación. Aquí se crean los productos (flores), el cliente y el carrito de compras, simulando el proceso de agregar flores y mostrando el resumen del pedido.
```bash
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
```
## Carpeta modelos 
## Producto.php
Clase que representa una flor o arreglo floral, incluyendo atributos como nombre, precio y stock, además de métodos para consultar su información y verificar disponibilidad.
```bash
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
```
## Usuario.php
Clase que modela un cliente de la florería, almacenando datos como nombre, correo electrónico y rol dentro del sistema.
 ```bash
<?php

namespace App\Modelos;

// Representa un cliente de la florería
class Usuario
{
    private $nombre;
    private $email;
    private $rol;

    // Por defecto el rol es cliente
    public function __construct($nombre, $email, $rol = 'cliente')
    {
        $this->nombre = $nombre;
        $this->email  = $email;
        $this->rol    = $rol;
    }

    // Getters
    public function getNombre() { return $this->nombre; }
    public function getEmail()  { return $this->email; }
    public function getRol()    { return $this->rol; }

    // Representación en texto
    public function __toString()
    {
        return sprintf(
            '[Cliente] %s | Email: %s | Rol: %s',
            $this->nombre, $this->email, $this->rol
        );
    }
}
```
## Carpeta servicios
## Carrito.php
Clase encargada de gestionar el carrito de compras, permitiendo agregar flores, validar stock, calcular el total y mostrar un resumen del pedido del cliente.
 ```bash
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
```
## Proyecto funcionando
<img width="633" height="374" alt="image" src="https://github.com/user-attachments/assets/186d4236-f388-4c9b-b544-ac6dd25744b4" />


## Conclusiones Tecnicas

Durante el desarrollo de este laboratorio se evidenciaron múltiples ventajas al implementar la carga automática de clases mediante el estándar PSR-4 con Composer. En primer lugar, se mejora la mantenibilidad del código, ya que permite agregar nuevas clases sin necesidad de modificar archivos globales ni utilizar instrucciones como `include` o `require`, facilitando así la organización y escalabilidad del sistema. Además, se optimiza la eficiencia de memoria gracias al uso de Lazy Loading, donde las clases solo se cargan cuando son necesarias, reduciendo el consumo de recursos y mejorando el rendimiento. Por otra parte, la estandarización proporcionada por PSR-4 permite una estructura clara y consistente del proyecto, lo cual facilita el trabajo colaborativo y la comprensión del código por parte de otros desarrolladores. En conjunto, estas ventajas contribuyen a un desarrollo más ordenado, eficiente y alineado con buenas prácticas, permitiendo además reutilizar el sistema en diferentes contextos, como se demostró en la adaptación del proyecto a una florería.

## Desarrollado por  
Este laboratorio ha sido desarrollado por el estudiante de la Universidad Tecnológica de Panamá:

| Campo | Información |
|------|------------|
| Nombre | Elisa Oses |
| Correo | elisa.oses@utp.ac.pa |
| Curso | Desarrollo De Software VII |
| Instructor | Ing. Irina Fong |
| Fecha | 2 mayo del 2026 |
