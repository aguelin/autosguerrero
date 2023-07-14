
<div class="form-crud">

<?php
echo CHTML::iniciarForm();

?>

<div id="form_op" class="row g-3">
    <div class="form-group col-md-4">
        <div class="form-floating">
            <?php

            echo CHTML::modeloText($modelo, "fecha", ["class" => "form-control", "placeholder" => "Fecha"]);
            echo CHTML::modeloLabel($modelo, "fecha");
            echo CHTML::modeloError($modelo, "fecha");

            ?>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="form-floating">
            <?php

            echo CHTML::modeloTime($modelo, "hora", ["class" => "form-control"]);
            echo CHTML::modeloLabel($modelo, "hora");
            echo CHTML::modeloError($modelo, "hora");

            ?>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="form-floating">
            <?php

            echo CHTML::modeloListaDropDown($modelo, "cod_empleado", Empleados::dameEmpleados(), ["linea" => false, "class" => "form-control"]);
            echo CHTML::modeloLabel($modelo, "cod_empleado");
            echo CHTML::modeloError($modelo, "cod_empleado");


            ?>
        </div>
    </div>
</div>


<?php

echo CHTML::campoBotonSubmit("Modificar cita",["class"=>"btn btn-primary"]);

echo CHTML::finalizarForm();

?>

</div>