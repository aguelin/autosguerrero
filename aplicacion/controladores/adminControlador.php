<?php

class adminControlador extends CControlador
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

        $this->dibujaVista("index", [], "Administración");
    }
}
