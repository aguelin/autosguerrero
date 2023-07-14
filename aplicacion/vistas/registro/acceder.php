<?php

$this->titulo = "Acceder";
$this->cssHead = CHTML::cssFichero("/estilos/login.css");

?>


<div class="container">
  <div class="row d-flex justify-content-center align-items-center">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
      <div class="card bg-dark text-white" style="border-radius: 1rem;">
        <div class="card-body p-4 text-center">
          <h2 class="fw-bold  text-uppercase">Acceso</h2>
          <p class="text-white-50 mb-3">Introduzca su Usuario y Contraseña</p>
          <?php

          echo CHTML::iniciarForm();

          ?>
          <div class="form-outline form-white mb-3">
            <?php
            echo CHTML::modeloLabel($modelo, "nick", ["class" => "form-label"]);
            echo CHTML::modeloText($modelo, "nick", ["maxlength" => 20, "class" => "form-control form-control-lg"]);
            echo CHTML::modeloError($modelo, "nick");
            ?>
          </div>


          <div class="form-outline form-white mb-3">
            <?php
            echo CHTML::modeloLabel($modelo, "contrasenia", ["class" => "form-label"]);
            echo CHTML::modeloPassword($modelo, "contrasenia", ["maxlength" => 20, "class" => "form-control form-control-lg"]);
            echo CHTML::modeloError($modelo, "contrasenia");

            ?>
            <br><br>
            <button class="btn btn-outline-light btn-lg px-4" type="submit">Acceder</button>

            <?php
            echo CHTML::finalizarForm();
            ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>