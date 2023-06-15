<?php

abstract class CuentaBancaria {
    public function __construct(public int $saldo) {
    }

    public function depositar($monto) {
        return $this->saldo += $monto;
    }

    public function retirar($monto) {
        if ($this->saldo >= $monto) {
            $this->saldo -= $monto;
            return "Retiro exitoso";
        } else {
            return "El monto a retirar es superior a su saldo.";
        }
    }
}

class CuentaCorriente extends CuentaBancaria {
    public function retirar($monto) {
        if ($this->saldo >= $monto) {
            $this->saldo -= $monto;
            return "Retiro exitoso";
        } else {
            $sobregiro = $monto - $this->saldo;
            $cargo_sobregiro = $sobregiro * 0.1;
            $this->saldo = 0;
            return "Saldo insuficiente. Se ha aplicado un cargo por sobregiro de: " . $cargo_sobregiro;
        }
    }
}

class CuentaAhorros extends CuentaBancaria {
    // No es necesario sobrescribir el método retirar, se hereda de CuentaBancaria
}

$cuentaCorriente = new CuentaCorriente(100);
echo $cuentaCorriente->retirar(50) . "<br>"; // Retiro exitoso
echo $cuentaCorriente->retirar(200) . "<br>"; // Saldo insuficiente. Se ha aplicado un cargo por sobregiro de: 10

$cuentaAhorros = new CuentaAhorros(200);
echo $cuentaAhorros->retirar(150) . "<br>"; // Retiro exitoso
echo $cuentaAhorros->retirar(300) . "<br>"; // El monto a retirar es superior a su saldo.


?>