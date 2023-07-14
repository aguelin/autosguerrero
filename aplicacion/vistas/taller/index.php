<?php
$this->titulo = "Citas del taller";
$this->cssHead = CHTML::cssFichero("/estilos/citas.css");
$this->scriptHead = CHTML::scriptFichero("/javascript/taller.js", ["defer"=>"defer", "type" => "module"]);

?>



    <h1 class="text-center">Citas del taller</h1>
    <div id="fila" class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 p-5">

        <?php

        foreach ($citas as $fila) {


            $this->dibujaVistaParcial("indexCita", ["fila" => $fila], false);
        }

        ?>
    </div>

