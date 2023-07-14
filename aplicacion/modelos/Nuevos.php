<?php

use Nuevos as GlobalNuevos;

class Nuevos extends CActiveRecord
{

    protected function fijarNombre()
    {
        return 'nuevo';
    }

    protected function fijarTabla()
    {
        return "cons_coches";
    }

    protected function fijarId()
    {
        return "cod_coche";
    }


    protected function fijarAtributos()
    {
        return ["cod_coche", "nombre", "fabricante","cod_categoria","cod_combustible","cod_color","num_puertas","num_plazas","caja_cambios",
        "potencia","km","fecha_fab","unidades","precio_base", "iva", "precio_iva", "precio_total","oferta","precio_oferta","foto", "borrado",
        "desc_categoria","desc_combustible","desc_color"];
    }

    protected function fijarDescripciones()
    {
        return [
            "nombre" => "Nombre",
            "fabricante" => "Fabricante",
            "cod_categoria" => "Categoría",
            "cod_combustible" => "Combustible", 
            "cod_color" => "Color",
            "num_puertas" => "Nº puertas",
            "num_plazas" => "Nº plazas",
            "caja_cambios" => "Cambios",
            "potencia" => "Potencia",
            "km" => "Km",
            "fecha_fab" => "Fabricación",
            "unidades" => "Unidades",
            "precio_base" => "Precio base",
            "iva" => "IVA",
            "oferta"=> "Oferta",
            "foto" => "Foto",
        ];
    }

