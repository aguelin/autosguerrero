<?php

class ofertasControlador extends CControlador
{

    public function __construct()
    {
        $this->plantilla = "coches";
    }


    // Acción principal

    public function accionIndex()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(1)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $this->dibujaVista("index", [], "Ofertas");
    }

    public function accionMostrar()
    {

        $producto  = new Nuevos();
                

        $sentencia = "oferta > 0 and borrado = false";

            // Validar marca
            $marca = "";
            if (isset($_POST["marca"])) {
                $marca = $_POST["marca"];
                $marca = CGeneral::addSlashes($marca);

                if ($marca != "") 
                    $sentencia .= " and fabricante regexp '.*$marca.*'";
            }

            // Validar modelo
            $modelo = "";
            if (isset($_POST["modelo"])) {
                $modelo = $_POST["modelo"];
                $modelo = CGeneral::addSlashes($modelo);

                if ($modelo != "") 
                    $sentencia .= " and nombre regexp '.*$modelo.*'";
                   
            }

            // Validar precio
            $precio = 0;
            if (isset($_POST["precio"])) {
                $precio = $_POST["precio"];
                $precio = floatval($precio);

                if ($precio != "") 
                    $sentencia .= " and precio_oferta <= ".$precio;
            }

            // Validar km
            $km = 0;
            if (isset($_POST["km"])) {
                $km = $_POST["km"];
                $km = floatval($km);

                if ($km != "") 
                    $sentencia .= " and km <= ".$km;
                
            }

             // Validar fecha
             $fecha_inicio = "";
             $fecha_fin = "";

             if (isset($_POST["fecha_inicio"]) && isset($_POST["fecha_fin"])) {
                 
                 $fecha_inicio = $_POST["fecha_inicio"];
                 $fecha_fin = $_POST["fecha_fin"];

                 $fecha_inicio = intval($fecha_inicio);
                 $fecha_fin = intval($fecha_fin);
 
                 if ($fecha_inicio != "" && $fecha_fin != "") 
                      $sentencia .= " and (EXTRACT(YEAR FROM fecha_fab)) BETWEEN ".$fecha_inicio." and ".$fecha_fin;
                 
             }

             // Validar categoria
            $categoria = 0;
            if (isset($_POST["categoria"])) {
                $categoria = $_POST["categoria"];
                $categoria = floatval($categoria);

                if ($categoria != 0) 
                    $sentencia .= " and cod_categoria = ".$categoria;
                    
            }

            // Validar combustible
            $combustible = 0;
            if (isset($_POST["combustible"])) {
                $combustible = $_POST["combustible"];
                $combustible = floatval($combustible);

                if ($combustible != 0) 
                    $sentencia .= " and cod_combustible = ".$combustible;
            }

            // Validar caja de cambios
            $caja_cambios = "";
            if (isset($_POST["caja_cambios"])) {
                $caja_cambios = $_POST["caja_cambios"];
                $caja_cambios = CGeneral::addSlashes($caja_cambios);

                if ($caja_cambios != "") 
                        $sentencia .= " and caja_cambios regexp '.*$caja_cambios.*'";
            }

        // Validar plazas
        $plazas = 0;
        if (isset($_POST["plazas"])) {
            $plazas = $_POST["plazas"];
            $plazas = floatval($plazas);

            if ($plazas != 0) 
                $sentencia .= " and num_plazas = ".$plazas;
                
        }

        // Validar potencia
        $potencia = 50;
        if (isset($_POST["potencia"])) {
            $potencia = $_POST["potencia"];
            $potencia = floatval($potencia);

            if ($potencia >= 50) 
                $sentencia .= " and potencia <= ".$potencia;
               
        }

        $opciones = [];

        if ($sentencia != "")
            $opciones["where"] = $sentencia;

        $coches = $producto->buscarTodos($opciones);

        echo json_encode($coches,true);

    }


    /**
     * La función "accionComprar" permite a un usuario comprar un coche
     */
    public function accionComprar()
    {

        $cod_usuario = Sistema::app()->ACL()->getCodUsuario(Sistema::app()->Acceso()->getNick());
        $cod_coche = $_POST["cod_coche"];
        $fecha_actual = new DateTime("now");
        $fecha = CGeneral::fechaNormalAMysql($fecha_actual->format("d/m/Y"));
        $importe_base = floatval($_POST["importe_base"]);
        $importe_iva = floatval($_POST["importe_iva"]);
        $importe_total = floatval($_POST["importe_total"]);
        $unidades = $_POST["unidades"];

        if($unidades > 0){   
        	
            $sentencia = "insert into compras (" .
        		" cod_usuario, cod_coche, fecha , importe_base, importe_iva, importe_total" .
        		" ) values ( " .
        		" '$cod_usuario', '$cod_coche', '$fecha', '$importe_base', '$importe_iva', '$importe_total' " .
        		" ) ";

        	Sistema::app()->BD()->crearConsulta($sentencia);

            $sentencia2 = "update coches set unidades = (unidades - 1) where cod_coche = $cod_coche";

            Sistema::app()->BD()->crearConsulta($sentencia2);

            echo "Compra realizada exitosamente.";

        }
        else{

            echo "Lamentablemente no disponemos de stock.";

        }


    }

    /**
     * Esta función recupera una lista de nombres de automóviles distintos de una base de datos
     * basada en un fabricante específico y si están en oferta.
     */
    public function accionListaModelo(){

        $producto = new Nuevos();
        $marca = CGeneral::addSlashes($_POST["marca"]);

        $opciones = [];

        $opciones["select"] = "DISTINCT(nombre)";
        $opciones["where"] = "fabricante regexp '.*$marca.*' and oferta <> 0";

        $coches = $producto->buscarTodos($opciones);

        echo json_encode($coches,true);

    }

    
}


