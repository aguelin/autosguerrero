<?php

class ComprasAlquiler extends CActiveRecord
{
    protected function fijarNombre()
    {
        return "compra_alquiler";
    }

    protected function fijarTabla()
    {
        return "compras_alquiler";
    }

    protected function fijarId()
    {
        return "cod_compra_alquiler";
    }

    protected function fijarAtributos()
    {
        return ["cod_compra_alquiler","cod_usuario","cod_alquiler","fecha","precio"];
    }

    protected function fijarDescripciones()
    {
        return [
            "cod_usuario" => "Usuario",
            "cod_alquiler" => "Coche alquilado",
            "fecha" => "Fecha",
            "precio" => "Precio",
        ];
    }

    protected function afterBuscar() {
        $fecha = $this->fecha;
        $fecha = CGeneral::fechaMysqlANormal($fecha);
        $this->fecha = $fecha;
    }

}
