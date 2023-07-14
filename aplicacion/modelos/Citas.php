<?php

class Citas extends CActiveRecord
{
    protected function fijarNombre()
    {
        return "cita";
    }

    protected function fijarTabla()
    {
        return "cons_citas";
    }

    protected function fijarId()
    {
        return "cod_cita";
    }

    protected function fijarAtributos()
    {
        return ["cod_cita","cod_usuario","cod_empleado","fecha","hora","borrado","empleado"];
    }

    protected function fijarDescripciones()
    {
        return [
            "cod_usuario" => "Usuario",
            "cod_empleado" => "Empleado",
            "fecha" => "Fecha",
            "hora" => "Hora"
        ];
    }

    protected function fijarRestricciones()
    {
        return [
            [
                "ATRI" => "fecha,hora", "TIPO" => "REQUERIDO",
                "MENSAJE" => "Campos obligatorios sin rellenar"
            ],
            [
                "ATRI" => "cod_empleado", "TIPO" => "ENTERO", "MIN" => 0, "MAX" => 5, "DEFECTO" => 0
            ],
            [
                "ATRI" => "fecha", "TIPO" => "FECHA",
                "MENSAJE" => "Fecha no válida"
            ],
            [
                "ATRI" => "hora", "TIPO" => "CADENA", "TAMANIO" => 5,
                "MENSAJE" => "Hora no válida"
            ],
            [
                "ATRI" => "borrado", "TIPO" => "ENTERO" 
            ],
            [
                "ATRI" => "borrado", "TIPO" => "RANGO" , "RANGO" => [0,1]
            ]
        ];
    }

    protected function afterCreate()
    {
        $fecha_actual = new DateTime("now");
        $fecha = $fecha_actual->format("d/m/Y");

        $this->cod_empleado = 0;
        $this->fecha = $fecha;
        $this->hora = "10:00";
    }

    protected function afterBuscar() {
        $fecha= $this->fecha;
        $fecha= CGeneral::fechaMysqlANormal($fecha);
        $this -> fecha = $fecha;
    }


    /**
     * Esta función genera una declaración de inserción SQL para agregar un nuevo registro a una tabla
     * llamada "citas_taller".
     * 
     * @return una cadena que representa una declaración de inserción SQL para la tabla "citas_taller",
     * con valores para las columnas "cod_empleado", "fecha", "hora" y "borrado". Los valores para
     * "cod_usuario" y "borrado" están codificados como nulo y falso, respectivamente.
     */
    protected function fijarSentenciaInsert()
    {
        $cod_empleado = intval($this->cod_empleado);
        $fecha = CGeneral::fechaNormalAMysql($this->fecha);
        $hora = CGeneral::addSlashes($this->hora);

        return "insert into citas_taller (" .
            " cod_usuario, cod_empleado , fecha, hora, borrado" .
            " ) values ( " .
            " null , '$cod_empleado', '$fecha', '$hora', false" .
            " ) ";
    }


    /**
     * Esta función configura una declaración de actualización de SQL para una tabla llamada
     * "citas_taller" con valores específicos para "cod_empleado" y "hora" basados en el parámetro
     * "cod_cita".
     * 
     * @return una cadena que contiene una declaración de actualización de SQL para la tabla
     * "citas_taller". La sentencia actualiza los campos "cod_empleado" y "hora" para un "cod_usuario"
     * específico (identificado por la variable "cod_cita").
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_cita = intval($this->cod_cita);
        $cod_empleado = intval($this->cod_empleado);
        // $fecha = CGeneral::fechaNormalAMysql($this->fecha);
        $hora = CGeneral::addSlashes($this->hora);

        return "update citas_taller set " .
            " cod_empleado='$cod_empleado', " .
            " hora='$hora' " .
            " where cod_usuario = '$cod_cita' ";
    }
}
