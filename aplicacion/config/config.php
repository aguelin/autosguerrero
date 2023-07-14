<?php
	$config=array("CONTROLADOR"=> array("inicial"),
				  "RUTAS_INCLUDE"=>array("aplicacion/modelos"),
				  "URL_AMIGABLES"=>true,
				  "VARIABLES"=>array("autor"=>"Álvaro Guerrero Linares",
				  					"direccion"=>"C/ María Zambrano, 19",
								    "n_alumnos"=>12),
				  "BD"=>array("hay"=>true,
								"servidor"=>"localhost",
								"usuario"=>"alvaro",
								"contra"=>"alvaro",
								"basedatos"=>"autosguerrero"),
				  "sesion" => array("controlAutomatico"=>true),
				  "ACL"=>array("controlAutomatico"=>true));

// $servidor = "127.0.0.1";
// $usuario = "2daw12";
// $contrasenia = "2daw";
// $bd = "BD2DAW12";