<?php


$cajaFiltrado = new CCaja(
    "Criterios de filtrado",
    "",
    array("style" => "width:80%;")
);

$this->textoHead = CCaja::requisitos();

//dibuja el html correspondiente a apertura de caja
echo $cajaFiltrado->dibujaApertura();
//contenido de la caja
echo CHTML::iniciarForm() . PHP_EOL;

?>
<div class="row">
    <div class="form-group col-md-4">
        <div class="form-floating mb-4">
            <?php
            echo CHTML::modeloDate($modelo, $fil["fecha"], ["linea" => false, "name" => "fecha","class"=>"form-control"]);
            echo CHTML::campoLabel("Fecha" , "fecha");
            ?>
        </div>
    </div>
</div>

<?php


echo CHTML::campoBotonSubmit("Filtrar", ["name" => "filtrar","class" => "btn btn-primary"]);
echo CHTML::finalizarForm();

echo CHTML::dibujaEtiquetaCierre("div");

//cierro la caja
echo $cajaFiltrado->dibujaFin();

echo "<br><br>".PHP_EOL;



$this->textoHead = CPager::requisitos();

?>

<div class="crudProducto">

    <div class="nuevoProducto">
        <a href="/comprasAlquiler/DescargarMensajes"><button type="button" class="btn btn-primary">Descargar datos</button></a>
    </div>
    

<?php

$pagi = new CPager($opcPag, array());

$tabla = new CGrid(
    $cabe,
    $filas,
    array("class" => "tabla1")
);
//dibujo el paginador
echo $pagi->dibujate();
//se dibuja la tabla
echo $tabla->dibujate();

?>

</div>
