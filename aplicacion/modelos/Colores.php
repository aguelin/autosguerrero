<?php

class Colores extends CActiveRecord
{
    
    protected function fijarNombre()
    {
        return 'color';
    }

    protected function fijarTabla()
    {
        return "color";
    }

    protected function fijarId()
    {
        return "cod_color";
    }


    protected function fijarAtributos()
    {
        return ["cod_color","descripcion"];
    }

    protected function fijarDescripciones()
    {
        return [
            "cod_color" => "Código de color",
            "descripcion" => "Descripción"
        ];
    }

    protected function fijarRestricciones()
    {
        return [
            [
                "ATRI" => "cod_color,descripcion", "TIPO" => "REQUERIDO"
            ],
            [
                "ATRI" => "cod_color", "TIPO" => "ENTERO", "MIN" => 0, "MAX" => 5, "DEFECTO" => 0
            ],
            [
                "ATRI" => "descripcion", "TIPO" => "CADENA", "TAMANIO" => 40
            ]
        ];
    }

   /**
    * La función devuelve una matriz de códigos de color y descripciones, o una descripción específica
    * para un código de color dado.
    * 
    * @param codigo El parámetro "codigo" es un valor entero opcional que representa el código de un
    * color. Si se proporciona, la función devolverá la descripción del color con ese código. Si no se
    * proporciona, la función devolverá una matriz con todos los códigos de color disponibles y sus
    * descripciones.
    * 
    * @return Si `` es `null`, se devuelve una matriz de todos los códigos de color y sus
    * descripciones. Si `` no es `null`, se devuelve la descripción del color con el código dado
    * si existe, de lo contrario se devuelve `false`.
    */
    public static function dameColores($codigo = null)
    {

        $color = new Colores();
        $tipos = $color->buscarTodos();
        $codigos = [0 => "No especificado"];

        foreach($tipos as $indice => $valor){
            $codigos[$valor["cod_color"]] = $valor["descripcion"];
        }

        if ($codigo === null)
            return $codigos;
        else {
            if (isset($codigos[$codigo]))
                return $codigos[$codigo];
            else
                return false;
        }
    }
}