<?php

class Categorias extends CActiveRecord
{
    
    protected function fijarNombre()
    {
        return 'categoria';
    }

    protected function fijarTabla()
    {
        return "categorias";
    }

    protected function fijarId()
    {
        return "cod_categoria";
    }


    protected function fijarAtributos()
    {
        return ["cod_categoria","descripcion"];
    }

    protected function fijarDescripciones()
    {
        return [
            "cod_categoria" => "Código de categoría",
            "descripcion" => "Descripción"
        ];
    }

    protected function fijarRestricciones()
    {
        return [
            [
                "ATRI" => "cod_categoria,descripcion", "TIPO" => "REQUERIDO"
            ],
            [
                "ATRI" => "cod_categoria", "TIPO" => "ENTERO", "MIN" => 0, "MAX" => 7, "DEFECTO" => 0
            ],
            [
                "ATRI" => "descripcion", "TIPO" => "CADENA", "TAMANIO" => 40
            ]
        ];
    }

    /**
     * Esta función recupera una lista de categorías y sus códigos correspondientes, y también
     * puede devolver la descripción de una categoría específica en función de su código.
     * 
     * @param codigo El parámetro "codigo" es un valor entero opcional que representa el código de una
     * categoría específica. Si no se proporciona, la función devolverá una matriz de todas las
     * categorías con sus respectivos códigos. Si se proporciona, la función devolverá la descripción
     * de la categoría con el código coincidente.
     * 
     * @return Si el parámetro `` es `null`, se devuelve una matriz de todas las categorías. Si
     * `` no es `null`, se devuelve la descripción de la categoría con el código dado si existe,
     * de lo contrario se devuelve `false`.
     */
    public static function dameCategorias($codigo = null)
    {

        $categoria = new Categorias();
        $tipos = $categoria->buscarTodos();
        $codigos = [0 => "Sin categoría"];

        foreach($tipos as $indice => $valor){
            $codigos[$valor["cod_categoria"]] = $valor["descripcion"];
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
