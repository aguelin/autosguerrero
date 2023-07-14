<?php

class resumenControlador extends CControlador
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

        $citas = new Citas();
        
        $cod_usuario = Sistema::app()->ACL()->getCodUsuario(Sistema::app()->Acceso()->getNick());

        $opciones = [];
        $opciones["where"] = "cod_usuario = ".$cod_usuario;
        $opciones["order"] = "fecha desc";

        $todos1 = $citas->buscarTodos($opciones);

        $compras  = new Compras();

        $todos2 = $compras->buscarTodos($opciones);


        $this->dibujaVista("index",["citas"=>$todos1,"compras"=>$todos2],"Resumen");
    }

    /**
     * Esta función cancela una cita de taller.
     */
    public function accionCancelaCita(){

        $cod_cita = intval($_POST["cod_cita"]);

        $sentencia = "UPDATE citas_taller SET borrado = false,cod_usuario = null WHERE cod_cita = ".$cod_cita;

        Sistema::app()->BD()->crearConsulta($sentencia);

    }

}
