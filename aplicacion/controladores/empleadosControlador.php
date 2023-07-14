<?php

class empleadosControlador extends CControlador
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

        $empleado = new Empleados();

        $sentencia = "";

        //obtengo las opciones de filtrado
        $datosFiltrado = [
            "nombre" => "",
            "borrado" => ""
        ];
        if (isset($_POST["filtrar"])) {
            $sentencia = "";

            // Validar fecha
            $nombre = "";
            if (isset($_POST["nombre"])) {
                $nombre = $_POST["nombre"];
                $datosFiltrado["nombre"] = $nombre;
                $nombre = CGeneral::addSlashes($nombre);

                if ($nombre != "") {
                    if ($sentencia != "")
                        $sentencia .= " and nombre regexp '.*$nombre.*'";
                    else
                        $sentencia .= " nombre regexp '.*$nombre.*'";
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

        $nRegistros = $empleado->buscarTodosNRegistros($opciones);
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
        $filas = $empleado->buscarTodos($opciones);
        foreach ($filas as $clave => $fila) {
            $filas[$clave]["fecha_nac"] =
                CGeneral::fechaMysqlANormal(
                    $filas[$clave]["fecha_nac"]
                );


            $ruta = "/imagenes/usuarios/";

            if ($fila["foto"] != "")
                $ruta .= $fila["foto"];
            else
                $ruta .= "perfil.jpg";

            $filas[$clave]["foto"] = CHTML::imagen($ruta, "imagen", ["witdth" => 100, "height" => 100]);

            //botones


            $cadena = CHTML::link(
                CHTML::imagen("/imagenes/24x24/ver.png"),
                Sistema::app()->generaURL(
                    array("empleados", "consultar"),
                    array("id" => $filas[$clave]["cod_empleado"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/modificar.png'
                ),
                Sistema::app()->generaURL(
                    array("empleados", "modificar"),
                    array("id" => $filas[$clave]["cod_empleado"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/borrar.png'
                ),
                Sistema::app()->generaURL(
                    array("empleados", "borrar"),
                    array("id" => $filas[$clave]["cod_empleado"])
                ),
                array("onclick" => "return confirm('&iquest;Está seguro de borrar/restablecer el empleado?');")
            );

            $filas[$clave]["opciones"] = $cadena;
        }

        //definiciones de las cabeceras de las
        //columnas para el CGrid
        $cabecera = array(
            array(
                "ETIQUETA" => "Nombre",
                "CAMPO" => "nombre",
                "ANCHO" => "20%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "nif",
                "ETIQUETA" => "NIF",
                "ANCHO" => "15%",
                "ALINEA" => "cen"
            ),
            array(
                "ETIQUETA" => "Fecha de nacimiento",
                "CAMPO" => "fecha_nac",
                "ANCHO" => "25%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "foto",
                "ETIQUETA" => "Foto",
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
            "URL" => Sistema::app()->generaURL(array("empleados", "index")),
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
                "modelo" => $empleado,
                "fil" => $datosFiltrado,
                "filas" => $filas,
                "cabe" => $cabecera,
                "opcPag" => $opcPaginador
            ),
            "Lista de empleados"
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

        $empleado  = new Empleados();
        $nombre =  $empleado->getNombre();

        if (isset($_POST[$nombre])) {

            $empleado->setValores($_POST[$nombre]);

            if ($empleado->validar()) {

                if (!$empleado->guardar()) {
                    $this->dibujaVista(
                        "nuevo",
                        array("modelo" => $empleado),
                        "Nuevo empleado"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["empleados"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "nuevo",
                    array("modelo" => $empleado),
                    "Nuevo empleado"
                );
                exit;
            }
        }

        $this->dibujaVista("nuevo", ["modelo" => $empleado], "Nuevo empleado");
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
        $empleado  = new Empleados();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$empleado->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        $this->dibujaVista("consulta", ["modelo" => $empleado], "Consultar empleado");
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
        $empleado  = new Empleados();
        $nombre = $empleado->getNombre();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$empleado->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        if (isset($_POST[$nombre])) {

            $empleado->setValores($_POST[$nombre]);

            if ($empleado->validar()) {

                if (!$empleado->guardar()) {
                    $this->dibujaVista(
                        "modificar",
                        array("modelo" => $empleado),
                        "Modificar empleado"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["empleados"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "modificar",
                    array("modelo" => $empleado),
                    "Modificar empleado"
                );
                exit;
            }
        }

        $this->dibujaVista(
            "modificar",
            array("modelo" => $empleado),
            "Modificar empleado"
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
        $empleado = new Empleados();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$empleado->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        if ($empleado->borrado) {

            $sentencia = "update empleados set borrado = false where cod_empleado = '$id'";
            $empleado->ejecutarSentencia($sentencia);
        } else {

            $sentencia = "update empleados set borrado = true where cod_empleado = '$id'";
            $empleado->ejecutarSentencia($sentencia);
        }

        Sistema::app()->irAPagina(["empleados"]);
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

        $nombreSalida = "DatosEmpleado.txt";

        header("Content-Type: text/plain");
        header("Content-Disposition: attachmente;filename=" . $nombreSalida);

        $usuario = new Empleados();

        foreach ($usuario->buscarTodos() as $indice => $valor) {

            echo "Nombre => " . $valor["nombre"] . "\n" .
                "NIF => " . $valor["nif"] . "\n" .
                "Fecha de nacimiento => " . $valor["fecha_nac"] . "\n\n";
        }
    }
}
