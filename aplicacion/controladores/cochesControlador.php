<?php

include_once(RUTA_BASE . "/scripts/tcpdf/tcpdf.php");

class cochesControlador extends CControlador
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

        $this->dibujaVista("index", [], "Coches");
    }

    public function accionMostrar()
    {

        $producto  = new Nuevos();
                

        $sentencia = "borrado = false";

            // Validar marca
            $marca = "";
            if (isset($_POST["marca"])) {
                $marca = $_POST["marca"];
                $marca = CGeneral::addSlashes($marca);

                if ($marca != "") {
                    if ($sentencia != "")
                        $sentencia .= " and fabricante regexp '.*$marca.*'";
                    else
                        $sentencia .= " fabricante regexp '.*$marca.*'";
                }
            }

            // Validar modelo
            $modelo = "";
            if (isset($_POST["modelo"])) {
                $modelo = $_POST["modelo"];
                $modelo = CGeneral::addSlashes($modelo);

                if ($modelo != "") {
                    if ($sentencia != "")
                        $sentencia .= " and nombre regexp '.*$modelo.*'";
                    else
                        $sentencia .= " nombre regexp '.*$modelo.*'";
                }
            }

            // Validar precio
            $precio = 0;
            if (isset($_POST["precio"])) {
                $precio = $_POST["precio"];
                $precio = floatval($precio);

                if ($precio != "") {
                    if ($sentencia != "")
                        $sentencia .= " and (precio_total <= ".$precio." or precio_oferta <= ".$precio.")";
                    else
                        $sentencia .= " (precio_total <= ".$precio." or precio_oferta <= ".$precio.")";
                }
            }

            // Validar km
            $km = 0;
            if (isset($_POST["km"])) {
                $km = $_POST["km"];
                $km = floatval($km);

                if ($km != "") {
                    if ($sentencia != "")
                        $sentencia .= " and km <= ".$km;
                    else
                        $sentencia .= " km <= ".$km;
                }
            }

             // Validar fecha
             $fecha_inicio = "";
             $fecha_fin = "";

             if (isset($_POST["fecha_inicio"]) && isset($_POST["fecha_fin"])) {
                 
                 $fecha_inicio = $_POST["fecha_inicio"];
                 $fecha_fin = $_POST["fecha_fin"];

                 $fecha_inicio = intval($fecha_inicio);
                 $fecha_fin = intval($fecha_fin);
 
                 if ($fecha_inicio != "" && $fecha_fin != "") {
                     if ($sentencia != "")
                         $sentencia .= " and (EXTRACT(YEAR FROM fecha_fab)) BETWEEN ".$fecha_inicio." and ".$fecha_fin;
                     else
                         $sentencia .= " (EXTRACT(YEAR FROM fecha_fab)) BETWEEN ".$fecha_inicio." and ".$fecha_fin;
                 }
             }

             // Validar categoria
            $categoria = 0;
            if (isset($_POST["categoria"])) {
                $categoria = $_POST["categoria"];
                $categoria = floatval($categoria);

                if ($categoria != 0) {
                    if ($sentencia != "")
                        $sentencia .= " and cod_categoria = ".$categoria;
                    else
                        $sentencia .= " cod_categoria = ".$categoria;
                }
            }

            // Validar combustible
            $combustible = 0;
            if (isset($_POST["combustible"])) {
                $combustible = $_POST["combustible"];
                $combustible = floatval($combustible);

                if ($combustible != 0) {
                    if ($sentencia != "")
                        $sentencia .= " and cod_combustible = ".$combustible;
                    else
                        $sentencia .= " cod_combustible = ".$combustible;
                }
            }

            // Validar caja de cambios
            $caja_cambios = "";
            if (isset($_POST["caja_cambios"])) {
                $caja_cambios = $_POST["caja_cambios"];
                $caja_cambios = CGeneral::addSlashes($caja_cambios);

                if ($caja_cambios != "") {
                    if ($sentencia != "")
                        $sentencia .= " and caja_cambios regexp '.*$caja_cambios.*'";
                    else
                        $sentencia .= " caja_cambios regexp '.*$caja_cambios.*'";
                }
            }

        // Validar plazas
        $plazas = 0;
        if (isset($_POST["plazas"])) {
            $plazas = $_POST["plazas"];
            $plazas = floatval($plazas);

            if ($plazas != 0) {
                if ($sentencia != "")
                    $sentencia .= " and num_plazas = ".$plazas;
                else
                    $sentencia .= " num_plazas = ".$plazas;
            }
        }

        // Validar potencia
        $potencia = 50;
        if (isset($_POST["potencia"])) {
            $potencia = $_POST["potencia"];
            $potencia = floatval($potencia);

            if ($potencia >= 50) {
                if ($sentencia != "")
                    $sentencia .= " and potencia <= ".$potencia;
                else
                    $sentencia .= " potencia <= ".$potencia;
            }
        }


        $opciones = [];

        if ($sentencia != "")
            $opciones["where"] = $sentencia;

        $coches = $producto->buscarTodos($opciones);

        echo json_encode($coches,true);

    }


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
     * Esta función recupera una lista de distintos modelos de automóviles en función de un
     * fabricante de automóviles específico.
     */
    public function accionListaModelo(){

        $producto = new Nuevos();
        $marca = CGeneral::addSlashes($_POST["marca"]);

        $opciones = [];

        $opciones["select"] = "DISTINCT(nombre)";
        $opciones["where"] = "fabricante regexp '.*$marca.*'";

        $coches = $producto->buscarTodos($opciones);

        echo json_encode($coches,true);

    }

    /**
     * Esta función genera un informe en PDF para un producto de automóvil específico, incluidos sus
     * detalles y precio.
     */
    public function accionInforme()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "Login"]);
            return;
        }

        if (!Sistema::app()->Acceso()->puedePermiso(1)) {
            Sistema::app()->paginaError(404, "No dispones de permiso para acceder aquí.");
            return;
        }

        $producto = new Nuevos();
        $cod_coche = $_GET["cod_coche"];

        $opciones = [];

        $opciones["where"] = "cod_coche = ".$cod_coche; 

        $pdf = new MiPDF("P","mm","A4");
        // Establece márgenes
        $pdf->setMargins(10, 30, 15);
        $pdf->setHeaderMargin(5);
        $pdf->setFooterMargin(10);


        $pdf->AddPage();

        $html1 = "";
        $html2 = "<br>&nbsp;";
        $html3 = "";

        foreach ($producto->buscarTodos($opciones) as $indice => $valor) {

            $html1 = <<<EOD
                <h1> $valor[fabricante] $valor[nombre] </h1>
            EOD;

            $foto = "";

            if($valor["foto"] == "")
                $foto = RUTA_BASE."/imagenes/nuevos/base.jpg";
            else
                $foto = RUTA_BASE."/imagenes/nuevos/".$valor["foto"];

            $pdf->Image($foto,25,46);

            $html2 .= <<<EOD
                <b>Categoría</b> => $valor[desc_categoria] &nbsp;&nbsp;&nbsp; <b>Fabricación</b> => $valor[fecha_fab] &nbsp;&nbsp;&nbsp; <b>Kilómetros</b> => $valor[km] km
                <br><br>
                <b>Combustible</b> => $valor[desc_combustible] &nbsp;&nbsp;&nbsp; <b>Cambio</b> => $valor[caja_cambios] &nbsp;&nbsp;&nbsp; <b>Motor</b> => $valor[potencia] C.V.
                <br><br>
                <b>Color</b> => $valor[desc_color] &nbsp;&nbsp;&nbsp; <b>Número de puertas</b> => $valor[num_puertas] &nbsp;&nbsp;&nbsp; <b>Número de plazas</b> => $valor[num_plazas]
            EOD;

            if($valor["oferta"] != 0){
                $html3 = <<<EOD
                <h1>&nbsp;&nbsp;&nbsp; Precio <br> $valor[precio_oferta] €</h1>
                EOD;
            }
            else{
                $html3 = <<<EOD
                <h1>&nbsp;&nbsp;&nbsp; Precio <br> $valor[precio_total] €</h1>
                EOD;
            }

           

            
        }

        // Imprimiendo texto usando writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, 70, '', $html1, 0, 1, 0, true, '', true);
        $pdf->writeHTMLCell(0, 0, 25, 140, $html2, 0, 1, 0, true, '', true);
        $pdf->writeHTMLCell(0, 0, 90, 180, $html3, 0, 1, 0, true, '', true);
        

        $pdf->Output('informe.pdf', 'I');

    }
}

// Extiende la clase TCPDF para crear encabezado y pie de página personalizados
class MiPDF extends TCPDF {

	// Encabezado de página
	public function Header() {
		// Logo
		$image_file = RUTA_BASE."/imagenes/logo.png";
		$this->Image($image_file, 20, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Establecer fuente
		$this->setFont('helvetica', 'B', 20);
		$this->setX(50);
        // Título
		$this->Cell(0, 15, 'Autos Guerrero', 0, false, 'C', 0, '', 0, false, 'M', 'M');
       
	}

	// Pie de página
	public function Footer() {
		// Posición a 15 mm desde abajo
		$this->setY(-15);
		// Establecer fuente
		$this->setFont('helvetica', 'I', 8);
		// Número de página
		$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
