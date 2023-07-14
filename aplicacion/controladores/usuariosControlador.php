<?php

class usuariosControlador extends CControlador
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

        if (!Sistema::app()->Acceso()->puedePermiso(3)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $usuario = new Usuarios();

        $sentencia = "";

        //obtengo las opciones de filtrado
        $datosFiltrado = [
            "nick" => "",
            "borrado" => ""
        ];
        if (isset($_POST["filtrar"])) {
            $sentencia = "";

            // Validar nick
            $nick = "";
            if (isset($_POST["nick"])) {
                $nick = $_POST["nick"];
                $datosFiltrado["nick"] = $nick;
                $nick = CGeneral::addSlashes($nick);

                if ($nick != "") {
                    if ($sentencia != "")
                        $sentencia .= " and nick regexp '.*$nick.*'";
                    else
                        $sentencia .= " nick regexp '.*$nick.*'";
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

        $nRegistros = $usuario->buscarTodosNRegistros($opciones);
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
        $filas = $usuario->buscarTodos($opciones);
        foreach ($filas as $clave => $fila) {
            $filas[$clave]["fecha_nacimiento"] =
                CGeneral::fechaMysqlANormal(
                    $filas[$clave]["fecha_nacimiento"]
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
                    array("usuarios", "consultar"),
                    array("id" => $filas[$clave]["cod_usuario"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/modificar.png'
                ),
                Sistema::app()->generaURL(
                    array("usuarios", "modificar"),
                    array("id" => $filas[$clave]["cod_usuario"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/borrar.png'
                ),
                Sistema::app()->generaURL(
                    array("usuarios", "borrar"),
                    array("id" => $filas[$clave]["cod_usuario"])
                ),
                array("onclick" => "return confirm('&iquest;Está seguro de borrar/restablecer el usuario?');")
            );

            $filas[$clave]["opciones"] = $cadena;
        }

        //definiciones de las cabeceras de las
        //columnas para el CGrid
        $cabecera = array(
            array(
                "ETIQUETA" => "Nick",
                "CAMPO" => "nick",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "ETIQUETA" => "Nombre",
                "CAMPO" => "nombre",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "nif",
                "ETIQUETA" => "NIF",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),

            array(
                "CAMPO" => "direccion",
                "ETIQUETA" => "Direccion",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "poblacion",
                "ETIQUETA" => "Población",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "provincia",
                "ETIQUETA" => "Provincia",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "cp",
                "ETIQUETA" => "CP",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "correo",
                "ETIQUETA" => "Correo",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "fecha_nacimiento",
                "ETIQUETA" => "Fecha de nacimiento",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "borrado",
                "ETIQUETA" => "Borrado",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "foto",
                "ETIQUETA" => "Foto",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "opciones",
                "ETIQUETA" => " Operaciones",
                "ANCHO" => "150px",
                "ALINEA" => "cen"
            )
        );

        //opciones del paginador
        $opcPaginador = array(
            "URL" => Sistema::app()->generaURL(array("usuarios", "index")),
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
                "modelo" => $usuario,
                "fil" => $datosFiltrado,
                "filas" => $filas,
                "cabe" => $cabecera,
                "opcPag" => $opcPaginador
            ),
            "Lista de productos"
        );
    }

    // Acción de creación

    public function accionNuevo()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(3)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $usuario  = new Usuarios();
        $nombre =  $usuario->getNombre();

        if (isset($_POST[$nombre])) {

            $usuario->setValores($_POST[$nombre]);

            if ($usuario->validar()) {

                Sistema::app()->ACL()->anadirUsuario($usuario->nombre, $usuario->nick, $usuario->contrasenia, $usuario->role);

                if (!$usuario->guardar()) {
                    $this->dibujaVista(
                        "nuevo",
                        array("modelo" =>  $usuario),
                        "Nuevo usuario"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["usuarios"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "nuevo",
                    array("modelo" =>  $usuario),
                    "Nuevo usuario"
                );
                exit;
            }
        }

        $this->dibujaVista("nuevo", ["modelo" => $usuario], "Nuevo usuario");
    }

    // Acción de consulta

    public function accionConsultar()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(3)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $id = 0;
        $usuario  = new Usuarios();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$usuario->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        $this->dibujaVista("consulta", ["modelo" => $usuario], "Consultar usuario");
    }

    // Acción de modificado

    public function accionModificar()
    {
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(3)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $id = 0;
        $usuario  = new Usuarios();
        $nombre = $usuario->getNombre();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$usuario->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        if (isset($_POST[$nombre])) {

            $usuario->setValores($_POST[$nombre]);

            if ($usuario->validar()) {

                if (!$usuario->guardar()) {
                    $this->dibujaVista(
                        "modificar",
                        array("modelo" => $usuario),
                        "Modificar usuario"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["usuarios"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "modificar",
                    array("modelo" => $usuario),
                    "Modificar usuario"
                );
                exit;
            }
        }

        $this->dibujaVista(
            "modificar",
            array("modelo" => $usuario),
            "Modificar usuario"
        );
    }

    // Acción de borrado

    public function accionBorrar()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(3)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $id = 0;
        $usuario = new Usuarios();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$usuario->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        if ($usuario->borrado) {

            $sentencia = "update usuarios set borrado = false where cod_usuario = '$id'";
            $usuario->ejecutarSentencia($sentencia);
        } 
        else {
            
            $sentencia = "update usuarios set borrado = true where cod_usuario = '$id'";
            $usuario->ejecutarSentencia($sentencia);
        }

        Sistema::app()->irAPagina(["usuarios"]);
        exit;
    }

    // Acción de descarga de datos

    public function accionDescargarMensajes()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(3)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $nombreSalida = "DatosUsuario.txt";

        header("Content-Type: text/plain");
        header("Content-Disposition: attachmente;filename=" . $nombreSalida);

        $usuario = new Usuarios();

        foreach ($usuario->buscarTodos() as $indice => $valor) {

            echo "Nick => " . $valor["nick"] . "\n" .
                "NIF => " . $valor["nif"] . "\n" .
                "Correo => " . $valor["correo"] . "\n\n";
        }
    }
}
