<div class="form-crud">

    <?php
    echo CHTML::iniciarForm();

    ?>

    <div id="form_op" class="row g-3">
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "nick", ["class" => "form-control", "maxlength" => 50, "placeholder" => "Nick"]);
                echo CHTML::modeloLabel($modelo, "nick");
                echo CHTML::modeloError($modelo, "nick");

                ?>
            </div>
        </div>
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

                echo CHTML::modeloPassword($modelo, "contrasenia", ["class" => "form-control", "maxlength" => 30, "placeholder" => "Contraseña"]);
                echo CHTML::modeloLabel($modelo, "contrasenia");
                echo CHTML::modeloError($modelo, "contrasenia");

                ?>
            </div>
        </div>
    </div>

    <div id="form_op" class="row g-4">
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloPassword($modelo, "confirmar_contrasenia", ["class" => "form-control", "maxlength" => 30, "placeholder" => "Confirmar contraseña"]);
                echo CHTML::modeloLabel($modelo, "confirmar_contrasenia");
                echo CHTML::modeloError($modelo, "confirmar_contrasenia");

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

                echo CHTML::modeloText($modelo, "direccion", ["class" => "form-control", "maxlength" => 30, "placeholder" => "Dirección"]);
                echo CHTML::modeloLabel($modelo, "direccion");
                echo CHTML::modeloError($modelo, "direccion");

                ?>
            </div>
        </div>
    </div>

    <div id="form_op" class="row g-3">
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "poblacion", ["class" => "form-control", "maxlength" => 30, "placeholder" => "Población"]);
                echo CHTML::modeloLabel($modelo, "poblacion");
                echo CHTML::modeloError($modelo, "poblacion");

                ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "provincia", ["class" => "form-control", "maxlength" => 30, "placeholder" => "Provincia"]);
                echo CHTML::modeloLabel($modelo, "provincia");
                echo CHTML::modeloError($modelo, "provincia");

                ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-floating">

                <?php

                echo CHTML::modeloNumber($modelo, "cp", ["class" => "form-control", "placeholder" => "CP"]);
                echo CHTML::modeloLabel($modelo, "cp");
                echo CHTML::modeloError($modelo, "cp");

                ?>
            </div>
        </div>
    </div>

    <div id="form_op" class="row g-4">
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "correo", ["class" => "form-control", "maxlength" => 50, "placeholder" => "Correo"]);
                echo CHTML::modeloLabel($modelo, "correo");
                echo CHTML::modeloError($modelo, "correo");

                ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "fecha_nacimiento", ["class" => "form-control", "placeholder" => "Fecha de nacimiento"]);
                echo CHTML::modeloLabel($modelo, "fecha_nacimiento");
                echo CHTML::modeloError($modelo, "fecha_nacimiento");

                ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloListaDropDown($modelo, "role", Usuarios::dameRoles(), ["linea" => false, "class" => "form-control"]);
                echo CHTML::modeloLabel($modelo, "role");
                echo CHTML::modeloError($modelo, "role");


                ?>
            </div>
        </div>
    </div>

    <?php

    echo CHTML::campoBotonSubmit("Modificar usuario", ["class" => "btn btn-primary"]);

    echo CHTML::finalizarForm();

    ?>

</div>