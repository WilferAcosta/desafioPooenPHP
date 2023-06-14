<?php

abstract class CuentaBancaria{
    public function __construct(protected int $saldo){
        $this->saldo = $saldo;
    }
    
    public function depositar($monto){
        return $this->saldo+=$monto;
    }
    public function retirar($monto){
        if($this->saldo >= $monto){
            $this->saldo-=$monto;
            return "retiro exitoso";
        }else{
            return "El monto a retirar es superior a su saldo.";
        }
    }
}

?>