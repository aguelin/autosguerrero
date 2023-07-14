<?php

$this->titulo = "Ofertas";
$this->cssHead = CHTML::cssFichero("/estilos/coches.css");
$this->scriptHead = CHTML::scriptFichero("/javascript/ofertas.js", ["defer" => "defer", "type" => "module"]);

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

                              <div class="form-floating mb-3">
                                    <?php
                                    echo CHTML::campoListaDropDown("marca", "", Nuevos::dameMarcasOferta(), ["linea" => false, "class" => "form-control", "name" => "marca", "id" => "marca"]);
                                    ?>

                                    <label for="">Marca</label>
                              </div>

                              <div class="form-floating">
                                    <select name="modelo" id="modelo" class="form-control" disabled></select>
                                    <label for="modelo">Modelo</label>
                              </div>


                              <div class="range">
                                    <label for="">Precio</label>
                                    <div class="field">
                                          <input type="range" min="0" max="100000" value="100000" class="inputRange" id="precio" name="precio">
                                          <div class="value right">0€ - <span>+100000</span>€</div>
                                    </div>
                              </div>

                              <div class="range">
                                    <label for="">Km</label>
                                    <div class="field">
                                          <input type="range" min="0" max="100000" value="100000" class="inputRange" id="km" name="km">
                                          <div class="value right">0km - <span>+100000</span>km</div>
                                    </div>
                              </div>

                              <div class="fecha">

                                    <div class="form-group">

                                          <label for="">Año (Desde)</label>
                                          <select class="form-control" name="fechaInicio" id="fechaInicio">

                                          </select>

                                    </div>

                                    <div class="form-group">

                                          <label for="">Año (Hasta)</label>
                                          <select class="form-control" name="fechaFin" id="fechaFin"></select>

                                    </div>

                              </div>

                              <div class="form-floating">

                                    <?php
                                    echo CHTML::campoListaDropDown("categoria", 0, Categorias::dameCategorias(), ["linea" => false, "class" => "form-control", "name" => "categoria", "id" => "categoria"]);
                                    ?>

                                    <label for="">Categoría</label>

                              </div>

                              <div class="form-floating">

                                    <?php
                                    echo CHTML::campoListaDropDown("combustible", 0, Combustibles::dameCombustibles(), ["linea" => false, "class" => "form-control", "name" => "combustible", "id" => "combustible"]);
                                    ?>

                                    <label for="">Combustible</label>

                              </div>

                              <div class="form-floating">

                                    <select name="caja_cambios" id="caja_cambios" class="form-control">
                                          <option value="">No especificada</option>
                                          <option value="Manual">Manual</option>
                                          <option value="Automático">Automático</option>
                                          <option value="Ambos">Ambos</option>
                                    </select>

                                    <label for="">Cambios</label>

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

                              <div class="range">
                                    <label for="">Potencia</label>
                                    <div class="field">
                                          <input type="range" min="50" max="300" value="300" class="inputRange" id="potencia" name="potencia">
                                          <div class="value right">50C.V. - <span>+300</span>C.V.</div>
                                    </div>
                              </div>

                              <input type="submit" class="btn btn-primary" , id="bFiltrar" , name="bFiltrar" value="Filtrar">

                        </form>

                  </div>

            </div>

      </div>


</aside>

<div id="container" class="py-5">

      <h1 class="text-center">Ofertas</h1>
      <div id="fila" class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 py-5">



      </div>

</div>