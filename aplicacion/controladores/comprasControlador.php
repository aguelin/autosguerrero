<?php

class comprasControlador extends CControlador
{

    public function __construct()
	{
		$this->plantilla = "admin";
	}

    // Acción principal

    public function accionIndex()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(2)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $compra = new Compras();

        $sentencia = "";

        //obtengo las opciones de filtrado
        $datosFiltrado = [
            "fecha" => "",
        ];
        if (isset($_POST["filtrar"])) {
            $sentencia = "";

            // Validar fecha
            $fecha = "";
            if (isset($_POST["fecha"])) {
                $fecha = $_POST["fecha"];
                $datosFiltrado["fecha"] = $fecha;
                $fecha = CGeneral::fechaNormalAMysql($fecha);

                if ($fecha != "") {
                    if ($sentencia != "")
                        $sentencia .= " and fecha = '$fecha'";
                    else
                        $sentencia .= " fecha = '$fecha'";
                }
            }

        }



        //establezco las opciones de filtrado
        $opciones = array();

        if ($sentencia != "")
            $opciones["where"] = $sentencia;

        $nRegistros = $compra->buscarTodosNRegistros($opciones);
        if ($nRegistros === false) {
            Sistema::app()->paginaError(400, "error en el acceso a la base de datos");
            return;
        }
        $tamPagina = 2;
        if (isset($_GET["reg_pag"]))
            $tamPagina = intval($_GET["reg_pag"]);

        $nPaginas = ceil($nRegistros / $tamPagina);

        $pag = 1;
        if (isset($_GET["pag"]))
            $pag = intval($_GET["pag"]);

        if ($pag > $nPaginas)
            $pag = $nPaginas;

        $inicio = $tamPagina * ($pag - 1);

        if ($inicio < 0)
            $inicio = 0;


        $opciones["limit"] = "$inicio, $tamPagina";

        //filas a dibujar en el CGrid
        $filas = $compra->buscarTodos($opciones);
        foreach ($filas as $clave => $fila) {
            $filas[$clave]["fecha"] =
                CGeneral::fechaMysqlANormal(
                    $filas[$clave]["fecha"]
                );

        }

        //definiciones de las cabeceras de las
        //columnas para el CGrid
        $cabecera = array(
            array(
                "ETIQUETA" => "Fecha",
                "CAMPO" => "fecha",
                "ANCHO" => "18%",
                "ALINEA" => "cen"
            ),
            array(
                "ETIQUETA" => "Usuario",
                "CAMPO" => "cod_usuario",
                "ANCHO" => "19%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "cod_coche",
                "ETIQUETA" => "Coche",
                "ANCHO" => "19%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "importe_base",
                "ETIQUETA" => "Importe Base",
                "ANCHO" => "19%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "importe_iva",
                "ETIQUETA" => "Importe IVA",
                "ANCHO" => "18%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "importe_total",
                "ETIQUETA" => "Importe Total",
                "ANCHO" => "18%",
                "ALINEA" => "cen"
            )
        );

        //opciones del paginador
        $opcPaginador = array(
            "URL" => Sistema::app()->generaURL(array("compras", "index")),
            "TOTAL_REGISTROS" => $nRegistros,
            "PAGINA_ACTUAL" => $pag,
            "REGISTROS_PAGINA" => $tamPagina,
            "TAMANIOS_PAGINA" => array(
                2 => "2",
                5 => "5",
                10 => "10"
            ),
            "MOSTRAR_TAMANIOS" => true,
            "PAGINAS_MOSTRADAS" => 3,
        );
        //llamo a la vista con las definiciones para
        //el CGrid y el CPager
        $this->dibujaVista(
            "indice",
            array(
                "modelo" => $compra,
                "fil" => $datosFiltrado,
                "filas" => $filas,
                "cabe" => $cabecera,
                "opcPag" => $opcPaginador
            ),
            "Lista de compras"
        );
    }
    

    // Acción de descarga de datos

    public function accionDescargarMensajes()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(2)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $nombreSalida = "DatosCompra.txt";

        header("Content-Type: text/plain");
        header("Content-Disposition: attachmente;filename=" . $nombreSalida);

        $usuario = new Compras();

        foreach ($usuario->buscarTodos() as $indice => $valor) {

            echo "Fecha => " . $valor["fecha"] . "\n" .
                "Usuario => " . $valor["cod_usuario"] . "\n" .
                "Precio => " . $valor["importe_total"] . "\n" .
                "Coche => " . $valor["nombre"] ." ". $valor["fabricante"] ."\n\n";
        }
    }
}
