<?php

class Compras extends CActiveRecord
{
    protected function fijarNombre()
    {
        return "compra";
    }

    protected function fijarTabla()
    {
        return "cons_compras";
    }

    protected function fijarId()
    {
        return "cod_compra";
    }

    protected function fijarAtributos()
    {
        return ["cod_compra","cod_usuario","cod_coche","fecha","importe_base","importe_total","nombre","fabricante","foto"];
    }

    protected function fijarDescripciones()
    {
        return [
            "cod_usuario" => "Usuario",
            "cod_coche" => "Coche",
            "fecha" => "Fecha",
            "importe_base" => "Importe base",
            "importe_iva" => "Importe iva",
            "importe_total" => "Importe total",
            "nombre" => "Nombre",
            "fabricante" => "Fabricante",
            "foto" => "Foto"
        ];
    }

    protected function afterBuscar() {
        $fecha = $this->fecha;
        $fecha = CGeneral::fechaMysqlANormal($fecha);
        $this->fecha = $fecha;
    }

}
