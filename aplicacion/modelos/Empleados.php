<?php

class Empleados extends CActiveRecord
{
    protected function fijarNombre()
    {
        return "empleado";
    }

    protected function fijarTabla()
    {
        return "empleados";
    }

    protected function fijarId()
    {
        return "cod_empleado";
    }

    protected function fijarAtributos()
    {
        return ["cod_empleado","nombre","nif","fecha_nac","foto","borrado"];
    }

    protected function fijarDescripciones()
    {
        return [
            "nombre" => "Nombre",
            "nif" => "NIF",
            "fecha_nac" => "Fecha de nacimiento",
            "foto" => "Foto",
            "borrado" => "Borrado",
        ];
    }

    protected function fijarRestricciones()
    {
        return [
            [
                "ATRI" => "nombre,nif", "TIPO" => "REQUERIDO",
                "MENSAJE" => "Campos obligatorios sin rellenar"
            ],
            [
                "ATRI" => "nombre", "TIPO" => "CADENA", "TAMANIO" => 50,
                "MENSAJE" => "No debe sobrepasar los 50 caracteres"
            ],
            [
                "ATRI" => "nif", "TIPO" => "CADENA", "TAMANIO" => 9,
                "MENSAJE" => "NIF no válido"
            ],
            [
                "ATRI" => "nif", "TIPO" => "FUNCION", "FUNCION" => "validaNIF"
            ],
            [
                "ATRI" => "fecha_nac", "TIPO" => "FECHA",
                "MENSAJE" => "Fecha no válida"
            ],
            [
                "ATRI" => "fecha_nac", "TIPO" => "FUNCION", "FUNCION" => "validaFechaNac"
            ],
            [
                "ATRI" => "foto", "TIPO" => "CADENA", "TAMANIO" => 30, "DEFECTO"=> "perfil.jpg",
                "MENSAJE" => "No debe sobrepasar los 30 caracteres"
            ],
            [
                "ATRI" => "borrado", "TIPO" => "ENTERO" 
            ],
            [
                "ATRI" => "borrado", "TIPO" => "RANGO" , "RANGO" => [0,1]
            ]
        ];
    }

    protected function afterCreate()
    {
        $fecha_actual = new DateTime("now");
        $fecha = $fecha_actual->format("d/m/Y");

        $this->nombre = "";
        $this->nif = "";
        $this->fecha_nac = $fecha;
        $this->foto = "perfil.jpg";

    }

    protected function afterBuscar() {
        $fecha= $this->fecha_nac;
        $fecha= CGeneral::fechaMysqlANormal($fecha);
        $this -> fecha_nac = $fecha;
    }

    /**
     * Toma la fecha de nacimiento de la base de datos y la compara con la fecha actual. Si la
     * diferencia es inferior a 18, devolverá un error.
     */
    public function validaFechaNac()
    {
        $nacimiento = date("Y", strtotime($this->fecha_nac));
        $ahora = date("Y");
        $diferencia = $ahora - $nacimiento;

        

        if ($diferencia < 18) {
            $this->setError(
                "fecha_nac",
                "Debe ser mayor de 18 años"
            );
        }
    }


    /**
     * Comprueba si el NIF es válido
     */
    public function validaNIF()
    {
        $expresion = "/^(?|([a-z]\d{7})|(\d{1,8}))([a-z])$/i";

        if(!preg_match($expresion,$this->nif)){

            $this->setError(
                "nif",
                "El NIF no es válido"
            );

        }

    }

    
    /**
     * Esta función devuelve una matriz de códigos y nombres de todos los empleados, o el nombre de un
     * empleado específico si se proporciona su código.
     * 
     * @param codigo El parámetro "codigo" es un parámetro opcional que se puede pasar a la función. Si
     * se pasa un valor, la función devolverá el nombre del empleado con el valor "cod_empleado"
     * correspondiente. Si no se pasa ningún valor, la función devolverá una matriz con todos los
     * "cod_em
     * 
     * @return Si `` es `null`, se devuelve una matriz de todos los códigos y nombres de los
     * empleados. Si `` no es `null`, la función verifica si el `` dado existe en la
     * matriz de códigos y nombres de todos los empleados. Si existe, la función devuelve el nombre del
     * empleado con ese código. Si no existe, la función devuelve `falso`.
     */
    public static function dameEmpleados($codigo = null)
    {

        $empleados = new Empleados();
        $todos = $empleados->buscarTodos();
        $codigos = [0 => "Cualquiera"];

        foreach($todos as $indice => $valor){
            $codigos[$valor["cod_empleado"]] = $valor["nombre"];
        }

        if ($codigo === null)
            return $codigos;
        else {
            if (isset($codigos[$codigo]))
                return $codigos[$codigo];
            else
                return false;
        }
    }

    /**
     * Esta función genera una declaración de inserción SQL para agregar datos de empleados a una base
     * de datos.
     * 
     * @return una cadena que representa una instrucción SQL INSERT para insertar datos en una tabla
     * llamada "empleados". La declaración incluye los valores de las propiedades "nombre", "nif",
     * "fecha_nac", "foto" y "borrado" de la instancia del objeto actual. Los valores están
     * correctamente formateados y escapados para evitar ataques de inyección SQL.
     */
    protected function fijarSentenciaInsert()
    {
    
        $nombre = CGeneral::addSlashes($this->nombre);
        $nif = CGeneral::addSlashes($this->nif);
        $fecha_nac = CGeneral::fechaNormalAMysql($this->fecha_nac);
        $foto = CGeneral::addSlashes($this->foto);

        return "insert into empleados (" .
            " nombre , nif, fecha_nac, foto, borrado" .
            " ) values ( " .
            " '$nombre', '$nif', '$fecha_nac', '$foto', false" .
            " ) ";
    }
    
    /**
     * Esta función genera una declaración de actualización de SQL para la tabla "empleados" con los
     * datos de empleados dados.
     * 
     * @return una cadena que representa una declaración de actualización de SQL para la tabla
     * "empleados", configurando los campos "nombre", "nif" y "fecha_nac" a los valores
     * correspondientes de la instancia del objeto actual, para la fila con el valor "cod_empleado"
     * igual a la propiedad "cod_empleado" del objeto actual.
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_empleado = intval($this->cod_empleado);
        $nombre = CGeneral::addSlashes($this->nombre);
        $nif = CGeneral::addSlashes($this->nif);
        $fecha_nac = CGeneral::fechaNormalAMysql($this->fecha_nac);

        return "update empleados set " .
            " nombre='$nombre', " .
            " nif='$nif', " .
            " fecha_nac='$fecha_nac'" .
            " where cod_empleado = '$cod_empleado' ";
    }
}
