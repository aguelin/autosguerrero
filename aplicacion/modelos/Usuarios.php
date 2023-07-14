<?php

class Usuarios extends CActiveRecord
{
    protected function fijarNombre()
    {
        return "usuario";
    }

    protected function fijarTabla()
    {
        return "usuarios";
    }

    protected function fijarId()
    {
        return "cod_usuario";
    }

    protected function fijarAtributos()
    {
        return ["cod_usuario","nick","nombre","nif","direccion","poblacion","provincia","cp","correo","fecha_nacimiento","borrado","foto","role","contrasenia","confirmar_contrasenia"];
    }

    protected function fijarDescripciones()
    {
        return [
            "nick" => "Nick",
            "nombre" => "Nombre",
            "nif" => "NIF",
            "direccion" => "Dirección",
            "poblacion" => "Población",
            "provincia" => "Provincia",
            "cp" => "CP",
            "correo" => "Correo",
            "fecha_nacimiento" => "Fecha de nacimiento",
            "borrado" => "borrado",
            "foto" => "Foto",
            "role" => "Rol",
            "contrasenia" => "Contraseña",
            "confirmar_contrasenia" => "Confirmar contraseña"
        ];
    }

    protected function fijarRestricciones()
    {
        return [
            [
                "ATRI" => "nick,nif,correo,contrasenia,confirmar_contrasenia", "TIPO" => "REQUERIDO",
                "MENSAJE" => "Campos obligatorios sin rellenar"
            ],
            [
                "ATRI" => "nick", "TIPO" => "CADENA", "TAMANIO" => 50,
                "MENSAJE" => "No debe sobrepasar los 50 caracteres"
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
                "ATRI" => "cp", "TIPO" => "CADENA", "TAMANIO" => 30,
                "MENSAJE" => "No debe sobrepasar los 5 caracteres"
            ],
            [
                "ATRI" => "correo", "TIPO" => "EMAIL", "TAMANIO" => 30,
                "MENSAJE" => "Correo no válido"
            ],
            [
                "ATRI" => "fecha_nacimiento", "TIPO" => "FECHA",
                "MENSAJE" => "Fecha no válida"
            ],
            [
                "ATRI" => "fecha_nacimiento", "TIPO" => "FUNCION", "FUNCION" => "validaFechaNac"
            ],
            [
                "ATRI" => "direccion,poblacion,provincia,contrasenia,confirmar_contrasenia", "TIPO" => "CADENA", "TAMANIO" => 30,
                "MENSAJE" => "No debe sobrepasar los 30 caracteres"
            ],
            [
                "ATRI" => "role", "TIPO" => "ENTERO", "MIN" => 0, "MAX" => 3, "DEFECTO" => 1
            ],
            [
                "ATRI" => "confirmar_contrasenia", "TIPO" => "FUNCION", "FUNCION" => "validaContrasenia"
            ],
            [
                "ATRI" => "nif", "TIPO" => "FUNCION", "FUNCION" => "validaNIF"
            ],
            [
                "ATRI" => "foto", "TIPO" => "CADENA", "TAMANIO" => 40, "DEFECTO"=> "base.png",
                "MENSAJE" => "No debe sobrepasar los 40 caracteres"
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

        $this->nick = "";
        $this->nombre = "";
        $this->nif = "";
        $this->direccion = "";
        $this->poblacion = "ANTEQUERA";
        $this->provincia = "MALAGA";
        $this->cp = "";
        $this->correo = "";
        $this->fecha_nacimiento = $fecha;
        $this->foto = "perfil.jpg";
        $this->role = 1;
        $this->contrasenia = "";
        $this->confirmar_contrasenia = "";
    }

    protected function afterBuscar() {
        $fecha= $this->fecha_nacimiento;
        $fecha= CGeneral::fechaMysqlANormal($fecha);
        $this -> fecha_nacimiento = $fecha;
    }

    /**
     * Toma la fecha de nacimiento de la base de datos y la compara con la fecha actual. Si la
     * diferencia es inferior a 18, devolverá un error.
     */
    public function validaFechaNac()
    {
        $nacimiento = date("Y", strtotime($this->fecha_nacimiento));
        $ahora = date("Y");
        $diferencia = $ahora - $nacimiento;

        

        if ($diferencia < 18) {
            $this->setError(
                "fecha_nacimiento",
                "Debes ser mayor de 18 años"
            );
        }
    }

    /**
     * Si la contraseña y la contraseña de confirmación no son las mismas, configure un mensaje de
     * error
     */
    public function validaContrasenia()
    {

        if ($this->contrasenia != $this->confirmar_contrasenia) {
            $this->setError(
                "confirmar_contrasenia",
                "La contraseña no coincide"
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
     * Si  es nulo, devuelve la matriz de roles. Si  no es nulo, devuelve el nombre
     * del rol para el  dado
     * 
     * @param cod_role El código de rol.
     * 
     * @return La matriz de roles.
     */
    public static function dameRoles($cod_role = null)
    {
        $roles = array(
            0 => "Sin rol",
            1 => "normal",
            2 => "moderador",
            3 => "administrador"
        );

        if ($cod_role === null)
            return $roles;
        else {
            if (isset($roles[$cod_role]))
                return $roles[$cod_role];
            else
                return false;
        }
    }

    /**
     * Esta función genera una declaración de inserción de SQL para un objeto de usuario con varias
     * propiedades.
     * 
     * @return Una cadena que contiene una declaración de inserción de SQL para agregar un nuevo
     * usuario a una tabla de base de datos llamada "usuarios". El extracto incluye valores para el
     * nick del usuario, nombre, NIF (número de identificación fiscal), dirección, ciudad, provincia,
     * código postal, correo electrónico, fecha de nacimiento, una bandera que indica si el usuario ha
     * sido eliminado y una foto.
     */
    protected function fijarSentenciaInsert()
    {
        $nick = CGeneral::addSlashes($this->nick);
        $nombre = CGeneral::addSlashes($this->nombre);
        $nif = CGeneral::addSlashes($this->nif);
        $direccion = CGeneral::addSlashes($this->direccion);
        $poblacion = CGeneral::addSlashes($this->poblacion);
        $provincia = CGeneral::addSlashes($this->provincia);
        $cp = intval($this->cp);
        $correo = CGeneral::addSlashes($this->correo);
        $fecha_nacimiento = CGeneral::fechaNormalAMysql($this->fecha_nacimiento);
        $foto = CGeneral::addSlashes($this->foto);

        return "insert into usuarios (" .
            " nick, nombre , nif, direccion, poblacion, provincia, cp, correo, fecha_nacimiento, borrado, foto" .
            " ) values ( " .
            " '$nick', '$nombre', '$nif', '$direccion', '$poblacion', '$provincia', '$cp', '$correo', '$fecha_nacimiento', false, '$foto'" .
            " ) ";
    }

    /**
     * Esta función genera una declaración de actualización de SQL para la información de un usuario.
     * 
     * @return Una cadena que contiene una declaración de actualización de SQL para la tabla
     * "usuarios", configurando varios campos con los valores de las propiedades correspondientes del
     * objeto que llama a la función. La declaración de actualización se basa en el valor de la
     * propiedad "cod_usuario" del objeto.
     */
    protected function fijarSentenciaUpdate()
    {
        $cod_usuario = intval($this->cod_usuario);
        $nick = CGeneral::addSlashes($this->nick);
        $nombre = CGeneral::addSlashes($this->nombre);
        $nif = CGeneral::addSlashes($this->nif);
        $direccion = CGeneral::addSlashes($this->direccion);
        $poblacion = CGeneral::addSlashes($this->poblacion);
        $provincia = CGeneral::addSlashes($this->provincia);
        $cp = intval($this->cp);
        $correo = CGeneral::addSlashes($this->correo);
        $fecha_nacimiento = CGeneral::fechaNormalAMysql($this->fecha_nacimiento);
        // $foto = CGeneral::addSlashes($this->foto);

        return "update usuarios set " .
            " nick='$nick', " .
            " nombre='$nombre', " .
            " nif='$nif', " .
            " direccion='$direccion', " .
            " poblacion='$poblacion', " .
            " provincia='$provincia', " .
            " cp='$cp', " .
            " correo='$correo', " .
            " fecha_nacimiento='$fecha_nacimiento'" .
            " where cod_usuario = '$cod_usuario' ";
    }
}
