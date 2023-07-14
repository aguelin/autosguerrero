<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo $titulo; ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width; initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="/estilos/nav.css" />
  <link rel="stylesheet" type="text/css" href="/estilos/admin.css" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

  <link rel="icon" type="image/png" href="/imagenes/favicon.png" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

  <title>Autos Guerrero</title>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

  <?php
  if (isset($this->textoHead))
    echo $this->textoHead;
  ?>
</head>


<body>

  <header>

    <nav>

      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>

      <a href="/inicial"><img src="/imagenes/logo.png" alt="logo" class="logo"></a>
      <ul class="menuPrincipal">
        <li>
          <a href="/coches" class="linea">NUESTROS COCHES</a>
        </li>
        <li><a href="/ofertas" class="linea">OFERTAS</a></li>
        <li>
          <a href="#">SERVICIOS </a>
          <ul class="submenu">
            <li><a href="/alquilerCoches">Alquiler</a></li>
            <li><a href="/comparador">Comparador</a></li>
            <li><a href="/taller">Citas</a></li>
          </ul>
        </li>
        <li>
          <a href="#">EMPRESA</a>
          <ul class="submenu">
            <li><a href="/contacto">Contacto</a></li>
            <li><a href="/FAQ">FAQ</a></li>
            <li><a href="/nosotros">Nosotros</a></li>
          </ul>
        </li>
      </ul>


      <div class="accesos">

        <?php
        if (Sistema::app()->Acceso()->puedePermiso(2)) {

        ?>

          <a href="/admin"><img src="/imagenes/inicio/engranaje.png" alt="admin"></a>

        <?php
        }
        ?>

        <?php
        if (Sistema::app()->Acceso()->hayUsuario()) {
        ?>

          <li>
            <a href="#"><img src="/imagenes/inicio/usuario.png" alt="">&nbsp; <?php echo Sistema::app()->Acceso()->getNick(); ?> </a>
            <ul class="submenuLogin" id="perfil">
              <li><a href="/resumen">Resumen</a></li>
              <li><?php echo CHTML::link("Cerrar sesión", Sistema::app()->generaURL(["registro", "CerrarSesion"])); ?></li>
            </ul>
          </li>



        <?php
        } else {

        ?>
          <li>
            <a href="#"><img src="/imagenes/inicio/usuario.png" alt=""><?php echo Sistema::app()->Acceso()->getNick(); ?></a>
            <ul id="perfil" class="submenuLogin">
              <li><?php echo CHTML::link("Acceder", Sistema::app()->generaURL(["registro", "Login"])); ?></li>
              <li><?php echo CHTML::link("Registro", Sistema::app()->generaURL(["registro", "PedirDatosRegistro"])); ?></li>
            </ul>
          </li>
        <?php
        }
        ?>

      </div>



    </nav>

  </header>

  <main>

    <aside>

      <div class="d-flex" id="content-wrapper">
        <div id="sidebar-container">
          <div class="logo">
            <h4 class="text-light font-weight-bold mb-0">Panel de control</h4>
          </div>
          <div class="menu">

            <a href="/usuarios" class="d-block text-light p-3 border-0"><i class="icon ion-md-people lead mr-2"></i>
              Usuarios</a>

            <a href="/empleados" class="d-block text-light p-3 border-0"> <i class="icon ion-md-settings lead mr-2"></i>
              Empleados</a>

            <a href="/nuevos" class="d-block text-light p-3 border-0"><i class="icon ion-md-car lead mr-2"></i>
              Coches</a>

            <a href="/alquiler" class="d-block text-light p-3 border-0"><i class="icon ion-md-stats lead mr-2"></i>
              Alquiler</a>

            <a href="/compras" class="d-block text-light p-3 border-0"><i class="icon ion-md-basket lead mr-2"></i>
              Compras</a>

            <a href="/comprasAlquiler" class="d-block text-light p-3 border-0"><i class="icon ion-md-basket lead mr-2"></i>
              Compras alquiler</a>

            <a href="/citas" class="d-block text-light p-3 border-0"> <i class="icon ion-md-book lead mr-2"></i>
              Citas del taller</a>

            <a href="javascript:history.back();" class="d-block text-light p-3 border-0"><i class="icon ion-md-apps lead mr-2"></i>
              Volver</a>

          </div>
        </div>
      </div>

    </aside>

    <div id="contenido">
      <?php if ($contenido) {
        echo $contenido;
      } ?>
    </div>


  </main>

</body>

</html>