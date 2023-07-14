<?php

$this->titulo = "Comparador";
$this->cssHead = CHTML::cssFichero("/estilos/comparador.css");
$this->scriptHead = CHTML::scriptFichero("/javascript/comparador.js", ["defer", "type" => "module"]);

$values = ["fabricante"=>"Marca",
           "nombre"=>"Modelo",
           "desc_categoria"=>"Categoría", 
           "fecha_fab"=>"Fabricación", 
           "km"=>"Kilómetros", 
           "desc_combustible"=>"Combustible",
           "caja_cambios"=>"Cambio", 
           "potencia"=>"Motor", 
           "desc_color"=>"Color", 
           "num_puertas"=>"Nº Puertas",
           "num_plazas"=>"Nº Plazas",
           "precio_total"=>"Precio"];

?>

<h1 class="text-center">Comparador</h1>

<div id="contenido" class="container p-4 row justify-content-around">

  <div id="fila" class="cubo col-md-5">

    <select name="primero" id="primero" class="form-control">
      <option value="0">No seleccionado</option>
    </select>



  </div>

  <div id="fila2" class="cubo col-md-5">

    <select name="segundo" id="segundo" class="form-control">
      <option value="0">No seleccionado</option>
    </select>

  </div>


</div>

<button type="button" id="bComparar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bComparar">Comparar</button>

<div class="modal fade bComparar" role="dialog" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title" id="tituloComparador"> <span id="tituloComparador1"></span>  VS  <span id="tituloComparador2"></span></div>
        <button class="btn-close" data-bs-dismiss="modal" id="closeComparator"></button>
      </div>
      <div class="modal-body">

        <?php
        foreach ($values as $indice => $valor) {
        ?>
          <div class="row">
            <div class="col"><b><?php echo $valor?></b></div>
            <div class="row">
              <div class="col col-6 coche1" id="<?php echo $indice?>"></div>
              <div class="col col-6 coche2" id="<?php echo $indice?>"></div>
            </div>
          </div>
        <?php
        }
        ?>


      </div>

    </div>
  </div>
</div>