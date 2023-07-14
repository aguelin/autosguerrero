<?php

class alquilerControlador extends CControlador
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

        $producto = new Alquiler();

        $sentencia = "";

        //obtengo las opciones de filtrado
        $datosFiltrado = [
            "nombre" => "",
            "categoria" => "",
            "borrado" => ""
        ];
        if (isset($_POST["filtrar"])) {
            $sentencia = "";

            // Validar nombre
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


            // Validar categoria
            $categoria = "";
            if (isset($_POST["categoria"])) {
                $categoria = $_POST["categoria"];
                $datosFiltrado["categoria"] = $categoria;
                $categoria = CGeneral::addSlashes($categoria);
                if ($categoria != 0) {
                    if ($sentencia != "")
                        $sentencia .= " and cod_categoria=" . $categoria;
                    else
                        $sentencia .= " cod_categoria=" . $categoria;
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

        $nRegistros = $producto->buscarTodosNRegistros($opciones);
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
        $filas = $producto->buscarTodos($opciones);
        foreach ($filas as $clave => $fila) {
            $filas[$clave]["fecha_inicio"] =
                CGeneral::fechaMysqlANormal(
                    $filas[$clave]["fecha_inicio"]
                );

            $filas[$clave]["fecha_fin"] =
            CGeneral::fechaMysqlANormal(
                    $filas[$clave]["fecha_fin"]
                );

            $ruta = "/imagenes/alquiler/";

            if ($fila["foto"] != "")
                $ruta .= $fila["foto"];
            else
                $ruta .= "base.jpg";

            $filas[$clave]["foto"] = CHTML::imagen($ruta, "imagen", ["witdth" => 100, "height" => 100]);

            //botones


            $cadena = CHTML::link(
                CHTML::imagen("/imagenes/24x24/ver.png"),
                Sistema::app()->generaURL(
                    array("alquiler", "consultar"),
                    array("id" => $filas[$clave]["cod_alquiler"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/modificar.png'
                ),
                Sistema::app()->generaURL(
                    array("alquiler", "modificar"),
                    array("id" => $filas[$clave]["cod_alquiler"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/borrar.png'
                ),
                Sistema::app()->generaURL(
                    array("alquiler", "borrar"),
                    array("id" => $filas[$clave]["cod_alquiler"])
                ),
                array("onclick" => "return confirm('&iquest;Está seguro de borrar/restablecer el vehículo?');")
            );

            $filas[$clave]["opciones"] = $cadena;
        }

        //definiciones de las cabeceras de las
        //columnas para el CGrid
        $cabecera = array(
            array(
                "ETIQUETA" => "Nombre",
                "CAMPO" => "nombre",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "fabricante",
                "ETIQUETA" => "Fabricante",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "desc_categoria",
                "ETIQUETA" => "Categoría",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "num_plazas",
                "ETIQUETA" => "Plazas",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "fecha_inicio",
                "ETIQUETA" => "Fecha de inicio",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "fecha_fin",
                "ETIQUETA" => "Fecha de fin",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "precio",
                "ETIQUETA" => "Precio",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "foto",
                "ETIQUETA" => "Foto",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "borrado",
                "ETIQUETA" => "Borrado",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "opciones",
                "ETIQUETA" => " Operaciones",
                "ANCHO" => "10%",
                "ALINEA" => "cen"
            )
        );

        //opciones del paginador
        $opcPaginador = array(
            "URL" => Sistema::app()->generaURL(array("alquiler", "index")),
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
                "modelo" => $producto,
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

        if (!Sistema::app()->Acceso()->puedePermiso(2)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $producto  = new Alquiler();
        $nombre = $producto->getNombre();

        if (isset($_POST[$nombre])) {

            $producto->setValores($_POST[$nombre]);

            if ($producto->validar()) {

                if (!$producto->guardar()) {
                    $this->dibujaVista(
                        "nuevo",
                        array("modelo" => $producto),
                        "Nuevo vehículo de alquiler"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["alquiler"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "nuevo",
                    array("modelo" => $producto),
                    "Nuevo vehículo de alquiler"
                );
                exit;
            }
        }

        $this->dibujaVista(
            "nuevo",
            array("modelo" => $producto),
            "Nuevo vehículo de alquiler"
        );
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
        $producto  = new Alquiler();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        $opciones = [];
        $opciones["select"] = "foto";
        $opciones["where"] = "cod_alquiler = ".$id;
        $foto = $producto->buscarTodos($opciones);

        $this->dibujaVista("consulta", ["modelo" => $producto,"foto" => $foto], "Consultar alquiler");

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
        $producto  = new Alquiler();
        $nombre = $producto->getNombre();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        if (isset($_POST[$nombre])) {

            $producto->setValores($_POST[$nombre]);

            if ($producto->validar()) {

                if (!$producto->guardar()) {
                    $this->dibujaVista(
                        "modificar",
                        array("modelo" => $producto),
                        "Modificar vehículo de alquiler"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["alquiler"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "modificar",
                    array("modelo" => $producto),
                    "Modificar vehículo de alquiler"
                );
                exit;
            }
        }

        $this->dibujaVista(
            "modificar",
            array("modelo" => $producto),
            "Modificar vehículo de alquiler"
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
        $producto  = new Alquiler();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        if ($producto->borrado) {

            $sentencia = "update alquiler set borrado = false where cod_alquiler = '$id'";
            $producto->ejecutarSentencia($sentencia);
        } else {

            $sentencia = "update alquiler set borrado = true where cod_alquiler = '$id'";
            $producto->ejecutarSentencia($sentencia);
        }


        Sistema::app()->irAPagina(["alquiler"]);
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

        $nombreSalida = "DatosAlquiler.txt";

        header("Content-Type: text/plain");
        header("Content-Disposition: attachmente;filename=" . $nombreSalida);

        $producto = new Alquiler();

        foreach ($producto->buscarTodos() as $indice => $valor) {

            echo "Nombre => " . $valor["nombre"] . "\n" .
                "Categoría => " . $valor["desc_categoria"] . "\n" .
                "Fabricante => " . $valor["fabricante"] . "\n" .
                "Fecha de inicio => " . $valor["fecha_inicio"] . "\n". 
                "Fecha de fin => " . $valor["fecha_fin"] . "\n\n";
        }
    }


}


   