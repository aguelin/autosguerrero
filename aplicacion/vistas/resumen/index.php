<?php

$this->titulo = "Resumen";
$this->cssHead = CHTML::cssFichero("/estilos/resumen.css");
$this->scriptHead = CHTML::scriptFichero("/javascript/resumen.js", ["defer" => "defer", "type" => "module"]);

?>

<h1 class="text-center">Resumen</h1>


<div id="contenido">

  <div id="compras">
    <h2 class="text-center">Mis Compras</h1>
      

      <div id="container1" class="container1 py-5">

        <div id="fila1" class="row row-cols-1 row-cols-md-2 g-4 ">

          <?php

          foreach ($compras as $fila) {
            $this->dibujaVistaParcial("indexCompra", ["fila" => $fila], false);
          }

          ?>

        </div>

      </div>

  </div>

  <div id="citas">
    <h2 class="text-center">Mis Citas</h1>
      

      <div id="container2" class="container2 py-5">

        <div id="fila2" class="row row-cols-1 row-cols-md-2 g-4">

          <?php

          foreach ($citas as $fila) {
            $this->dibujaVistaParcial("indexCita", ["fila" => $fila], false);
          }

          ?>

        </div>

      </div>

  </div>

</div>