    protected function fijarRestricciones()
    {
        return [
            [
                "ATRI" => "nombre,cod_categoria,precio_base", "TIPO" => "REQUERIDO",
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
                "ATRI" => "cod_combustible", "TIPO" => "ENTERO", "MIN" => 0, "MAX" => 4, "DEFECTO" => 0
            ],
            [
                "ATRI" => "cod_color", "TIPO" => "ENTERO", "MIN" => 0, "MAX" => 5, "DEFECTO" => 0
            ],
            [
                "ATRI" => "num_puertas", "TIPO" => "ENTERO", "DEFECTO" => 5
            ],
            [
                "ATRI" => "num_plazas", "TIPO" => "ENTERO", "DEFECTO" => 5
            ],
            [
                "ATRI" => "caja_cambios", "TIPO" => "CADENA", "TAMANIO" => 20,
                "MENSAJE" => "No debe sobrepasar los 20 caracteres"
            ],
            [
                "ATRI" => "potencia", "TIPO" => "FLOAT", "MIN" => 0,"MAX" => 2000, "DEFECTO" => 0
            ],
            [
                "ATRI" => "km", "TIPO" => "FLOAT", "MIN" => 0, "MAX"=> 310000, "DEFECTO" => 0
            ],
            [
                "ATRI" => "fecha_fab", "TIPO" => "FECHA",
                "MENSAJE" => "Fecha no válida"
            ],
            [
                "ATRI" => "unidades", "TIPO" => "ENTERO", "DEFECTO" => 0
            ],
            [
                "ATRI" => "unidades", "TIPO" => "FUNCION", "FUNCION" => "validaUnidades"
            ],
            [
                "ATRI" => "precio_base", "TIPO" => "REAL", "DEFECTO" => 0, "MIN" => 0, "MAX"=> 100000
            ],
            [
                "ATRI" => "precio_base", "TIPO" => "FUNCION", "FUNCION" => "validaPrecio"
            ],
            [
                "ATRI" => "iva", "TIPO" => "ENTERO"
            ],
            [
                "ATRI" => "precio_iva", "TIPO" => "REAL"
            ],
            [
                "ATRI" => "precio_iva", "TIPO" => "FUNCION", "FUNCION" => "calculaPrecioIva"
            ],
            [
                "ATRI" => "precio_total", "TIPO" => "REAL"
            ],
            [
                "ATRI" => "precio_total", "TIPO" => "FUNCION", "FUNCION" => "calculaPrecioTotal"
            ],
            [
                "ATRI" => "oferta", "TIPO" => "ENTERO", "DEFECTO" => 0
            ],
            [
                "ATRI" => "precio_oferta", "TIPO" => "REAL"
            ],
            [
                "ATRI" => "precio_oferta", "TIPO" => "FUNCION", "FUNCION" => "calculaPrecioOferta"
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
        $this->cod_combustible = 0;
        $this->cod_color = 0;
        $this->num_puertas = 5;
        $this->num_plazas = 5;
        $this->caja_cambios = "Manual";
        $this->potencia = 0;
        $this->km = 0;
        $this->fecha_fab = $fecha_actual->format("d/m/Y");
        $this->unidades = 0;
        $this->precio_base = 0;
        $this->iva = 21;
        $this->oferta = 10;
        $this->foto = "base.jpg";
    }

    protected function afterBuscar() {
        $fecha= $this->fecha_fab;
        $fecha= CGeneral::fechaMysqlANormal($fecha);
        $this -> fecha_fab = $fecha;
    }

    /**
     * Si el precio es inferior a cero, establece un mensaje de error.
     */
    public function validaPrecio()
    {

        if ($this->precio_base < 0) {
            $this->setError(
                "precio_base",
                "El precio no puede ser negativo"
            );
        }
    }


    /**
     * La función comprueba si el número de unidades es negativo y establece un mensaje de error si lo
     * es.
     */
    public function validaUnidades()
    {
        if ($this->unidades < 0) {
            $this->setError(
                "unidades",
                "No pueden existir unidades negativas"
            );
        }
    }

    /**
     * Calcula el precio del producto con el impuesto incluido.
     */
    public function calculaPrecioIva(){

        $this->precio_iva = floatval($this->precio_base) * floatval($this->iva / 100);

    }

    /**
     * La función calcula el precio de la venta sumando el precio base y el precio del impuesto.
     */
    public function calculaPrecioTotal(){

        $this->precio_total = floatval($this->precio_base) + floatval($this->precio_iva);

    }

    /**
     * Esta función calcula el precio con descuento de un artículo en función del precio
     * original y el porcentaje de descuento.
     */
    public function calculaPrecioOferta(){

        $this->precio_oferta = floatval($this->precio_total) - (floatval($this->precio_total) * floatval($this->oferta / 100));

    }

    /**
     * Esta función genera una declaración de inserción SQL para un objeto de automóvil con varias
     * propiedades.
     * 
     * @return Una cadena que contiene una declaración de inserción SQL para una tabla "coches" con
     * varios campos como "nombre", "fabricante", "cod_categoria", etc. Los valores de estos campos se
     * obtienen de las propiedades de la instancia del objeto actual.
     */
    protected function fijarSentenciaInsert()
    {
        $nombre = CGeneral::addSlashes($this->nombre);
        $fabricante = CGeneral::addSlashes($this->fabricante);
        $categoria = intval($this->cod_categoria);
        $combustible = intval($this->cod_combustible);
        $color = intval($this->cod_color);
        $num_puertas = intval($this->num_puertas);
        $num_plazas = intval($this->num_plazas);
        $caja_cambios = CGeneral::addSlashes($this->caja_cambios);
        $potencia = floatval($this->potencia);
        $km = floatval($this->km);
        $fecha_fab = CGeneral::fechaNormalAMysql($this->fecha_fab);
        $unidades = intval($this->unidades);
        $precio_base = floatval($this->precio_base);
        $iva = intval($this->iva);
        $precio_iva = floatval($this->precio_iva);
        $precio_total = floatval($this->precio_total);
        $oferta = intval($this->oferta);
        $precio_oferta = floatval($this->precio_oferta);
        $foto = CGeneral::addSlashes($this->foto);

        return "insert into coches (" .
            " nombre,fabricante, cod_categoria, cod_combustible, cod_color, num_puertas, num_plazas, caja_cambios, potencia, km, fecha_fab, unidades, precio_base, iva,  precio_iva, precio_total, oferta, precio_oferta, foto, borrado" .
            " ) values ( " .
            " '$nombre', '$fabricante', '$categoria', '$combustible', '$color', '$num_puertas', '$num_plazas', '$caja_cambios', '$potencia', '$km', '$fecha_fab', '$unidades', '$precio_base', '$iva', '$precio_iva', '$precio_total', '$oferta', '$precio_oferta', '$foto', false" .
            " ) ";
    }


    /**
     * Esta función genera una declaración de actualización de SQL para un objeto de automóvil.
     * 
     * @return Una cadena que contiene una instrucción de actualización de SQL para la tabla "coches",
     * con valores basados en las propiedades de la instancia del objeto actual. La declaración de
     * actualización actualizará la fila con el valor "cod_coche" especificado.
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_coche = intval($this->cod_coche);
        $nombre = CGeneral::addSlashes($this->nombre);
        $fabricante = CGeneral::addSlashes($this->fabricante);
        $categoria = intval($this->cod_categoria);
        $combustible = intval($this->cod_combustible);
        $color = intval($this->cod_color);
        $num_puertas = intval($this->num_puertas);
        $num_plazas = intval($this->num_plazas);
        $caja_cambios = CGeneral::addSlashes($this->caja_cambios);
        $potencia = floatval($this->potencia);
        $km = floatval($this->km);
        $fecha_fab = CGeneral::fechaNormalAMysql($this->fecha_fab);
        $unidades = intval($this->unidades);
        $precio_base = floatval($this->precio_base);
        $iva = intval($this->iva);
        $precio_iva = floatval($this->precio_iva);
        $precio_total = floatval($this->precio_total);
        $oferta = intval($this->oferta);
        $precio_oferta = floatval($this->precio_oferta);
        
        return "update coches set " .
            " nombre='$nombre', " .
            " fabricante='$fabricante', " .
            " cod_categoria='$categoria', " .
            " cod_combustible='$combustible', " .
            " cod_color='$color', " .
            " num_puertas='$num_puertas', " .
            " num_plazas='$num_plazas', " .
            " caja_cambios='$caja_cambios', " .
            " potencia='$potencia', " .
            " km='$km', " .
            " fecha_fab='$fecha_fab', " .
            " unidades='$unidades', " .
            " precio_base='$precio_base', " .
            " iva='$iva', " .
            " precio_iva='$precio_iva', " .
            " precio_total='$precio_total', " .
            " oferta='$oferta', " .
            " precio_oferta='$precio_oferta'" .
            " where cod_coche = '$cod_coche' ";
    }


    /**
     * La función devuelve una matriz de todas las marcas disponibles o una marca específica según el
     * parámetro de entrada.
     * 
     * @param codigo El parámetro  es un parámetro opcional que se le puede pasar a la función.
     * Si se pasa un valor, la función devolverá el nombre de marca correspondiente para ese código. Si
     * no se pasa ningún valor, la función devolverá una matriz de todos los códigos y nombres de marca
     * disponibles.
     * 
     * @return Si `` es `null`, se devuelve una matriz de todos los fabricantes. Si `` no
     * es `null`, se devuelve el fabricante correspondiente al `` dado si existe, de lo
     * contrario se devuelve `falso`.
     */
    public static function dameMarcas($codigo = null)
    {

        $marca = new Nuevos();
        $tipos = $marca->buscarTodos();

        $codigos = ["" => "No seleccionada"];

        foreach($tipos as $indice => $valor){
            $codigos[$valor["fabricante"]] = $valor["fabricante"];
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

    /**
     * Esta función devuelve una serie de marcas que tienen una oferta de descuento o un nombre
     * de marca específico si se proporciona un código.
     * 
     * @param codigo El parámetro  es un parámetro opcional que se puede utilizar para filtrar
     * los resultados por un código de fabricante específico. Si no se proporciona, la función
     * devolverá todos los códigos de fabricante de los productos que están en oferta.
     * 
     * @return Si `` es `null`, se devuelve un array de todos los fabricantes con `oferta`
     * distinto de 0. Si `` no es `null`, se devuelve el fabricante correspondiente al ``
     * dado si existe en el arreglo, de lo contrario se devuelve `false`.
     */
    public static function dameMarcasOferta($codigo = null)
    {

        $marca = new Nuevos();
       
        $opciones = [];

        $opciones["where"] = "oferta <> 0";

        $codigos = ["" => "No seleccionada"];

        $tipos = $marca->buscarTodos($opciones);

        foreach($tipos as $indice => $valor){
            $codigos[$valor["fabricante"]] = $valor["fabricante"];
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
