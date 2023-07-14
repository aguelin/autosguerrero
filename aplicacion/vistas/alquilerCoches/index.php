
<?php

$this->titulo = "Coches de Alquiler";
$this->cssHead = CHTML::cssFichero("/estilos/coches.css");
$this->scriptHead = CHTML::scriptFichero("/javascript/alquiler.js", ["defer", "type" => "module"]);

?>

<input type="checkbox" id="checkFilter">
      <label for="checkFilter" class="checkbtnFilter">
        <i class="fas fa-bars"></i>
      </label>

<aside>

      <div class="d-flex" id="content-wrapper">
        <div id="sidebar-container">
          <div class="logo">
            <h4 class="font-weight-bold mb-0">Filtros</h4>
          </div>

          <div class="filtrado">

            <form action="" method="POST">

              <div class="range">
                <label for="">Precio</label>
                <div class="field">
                  <input type="range" min="0" max="10000" value="10000" class="inputRange" id="precio" name="precio">
                  <div class="value right">0€ - <span>+10000</span>€</div>
                </div>
              </div>

              <div class="form-floating">

                <?php
                echo CHTML::campoListaDropDown("categoria", 0, Categorias::dameCategorias(), ["linea" => false, "class" => "form-control", "name" => "categoria", "id" => "categoria"]);
                ?>

                <label for="">Categoría</label>

              </div>

              <div class="form-floating">

                <input type="date" class="form-control" name="fechaInicio" id="fechaInicio" placeholder="Fecha de inicio">
                <label for="">Fecha de inicio</label>

              </div>

              <div class="form-floating">

                <input type="date" class="form-control" name="fechaFin" id="fechaFin" placeholder="Fecha de fin">
                <label for="">Fecha de fin</label>

              </div>

              <div class="form-floating">

                <select name="plazas" id="plazas" class="form-control">
                  <option value="0">No especificado</option>
                  <option value="2">2</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                </select>

                <label for="">Número de plazas</label>

              </div>

              <input type="submit" class="btn btn-primary" , id="bFiltrar" , name="bFiltrar" value="Filtrar">

            </form>

          </div>

        </div>

      </div>


    </aside>

    <div id="container" class="py-5">

      <h1 class="text-center">Coches de alquiler</h1>
      <div id="fila" class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 py-5">



      </div>

    </div>