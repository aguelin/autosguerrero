<div class="form-crud">

    <?php
    echo CHTML::iniciarForm();

    ?>

    <div id="form_op" class="row g-3">
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "nombre", ["class" => "form-control", "maxlength" => 50, "placeholder" => "Nombre"]);
                echo CHTML::modeloLabel($modelo, "nombre");
                echo CHTML::modeloError($modelo, "nombre");

                ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "nif", ["class" => "form-control", "maxlength" => 9, "placeholder" => "NIF"]);
                echo CHTML::modeloLabel($modelo, "nif");
                echo CHTML::modeloError($modelo, "nif");

                ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "fecha_nac", ["class" => "form-control", "placeholder" => "Fecha de nacimiento"]);
                echo CHTML::modeloLabel($modelo, "fecha_nac");
                echo CHTML::modeloError($modelo, "fecha_nac");

                ?>
            </div>
        </div>
    </div>


    <div id="form_op" class="row g-1">
        <div class="form-group col-md-3">

            <?php

            echo CHTML::modeloLabel($modelo, "foto");
            echo "&nbsp;";
            echo CHTML::modeloFile($modelo, "foto");
            echo CHTML::modeloError($modelo, "foto");
            echo "<br><br>" . PHP_EOL;
            ?>
        </div>
    </div>
    <?php

    echo CHTML::campoBotonSubmit("Añadir empleado",["class"=>"btn btn-primary"]);

    echo CHTML::finalizarForm();

    ?>

</div>