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