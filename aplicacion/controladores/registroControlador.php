<?php

class registroControlador extends CControlador
{

	public function __construct()
	{
		$this->plantilla = "coches";
	}

	// Acción de regristro

	public function accionPedirDatosRegistro()
	{

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
                        "Registro"
                    );
                    exit;
                }

                Sistema::app()->irAPagina(["usuarios"]);
                exit;
            } else { //no es valido, vuelvo a mostrar los valores
                $this->dibujaVista(
                    "nuevo",
                    array("modelo" =>  $usuario),
                    "Registro"
                );
                exit;
            }
        }

        $this->dibujaVista("nuevo", ["modelo" => $usuario], "Registro");
	}

	// Acción de logueo

	public function accionLogin()
	{
		$login  = new Login();
		$nombre = $login->getNombre();

		if (isset($_POST[$nombre])) {

			$login->setValores($_POST[$nombre]);

			if ($login->validar()) {

				Sistema::app()->irAPagina(["inicial"]);
				exit;
			} else { //no es valido, vuelvo a mostrar los valores
				$this->dibujaVista(
					"acceder",
					array("modelo" => $login),
					"Acceso"
				);
				exit;
			}
		}


		$this->dibujaVista("acceder", ["modelo" => $login], "Acceso");
	}

	/**
	 * La función cierra la sesión del usuario actual y lo redirige a la página de
	 * inicio.
	 */
	public function accionCerrarSesion(){

		Sistema::app()->Acceso()->quitarRegistroUsuario();

		Sistema::app()->irAPagina(["inicial"]);
		exit;

	}

}
