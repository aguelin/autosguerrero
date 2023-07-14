<div class="form-crud">

<?php
echo CHTML::iniciarForm();

?>

<div id="form_op" class="row g-3">
    <div class="form-group col-md-4">
        <div class="form-floating">
            <?php

            echo CHTML::modeloText($modelo, "nombre", ["class" => "form-control", "maxlength" => 40, "placeholder" => "Nombre", "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "nombre");
            echo CHTML::modeloError($modelo, "nombre");

            ?>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="form-floating">
            <?php

            echo CHTML::modeloText($modelo, "fabricante", ["class" => "form-control", "maxlength" => 40, "placeholder" => "Fabricante", "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "fabricante");
            echo CHTML::modeloError($modelo, "fabricante");

            ?>
        </div>
    </div>
    <div class="form-group col-md-4">
        <div class="form-floating">
            <?php

            echo CHTML::modeloListaDropDown($modelo, "cod_categoria", Categorias::dameCategorias(), ["linea" => false, "class" => "form-control", "disabled" => "true"]);
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

            echo CHTML::modeloListaDropDown($modelo, "cod_combustible", Combustibles::dameCombustibles(), ["linea" => false, "class" => "form-control", "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "cod_combustible");
            echo CHTML::modeloError($modelo, "cod_combustible");


            ?>
        </div>
    </div>
    <div class="form-group col-md-3">
        <div class="form-floating">
            <?php

            echo CHTML::modeloListaDropDown($modelo, "cod_color", Colores::dameColores(), ["linea" => false, "class" => "form-control", "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "cod_color");
            echo CHTML::modeloError($modelo, "cod_color");

            ?>
        </div>
    </div>
    <div class="form-group col-md-3">
        <div class="form-floating">
            <?php

            echo CHTML::modeloListaDropDown($modelo, "num_puertas", [2 => 2, 3 => 3, 4 => 4, 5 => 5], ["linea" => false, "class" => "form-control", "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "num_puertas");
            echo CHTML::modeloError($modelo, "num_puertas");
            ?>
        </div>
    </div>
    <div class="form-group col-md-3">
        <div class="form-floating">

            <?php

            echo CHTML::modeloListaDropDown($modelo, "num_plazas", [2 => 2, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9], ["linea" => false, "class" => "form-control", "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "num_plazas");
            echo CHTML::modeloError($modelo, "num_plazas");

            ?>
        </div>
    </div>
</div>

<div id="form_op" class="row g-3">
    <div class="form-group col-md-3">
        <div class="form-floating">

            <?php

            echo CHTML::modeloListaDropDown($modelo, "caja_cambios", ["Manual" => "Manual", "Automático" => "Automático", "Ambos" => "Ambos"], ["linea" => false, "class" => "form-control", "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "caja_cambios");
            echo CHTML::modeloError($modelo, "caja_cambios");

            ?>
        </div>
    </div>
    <div class="form-group col-md-3">
        <div class="form-floating">

            <?php

            echo CHTML::modeloNumber($modelo, "potencia", ["class" => "form-control", "step" => "0.01", "max" => 2000, "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "potencia");
            echo CHTML::modeloError($modelo, "potencia");

            ?>
        </div>
    </div>
    <div class="form-group col-md-3">
        <div class="form-floating">

            <?php

            echo CHTML::modeloNumber($modelo, "km", ["class" => "form-control", "step" => "0.01", "max" => 100000, "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "km");
            echo CHTML::modeloError($modelo, "km");

            ?>
        </div>
    </div>
    <div class="form-group col-md-3">
        <div class="form-floating">

            <?php

            echo CHTML::modeloText($modelo, "fecha_fab", ["class" => "form-control", "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "fecha_fab");
            echo CHTML::modeloError($modelo, "fecha_fab");

            ?>
        </div>
    </div>
</div>

<div id="form_op" class="row g-4">
    <div class="form-group col-md-3">
        <div class="form-floating">

            <?php

            echo CHTML::modeloNumber($modelo, "unidades", ["class" => "form-control","disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "unidades");
            echo CHTML::modeloError($modelo, "unidades");


            ?>
        </div>
    </div>
    <div class="form-group col-md-3">
        <div class="form-floating">

            <?php

            echo CHTML::modeloNumber($modelo, "precio_base", ["class" => "form-control", "step" => "0.01", "max" => 100000, "disabled" => "true"]);
            echo CHTML::modeloLabel($modelo, "precio_base");
            echo CHTML::modeloError($modelo, "precio_base");


            ?>
        </div>
    </div>
    <div class="form-group col-md-3">

        <?php

        echo CHTML::modeloLabel($modelo, "iva");
        echo "&nbsp;&nbsp;" . CHTML::modeloListaRadioButton($modelo, "iva", [4 => "4%", 10 => "10%", 21 => "21%"], "&nbsp;", ["disabled" => "true"]);
        echo CHTML::modeloError($modelo, "iva");

        ?>
    </div>
    <div class="form-group col-md-3">

        <?php

        echo CHTML::modeloLabel($modelo, "oferta");
        echo "&nbsp;&nbsp;" . CHTML::modeloListaRadioButton($modelo, "oferta", [0 => "0%", 10 => "10%", 15 => "15%", 20 => "20%"], "&nbsp;", ["disabled" => "true"]);
        echo CHTML::modeloError($modelo, "oferta");

        ?>
    </div>
</div>

<div id="form_op">

    <?php

    if ($foto[0]["foto"] == "") {

    ?>

        <img src="/imagenes/nuevos/base.jpg" alt="foto" width="28%">

    <?php

    } else {

    ?>

        <img src="<?php echo "/imagenes/nuevos/" . $foto[0]["foto"] ?>" alt="foto" width="28%">

    <?php
    }


    ?>




</div>
<?php

echo CHTML::finalizarForm();

?>

</div>
