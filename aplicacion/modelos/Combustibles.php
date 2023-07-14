<?php

class Combustibles extends CActiveRecord
{
    
    protected function fijarNombre()
    {
        return 'combustible';
    }

    protected function fijarTabla()
    {
        return "combustible";
    }

    protected function fijarId()
    {
        return "cod_combustible";
    }


    protected function fijarAtributos()
    {
        return ["cod_combustible","descripcion"];
    }

    protected function fijarDescripciones()
    {
        return [
            "cod_combustible" => "Código de combustible",
            "descripcion" => "Descripción"
        ];
    }

    protected function fijarRestricciones()
    {
        return [
            [
                "ATRI" => "cod_combustible,descripcion", "TIPO" => "REQUERIDO"
            ],
            [
                "ATRI" => "cod_combustible", "TIPO" => "ENTERO", "MIN" => 0, "MAX" => 4, "DEFECTO" => 0
            ],
            [
                "ATRI" => "descripcion", "TIPO" => "CADENA", "TAMANIO" => 40
            ]
        ];
    }

    /**
     * Esta función devuelve una matriz de tipos de combustible y sus códigos correspondientes,
     * o la descripción de un tipo de combustible específico si se proporciona un código.
     * 
     * @param codigo El parámetro "código" es un valor entero opcional que representa el código de un
     * tipo de combustible específico. Si no se proporciona, la función devolverá una matriz de todos
     * los tipos de combustible con sus respectivos códigos y descripciones. Si se proporciona, la
     * función devolverá la descripción del tipo de combustible con el
     * 
     * @return Si el parámetro  es nulo, la función devuelve una matriz con todos los tipos de
     * combustible y sus códigos correspondientes. Si  no es nulo, la función devuelve la
     * descripción del tipo de combustible con el código dado. Si no se encuentra el código dado,
     * devuelve falso.
     */
    public static function dameCombustibles($codigo = null)
    {

        $combustible = new Combustibles();
        $tipos = $combustible->buscarTodos();
        $codigos = [0 => "No especificado"];

        foreach($tipos as $indice => $valor){
            $codigos[$valor["cod_combustible"]] = $valor["descripcion"];
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