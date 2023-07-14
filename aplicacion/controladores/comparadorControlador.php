<?php

class comparadorControlador extends CControlador
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

        $this->dibujaVista("index", [], "Comparador");
    }

    /**
     * Esta función carga todos los coches y los devuelve en formato JSON.
     */
    public function accionCargar()
    {

        $producto  = new Nuevos();

        $opciones = [];

        $opciones["where"] = "borrado = false";

        $coches = $producto->buscarTodos($opciones);

        echo json_encode($coches,true);

    }

    // Muestra los coches

    public function accionMostrar()
    {

        $producto  = new Nuevos(); 

        $opciones["where"] = "cod_coche = ".$_POST["selectValue"]; 

        $coches = $producto->buscarTodos($opciones);

        echo json_encode($coches,true);

    }


}
