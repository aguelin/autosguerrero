<?php

class citasControlador extends CControlador
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

        $cita = new Citas();

        $sentencia = "";

        //obtengo las opciones de filtrado
        $datosFiltrado = [
            "fecha" => "",
            "borrado" => ""
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


            // Validar borrado
            $borrado = "";
            if (isset($_POST["borrado"])) {
                $borrado = intval($_POST["borrado"]);
                $datosFiltrado["borrado"] = $borrado;
                $borrado = CGeneral::addSlashes($borrado);

                if ($borrado != "") {
                    if ($sentencia != "")
                        $sentencia .= " and borrado=" . $borrado;
                    else
                        $sentencia .= " borrado=" . $borrado;
                }
            }
        }



        //establezco las opciones de filtrado
        $opciones = array();

        if ($sentencia != "")
            $opciones["where"] = $sentencia;

        $nRegistros = $cita->buscarTodosNRegistros($opciones);
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
        $filas = $cita->buscarTodos($opciones);
        foreach ($filas as $clave => $fila) {
            $filas[$clave]["fecha"] =
                CGeneral::fechaMysqlANormal(
                    $filas[$clave]["fecha"]
                );

            //botones


            $cadena = CHTML::link(
                CHTML::imagen("/imagenes/24x24/ver.png"),
                Sistema::app()->generaURL(
                    array("citas", "consultar"),
                    array("id" => $filas[$clave]["cod_cita"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/modificar.png'
                ),
                Sistema::app()->generaURL(
                    array("citas", "modificar"),
                    array("id" => $filas[$clave]["cod_cita"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/borrar.png'
                ),
                Sistema::app()->generaURL(
                    array("citas", "borrar"),
                    array("id" => $filas[$clave]["cod_cita"])
                ),
                array("onclick" => "return confirm('&iquest;Está seguro de borrar/restablecer la cita?');")
            );

            $filas[$clave]["opciones"] = $cadena;
        }

        //definiciones de las cabeceras de las
        //columnas para el CGrid
        $cabecera = array(
            array(
                "ETIQUETA" => "Fecha",
                "CAMPO" => "fecha",
                "ANCHO" => "20%",
                "ALINEA" => "cen"
            ),
            array(
                "ETIQUETA" => "Hora",
                "CAMPO" => "hora",
                "ANCHO" => "20%",
                "ALINEA" => "cen"
            ),
            array(
                "ETIQUETA" => "Empleado",
                "CAMPO" => "empleado",
                "ANCHO" => "20%",
                "ALINEA" => "cen"
            ),
            array(
                "ETIQUETA" => "Usuario",
                "CAMPO" => "cod_usuario",
                "ANCHO" => "20%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "borrado",
                "ETIQUETA" => "Borrado",
                "ANCHO" => "15%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "opciones",
                "ETIQUETA" => " Operaciones",
                "ANCHO" => "20%",
                "ALINEA" => "cen"
            )
        );

        //opciones del paginador
        $opcPaginador = array(
            "URL" => Sistema::app()->generaURL(array("citas", "index")),
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
                "modelo" => $cita,
                "fil" => $datosFiltrado,
                "filas" => $filas,
                "cabe" => $cabecera,
                "opcPag" => $opcPaginador
            ),
            "Lista de citas"
        );
    }

    // Acción de creación

    public function accionNuevo()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(2)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $cita  = new Citas();
        $nombre =  $cita->getNombre();

        if (isset($_POST[$nombre])) {

            $cita->setValores($_POST[$nombre]);

            if ($cita->validar()) {

                if (!$cita->guardar()) {
                    $this->dibujaVista(
                        "nuevo",
                        array("modelo" =>  $cita),
                        "Nueva cita"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["citas"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "nuevo",
                    array("modelo" =>  $cita),
                    "Nueva cita"
                );
                exit;
            }
        }

        $this->dibujaVista("nuevo", ["modelo" => $cita], "Nueva cita");
    }

    // Acción de consulta

    public function accionConsultar()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(2)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $id = 0;
        $cita  = new Citas();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$cita->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        $this->dibujaVista("consulta", ["modelo" => $cita], "Consultar cita");
    }

    // Acción de modificado

    public function accionModificar()
    {
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(2)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $id = 0;
        $cita  = new Citas();
        $nombre = $cita->getNombre();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$cita->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        if (isset($_POST[$nombre])) {

            $cita->setValores($_POST[$nombre]);

            if ($cita->validar()) {

                if (!$cita->guardar()) {
                    $this->dibujaVista(
                        "modificar",
                        array("modelo" => $cita),
                        "Modificar cita"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["citas"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "modificar",
                    array("modelo" => $cita),
                    "Modificar cita"
                );
                exit;
            }
        }

        $this->dibujaVista(
            "modificar",
            array("modelo" => $cita),
            "Modificar cita"
        );
    }

    // Acción de borrado

    public function accionBorrar()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(2)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $id = 0;
        $cita = new Citas();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$cita->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        if ($cita->borrado) {

            $sentencia = "update citas_taller set borrado = false where cod_cita = '$id'";
            $cita->ejecutarSentencia($sentencia);
        } 
        else {
            
            $sentencia = "update citas_taller set borrado = true where cod_cita = '$id'";
            $cita->ejecutarSentencia($sentencia);
        }

        Sistema::app()->irAPagina(["citas"]);
        exit;
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

        $nombreSalida = "DatosCita.txt";

        header("Content-Type: text/plain");
        header("Content-Disposition: attachmente;filename=" . $nombreSalida);

        $usuario = new Citas();

        foreach ($usuario->buscarTodos() as $indice => $valor) {

            echo "Fecha => " . $valor["fecha"] . "\n" .
                "Hora => " . $valor["hora"] . "\n" .
                "Empleado => " . $valor["empleado"] . "\n\n";
        }
    }
}
