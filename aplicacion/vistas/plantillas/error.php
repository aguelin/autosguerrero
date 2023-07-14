<?php
header("HTTP/1.1 $numError $mensaje");
header("Status: $numError $mensaje");

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ERROR</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/estilos/error.css" />
	<link rel="icon" type="image/png" href="/imagenes/favicon.png" />

</head>

<body>
	<div id="todo">
		<header>
			<div class="logo">
				<a href="/index.php"><img src="/imagenes/logo.png" width="210px" /></a>
			</div>
			<div class="titulo">
				<a href="/index.php">
					<h1></h1>
				</a>
			</div>
		</header><!-- #header -->

		<div class="contenido">

			<h1>Error 404 - Página no encontrada</h1>
			<p>Lo sentimos, la página que estás buscando no se encuentra disponible.</p>
			<p>Por favor, verifica la URL ingresada o vuelve a la <a href="/inicial">página de inicio</a> del concesionario.</p>

		</div>

	</div><!-- #wrapper -->
</body>

</html>