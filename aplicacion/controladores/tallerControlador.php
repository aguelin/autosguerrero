<?php

class tallerControlador extends CControlador
{

	public function __construct()
	{
		$this->plantilla = "coches";
	}

	// Controlador inicial

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

		$opciones = [];

		$opciones["order"] = "fecha asc,cod_cita asc";

		$filas = $citas->buscarTodos($opciones);

		if (!$filas) {
			Sistema::app()->paginaError(400, "No se han podido obtener las citas");
			return;
		}

		if (isset($_POST["reservar"])) {

			$cod_cita = intval($_POST["cod_cita"]);
			$cod_usuario = Sistema::app()->ACL()->getCodUsuario(Sistema::app()->Acceso()->getNick());

			$sentencia = "update citas_taller set cod_usuario = ".$cod_usuario.", borrado = true where cod_cita = ".$cod_cita;

			Sistema::app()->BD()->crearConsulta($sentencia);

		}

		$this->dibujaVista("index", ["citas" => $filas], "Citas del taller");
	}

	/**
	 * La función  recupera todas las citas de una base de datos y las devuelve como una
	 * cadena codificada en JSON.
	 */
	public function accionMostrar()
	{

		$citas = new Citas();

		$opciones = [];

		$opciones["order"] = "fecha asc,cod_cita asc";

		$todos = $citas->buscarTodos($opciones);

		echo json_encode($todos, true);
	}

	/**
	 * Esta función actualiza un registro en la base de datos para marcar una reserva como
	 * eliminada y la asigna a un usuario específico.
	 */
	public function accionReservar()
	{

		$cod_cita = intval($_POST["cod_cita"]);
		$cod_usuario = Sistema::app()->ACL()->getCodUsuario(Sistema::app()->Acceso()->getNick());

		$sentencia = "update citas_taller set cod_usuario = " . $cod_usuario . ", borrado = true where cod_cita = " . $cod_cita;

		Sistema::app()->BD()->crearConsulta($sentencia);


	}
}
