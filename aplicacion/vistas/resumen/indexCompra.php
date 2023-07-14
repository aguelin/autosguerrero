<div class="col col-md-6">
       <div class="card ">

              <div class="card-header">
                     <div class="card-title">
                            <h5><?php echo $fila["fabricante"] . " " . $fila["nombre"]  ?></h5>
                     </div>
              </div>

              <div class="card-body">
                     <div class="card-text">

                            <h4><?php echo "Fecha: " . date_format(new DateTime($fila["fecha"]), "d/m/Y") ?></h4>
                            <h4><?php echo "Precio: " . $fila["importe_total"] . " €" ?></h4>

                     </div>

              </div>

              <div class="card-footer">
                     <a href= <?php echo "/coches/Informe/?cod_coche=".$fila["cod_coche"]?> target="_blank"><button type="button" class="btn btn-danger" >Ficha Ténica</button></a>
              </div>


       </div>
</div>


