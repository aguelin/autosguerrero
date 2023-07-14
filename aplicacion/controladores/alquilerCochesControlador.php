<?php

class alquilerCochesControlador extends CControlador
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

        $this->dibujaVista("index", [], "Coches de alquiler");
    }

    public function accionMostrar()
    {

        $producto  = new Alquiler();

        $sentencia = "";

        // Validar precio
        $precio = 0;
        if (isset($_POST["precio"])) {
            $precio = $_POST["precio"];
            $precio = floatval($precio);

            if ($precio != "") {
                if ($sentencia != "")
                    $sentencia .= " and precio <= " . $precio;
                else
                    $sentencia .= " precio <= " . $precio;
            }
        }

          // Validar categoria
          $categoria = 0;
          if (isset($_POST["categoria"])) {
              $categoria = $_POST["categoria"];
              $categoria = floatval($categoria);

              if ($categoria != 0) 
                  $sentencia .= " and cod_categoria = ".$categoria;
                  
          }


        // Validar fecha de inicio
        $fecha_inicio = "";

        if (isset($_POST["fecha_inicio"])) {

            $fecha_inicio = $_POST["fecha_inicio"];


            if ($fecha_inicio != "") {
                
                $fecha_inicio = CGeneral::fechaNormalAMysql($fecha_inicio);
                if ($sentencia != "")
                    $sentencia .= " and fecha_inicio >= '$fecha_inicio'";
                else
                    $sentencia .= " fecha_inicio >= '$fecha_inicio'";
            }
        }

        // Validar fecha de fin
        $fecha_fin = "";

        if (isset($_POST["fecha_fin"])) {

            $fecha_fin = $_POST["fecha_fin"];


            if ($fecha_fin != "") {
                
                $fecha_fin = CGeneral::fechaNormalAMysql($fecha_fin);
                if ($sentencia != "")
                    $sentencia .= " and fecha_fin <= '$fecha_fin'";
                else
                    $sentencia .= " fecha_fin <= '$fecha_fin'";
            }
        }

        // Validar plazas
        $plazas = 0;
        if (isset($_POST["plazas"])) {
            $plazas = $_POST["plazas"];
            $plazas = floatval($plazas);

            if ($plazas != 0) {
                if ($sentencia != "")
                    $sentencia .= " and num_plazas = " . $plazas;
                else
                    $sentencia .= " num_plazas = " . $plazas;
            }
        }

        $opciones = [];

        if ($sentencia != "")
            $opciones["where"] = $sentencia;


        $coches = $producto->buscarTodos($opciones);

        echo json_encode($coches, true);
    }


    /**
     * Esta función permite que un usuario alquile un automóvil insertando un nuevo registro en
     * la base de datos y actualizando el estado del alquiler del automóvil.
     */
    public function accionAlquilar()
    {

        $cod_usuario = Sistema::app()->ACL()->getCodUsuario(Sistema::app()->Acceso()->getNick());
        $cod_alquiler = $_POST["cod_alquiler"];
        $fecha_actual = new DateTime("now");
        $fecha = CGeneral::fechaNormalAMysql($fecha_actual->format("d/m/Y"));
        $precio = floatval($_POST["importe"]);


        $sentencia = "insert into compras_alquiler (" .
            " cod_usuario, cod_alquiler, fecha , precio" .
            " ) values ( " .
            " '$cod_usuario', '$cod_alquiler', '$fecha', '$precio' " .
            " ) ";

        Sistema::app()->BD()->crearConsulta($sentencia);

        $sentencia2 = "update alquiler set borrado = 1 where cod_alquiler = $cod_alquiler";

        Sistema::app()->BD()->crearConsulta($sentencia2);

        echo "Coche alquilado exitosamente.";
    }
}
