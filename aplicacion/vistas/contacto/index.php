<?php

$this->titulo = "Contacto";
$this->cssHead = CHTML::cssFichero("/estilos/contacto.css");
$this->scriptHead = CHTML::scriptFichero("/javascript/contacto.js", ["defer" => "defer"]);

?>

<h1 class="text-center">¿Necesitas ayuda?</h1>

<div id="contenido">

  <div id="map"></div>

  <div id="datosEmpresa">

    <div id="datos">

      <h3 class="text-center">Contacta con nosotros</h3>

      <div>
        <p><b>Dirección:</b> C. Cueva de Viera, 2, 29200 Antequera, Málaga <br><br>
          <b>Correo:</b> autossguerrero@gmail.com <b>Teléfono:</b> +34 123 456 789
        </p>
      </div>

    </div>

    <div id="form-contacto">

      <h3 class="text-center">¿Alguna incidencia?</h3>
      <div class="container py-5 h-100">
        <form action="https://formsubmit.co/65e83af072b165ff3dfee575eac73c24" method="POST">

          <div class="row row-cols-1">
            <div class="col col-md-6">
              <div class="form-floating mb-4">
                <input type="text" name="Nombre" class="form-control" placeholder="Nombre" required>
                <label for="">Nombre</label>
              </div>
            </div>
            <div class="col col-md-6">
              <div class="form-floating mb-4">
                <input type="email" name="Correo" class="form-control" placeholder="name@example.com" required>
                <label for="">Correo</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-floating-prepend mb-4">
                <textarea name="Motivo" class="form-control" rows="5" placeholder="Motivo"></textarea>
              </div>
            </div>
          </div>

          <button class="btn btn-primary col-md-3" type="submit">Enviar</button>

        </form>
      </div>



    </div>

  </div>
</div>