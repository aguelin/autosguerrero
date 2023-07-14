<?php


class Alquiler extends CActiveRecord
{

    protected function fijarNombre()
    {
        return 'alquiler';
    }

    protected function fijarTabla()
    {
        return "cons_alquiler";
    }

    protected function fijarId()
    {
        return "cod_alquiler";
    }


    protected function fijarAtributos()
    {
        return ["cod_alquiler", "nombre", "fabricante","cod_categoria","num_plazas","fecha_inicio","fecha_fin","precio","foto","borrado","desc_categoria"];
    }

    protected function fijarDescripciones()
    {
        return [
            "nombre" => "Nombre",
            "fabricante" => "Fabricante",
            "cod_categoria" => "Categoría",
            "num_plazas" => "Número de plazas",
            "fecha_inicio" => "Fecha de inicio",
            "fecha_fin" => "Fecha de fin",
            "precio" => "Precio",
            "foto" => "Foto",
        ];
    }

    protected function fijarRestricciones()
    {
        return [
            [
                "ATRI" => "nombre,cod_categoria,precio", "TIPO" => "REQUERIDO",
                "MENSAJE" => "Campos obligatorios sin rellenar"
            ],
            [
                "ATRI" => "nombre", "TIPO" => "CADENA", "TAMANIO" => 40,
                "MENSAJE" => "No debe sobrepasar los 40 caracteres"
            ],
            [
                "ATRI" => "fabricante", "TIPO" => "CADENA", "TAMANIO" => 30,
                "MENSAJE" => "No debe sobrepasar los 30 caracteres"
            ],
            [
                "ATRI" => "cod_categoria", "TIPO" => "ENTERO", "MIN" => 0, "MAX" => 7, "DEFECTO" => 0
            ],
            [
                "ATRI" => "num_plazas", "TIPO" => "ENTERO", "DEFECTO" => 5
            ],
            [
                "ATRI" => "fecha_inicio", "TIPO" => "FECHA",
                "MENSAJE" => "Fecha no válida"
            ],
            [
                "ATRI" => "fecha_fin", "TIPO" => "FECHA",
                "MENSAJE" => "Fecha no válida"
            ],
            [
                "ATRI" => "fecha_fin", "TIPO" => "FUNCION", "FUNCION" => "validaFechas"
            ],
            [
                "ATRI" => "precio", "TIPO" => "REAL"
            ],
            [
                "ATRI" => "precio", "TIPO" => "FUNCION", "FUNCION" => "validaPrecio"
            ],
            [
                "ATRI" => "foto", "TIPO" => "CADENA", "TAMANIO" => 30, "DEFECTO"=> "base.png",
                "MENSAJE" => "No debe sobrepasar los 40 caracteres"
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

        $this->nombre = "";
        $this->fabricante = "";
        $this->cod_categoria = 0;
        $this->num_plazas = 5;
        $this->fecha_inicio = $fecha_actual->format("d/m/Y");
        $this->fecha_fin = $fecha_actual->format("d/m/Y");
        $this->precio = 0;
        $this->foto = "base.jpg";
    }

    protected function afterBuscar() {
        $fecha= $this->fecha_inicio;
        $fecha= CGeneral::fechaMysqlANormal($fecha);
        $this -> fecha_inicio = $fecha;

        $fecha2= $this->fecha_fin;
        $fecha2= CGeneral::fechaMysqlANormal($fecha2);
        $this -> fecha_fin = $fecha2;
    }

    /**
     * Si el precio es inferior a cero, establece un mensaje de error.
     */
    public function validaPrecio()
    {

        if ($this->precio < 0) {
            $this->setError(
                "precio",
                "El precio no puede ser negativo"
            );
        }
    }


   /**
    * La función comprueba si el número de unidades es mayor que cero y establece un mensaje de error
    * si no lo es.
    */
    public function validaUnidades()
    {
        if ($this->unidades <= 0) {
            $this->setError(
                "unidades",
                "Debe existir al menos una unidad"
            );
        }
    }

    /**
     * La función comprueba si la fecha de finalización es posterior a la fecha de inicio y, en caso
     * contrario, establece un mensaje de error.
     */
    public function validaFechas(){

        if($this->fecha_inicio > $this->fecha_fin || $this->fecha_fin < $this->fecha_inicio){
            $this->setError(
                "fecha_fin",
                "Fechas no válidas"
            );
        }

    }

    /**
     * Esta función genera una declaración de inserción SQL para un artículo de alquiler con varias
     * propiedades.
     * 
     * @return una cadena que representa una declaración de inserción de SQL para insertar datos en una
     * tabla llamada "alquiler". Los valores que se insertan son las propiedades del objeto que llama a
     * la función, que se desinfectan y se les da el formato adecuado para su inserción en la base de
     * datos.
     */
    protected function fijarSentenciaInsert()
    {
        $nombre = CGeneral::addSlashes($this->nombre);
        $fabricante = CGeneral::addSlashes($this->fabricante);
        $categoria = intval($this->cod_categoria);
        $num_plazas = intval($this->num_plazas);
        $fecha_inicio = CGeneral::fechaNormalAMysql($this->fecha_inicio);
        $fecha_fin = CGeneral::fechaNormalAMysql($this->fecha_fin);
        $precio = floatval($this->precio);
        $foto = CGeneral::addSlashes($this->foto);

        return "insert into alquiler (" .
            " nombre,fabricante, cod_categoria, num_plazas, fecha_inicio, fecha_fin, num_dias, precio, foto, borrado" .
            " ) values ( " .
            " '$nombre', '$fabricante', '$categoria', '$num_plazas', '$fecha_inicio', '$fecha_fin', '0' ,'$precio', '$foto', false" .
            " ) ";
    }

    /**
     * Esta función genera una declaración de actualización de SQL para un sistema de alquiler de
     * automóviles.
     * 
     * @return Una cadena que contiene una declaración de actualización de SQL para la tabla "coches",
     * configurando varios campos con los valores de las propiedades correspondientes del objeto y
     * filtrando por el campo "cod_coche" que coincide con la propiedad "cod_alquiler" del objeto.
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_alquiler = intval($this->cod_alquiler);
        $nombre = CGeneral::addSlashes($this->nombre);
        $fabricante = CGeneral::addSlashes($this->fabricante);
        $categoria = intval($this->cod_categoria);
        $num_plazas = intval($this->num_plazas);
        $fecha_inicio = CGeneral::fechaNormalAMysql($this->fecha_inicio);
        $fecha_fin = CGeneral::fechaNormalAMysql($this->fecha_fin);
        $precio = floatval($this->precio);
        
        return "update alquiler set " .
            " nombre='$nombre', " .
            " fabricante='$fabricante', " .
            " cod_categoria='$categoria', " .
            " num_plazas='$num_plazas', " .
            " fecha_inicio='$fecha_inicio', " .
            " fecha_fin='$fecha_fin', " .
            " precio='$precio' " .
            " where cod_alquiler = '$cod_alquiler' ";
    }
}
