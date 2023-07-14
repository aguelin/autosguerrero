<?php

$diasSemana = [1=>"Lunes", 2=>"Martes", 3=>"Miércoles", 4=>"Jueves", 5=>"Viernes"];

?>

<div class="col">
       <div class="card ">

              <div class="card-header">
                     <div class="card-title">
                            <h3><?php echo $diasSemana[date("N", strtotime($fila["fecha"]))] ?></h3>
                     </div>
              </div>

              <div class="card-body d-flex">

                     

                     <div class="d-flex justify-content-around p-3">

                            <h3><?php echo date_format(new DateTime($fila["fecha"]),"d/m/Y") ?></h3>
                            <h3><?php echo $fila["hora"]?></h3>

                     </div>

                     <div class="card-text">

                            <p>Será atendido por nuestr@ profesional <?php echo $fila["empleado"] ?></p>

                     </div>

              </div>


              <div class="card-footer">
                     <?php
                     echo CHTML::iniciarForm();

                     echo CHTML::dibujaEtiqueta("input",["type"=>"hidden","name"=>"cod_cita","value"=>$fila["cod_cita"]]);

                     if (Sistema::app()->Acceso()->puedePermiso(1)) {
                            echo CHTML::campoBotonSubmit("Reservar", ["name" => "reservar","id"=>"reservar","class" => "btn-primary"]);
                     }


                     echo CHTML::finalizarForm();


                     ?>
              </div>


       </div>
</div>




