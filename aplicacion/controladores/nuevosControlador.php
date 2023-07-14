<?php

class nuevosControlador extends CControlador
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

        $producto = new Nuevos();

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
            $filas[$clave]["fecha_fab"] =
                CGeneral::fechaMysqlANormal(
                    $filas[$clave]["fecha_fab"]
                );

            $ruta = "/imagenes/nuevos/";

            if ($fila["foto"] != "")
                $ruta .= $fila["foto"];
            else
                $ruta .= "base.jpg";

            $filas[$clave]["foto"] = CHTML::imagen($ruta, "imagen", ["witdth" => 100, "height" => 100]);

            //botones


            $cadena = CHTML::link(
                CHTML::imagen("/imagenes/24x24/ver.png"),
                Sistema::app()->generaURL(
                    array("nuevos", "consultar"),
                    array("id" => $filas[$clave]["cod_coche"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/modificar.png'
                ),
                Sistema::app()->generaURL(
                    array("nuevos", "modificar"),
                    array("id" => $filas[$clave]["cod_coche"])
                )
            );
            $cadena .= CHTML::link(
                CHTML::imagen(
                    '/imagenes/24x24/borrar.png'
                ),
                Sistema::app()->generaURL(
                    array("nuevos", "borrar"),
                    array("id" => $filas[$clave]["cod_coche"])
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
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "fabricante",
                "ETIQUETA" => "Fabricante",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "desc_categoria",
                "ETIQUETA" => "Categoría",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "desc_combustible",
                "ETIQUETA" => "Combustible",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "desc_color",
                "ETIQUETA" => "Color",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "num_puertas",
                "ETIQUETA" => "Puertas",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "num_plazas",
                "ETIQUETA" => "Plazas",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "caja_cambios",
                "ETIQUETA" => "Caja",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "potencia",
                "ETIQUETA" => "Potencia",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "km",
                "ETIQUETA" => "Km",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "fecha_fab",
                "ETIQUETA" => "Fabricación",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "unidades",
                "ETIQUETA" => "Unidades",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "iva",
                "ETIQUETA" => "IVA",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "precio_total",
                "ETIQUETA" => "Precio",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "oferta",
                "ETIQUETA" => "Oferta",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "precio_oferta",
                "ETIQUETA" => "Precio de oferta",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "foto",
                "ETIQUETA" => "Foto",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "borrado",
                "ETIQUETA" => "Borrado",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            ),
            array(
                "CAMPO" => "opciones",
                "ETIQUETA" => " Operaciones",
                "ANCHO" => "100px",
                "ALINEA" => "cen"
            )
        );

        //opciones del paginador
        $opcPaginador = array(
            "URL" => Sistema::app()->generaURL(array("nuevos", "index")),
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

        $producto  = new Nuevos();
        $nombre = $producto->getNombre();

        if (isset($_POST[$nombre])) {

            $producto->setValores($_POST[$nombre]);

            if ($producto->validar()) {

                if (!$producto->guardar()) {
                    $this->dibujaVista(
                        "nuevo",
                        array("modelo" => $producto),
                        "Nuevo vehículo"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["nuevos"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "nuevo",
                    array("modelo" => $producto),
                    "Nuevo vehículo"
                );
                exit;
            }
        }

        $this->dibujaVista("nuevo", ["modelo" => $producto], "Nuevo vehículo");
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
        $producto  = new Nuevos();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        $opciones = [];
        $opciones["select"] = "foto";
        $opciones["where"] = "cod_coche = ".$id;
        $foto = $producto->buscarTodos($opciones);

        $this->dibujaVista("consulta", ["modelo" => $producto,"foto" => $foto], "Consultar vehículo");
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
        $producto  = new Nuevos();
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
                        "Modificar vehículo"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["nuevos"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "modificar",
                    array("modelo" => $producto),
                    "Modificar vehículo"
                );
                exit;
            }
        }

        $this->dibujaVista(
            "modificar",
            array("modelo" => $producto),
            "Modificar vehículo"
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
        $producto  = new Nuevos();

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }

        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Error");
            return;
        }

        if ($producto->borrado) {

            $sentencia = "update coches set borrado = false where cod_coche = '$id'";
            $producto->ejecutarSentencia($sentencia);
        } else {

            $sentencia = "update coches set borrado = true where cod_coche = '$id'";
            $producto->ejecutarSentencia($sentencia);
        }


        Sistema::app()->irAPagina(["nuevos"]);
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

        $nombreSalida = "DatosCoches.txt";

        header("Content-Type: text/plain");
        header("Content-Disposition: attachmente;filename=" . $nombreSalida);

        $producto = new Nuevos();

        foreach ($producto->buscarTodos() as $indice => $valor) {

            echo "Nombre => " . $valor["nombre"] . "\n" .
                "Categoría => " . $valor["desc_categoria"] . "\n" .
                "Fabricante => " . $valor["fabricante"] . "\n" .
                "Unidades => " . $valor["unidades"] . "\n\n";
        }
    }


}


   