<div class="form-crud">
    <?php
    echo CHTML::iniciarForm();

    ?>

    <div id="form_op" class="row g-3">
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "nombre", ["class" => "form-control", "maxlength" => 40, "placeholder" => "Nombre"]);
                echo CHTML::modeloLabel($modelo, "nombre");
                echo CHTML::modeloError($modelo, "nombre");

                ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloText($modelo, "fabricante", ["class" => "form-control", "maxlength" => 40, "placeholder" => "Fabricante"]);
                echo CHTML::modeloLabel($modelo, "fabricante");
                echo CHTML::modeloError($modelo, "fabricante");

                ?>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="form-floating">
                <?php

                echo CHTML::modeloListaDropDown($modelo, "cod_categoria", Categorias::dameCategorias(), ["linea" => false, "class" => "form-control"]);
                echo CHTML::modeloLabel($modelo, "cod_categoria");
                echo CHTML::modeloError($modelo, "cod_categoria");


                ?>
            </div>
        </div>
    </div>

    <div id="form_op" class="row g-4">
        <div class="form-group col-md-3">
            <div class="form-floating">

                <?php

                echo CHTML::modeloListaDropDown($modelo, "num_plazas", [2 => 2, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9], ["linea" => false, "class" => "form-control"]);
                echo CHTML::modeloLabel($modelo, "num_plazas");
                echo CHTML::modeloError($modelo, "num_plazas");

                ?>
            </div>
        </div>

        <div class="form-group col-md-3">
            <div class="form-floating">

                <?php

                echo CHTML::modeloText($modelo, "fecha_inicio", ["class" => "form-control"]);
                echo CHTML::modeloLabel($modelo, "fecha_inicio");
                echo CHTML::modeloError($modelo, "fecha_inicio");

                ?>
            </div>
        </div>

        <div class="form-group col-md-3">
            <div class="form-floating">

                <?php

                echo CHTML::modeloText($modelo, "fecha_fin", ["class" => "form-control"]);
                echo CHTML::modeloLabel($modelo, "fecha_fin");
                echo CHTML::modeloError($modelo, "fecha_fin");

                ?>
            </div>
        </div>

        <div class="form-group col-md-3">
            <div class="form-floating">

                <?php

                echo CHTML::modeloNumber($modelo, "precio", ["class" => "form-control", "step" => "0.01", "max" => 100000]);
                echo CHTML::modeloLabel($modelo, "precio");
                echo CHTML::modeloError($modelo, "precio");


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

    echo CHTML::campoBotonSubmit("Añadir alquiler", ["class" => "btn btn-primary"]);

    echo CHTML::finalizarForm();


    ?>

</div>