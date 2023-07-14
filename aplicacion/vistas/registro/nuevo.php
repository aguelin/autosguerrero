<?php

$this->titulo = "Registro";
$this->cssHead = CHTML::cssFichero("/estilos/login.css");

?>


<div class="container">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-lg-8 col-xl-12">
            <div class="card bg-dark " style="border-radius: 1rem;">
                <div class="card-body p-4 text-center">
                    <h2 class="fw-bold text-white text-uppercase mb-3">Registro</h2>

                    <?php

                    echo CHTML::iniciarForm();

                    ?>

                    <div id="form_op" class="row g-3 mb-3" >
                        <div class="form-group col-md-4 ">
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

                    <div id="form_op" class="row g-4 mb-3">
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

                    <div id="form_op" class="row g-3 mb-3">
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

                    <div id="form_op" class="row g-4 mb-3">
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
                    </div>

                    <div id="form_op" class="row g-1 text-white">
                        <div class="form-group col-md-4">

                            <?php

                            echo CHTML::modeloLabel($modelo, "foto");
                            echo "&nbsp;";
                            echo CHTML::modeloFile($modelo, "foto");
                            echo CHTML::modeloError($modelo, "foto");
                            echo "<br><br>" . PHP_EOL;
                            ?>
                        </div>
                    </div>
                    
                    <button class="btn btn-outline-light btn-lg px-4" type="submit">Registrar</button>

                    <?php

                    echo CHTML::finalizarForm();

                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>