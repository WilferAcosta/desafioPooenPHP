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
$_DATA= json_decode(file_get_contents("php://input"),true);
/**asi se envia los datos que recibe del json
 */
$cuentaCorriente = new CuentaCorriente($_DATA [0]["monto"]);
echo $cuentaCorriente->retirar($_DATA[0]["retiro"]) . "<br>"; // Retiro exitoso
echo $cuentaCorriente->retirar($_DATA[0]["retiro2"]) . "<br>"; // Saldo insuficiente. Se ha aplicado un cargo por sobregiro de: 10

$cuentaAhorros = new CuentaAhorros($_DATA [1]["monto"]);
echo $cuentaAhorros->retirar($_DATA[1]["retiro"]) . "<br>"; // Retiro exitoso
echo $cuentaAhorros->retirar($_DATA[1]["retiro2"]) . "<br>"; // El monto a retirar es superior a su saldo.


?>