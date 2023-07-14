<?php

class Login extends CActiveRecord
{
    protected function fijarNombre()
    {
        return "login";
    }

    protected function fijarAtributos()
    {
        return ["nick","contrasenia"];
    }

    protected function fijarDescripciones()
    {
        return [
            "nick" => "Usuario",
            "contrasenia" => "Contraseña",
        ];
    }

    protected function fijarRestricciones()
    {
        return [
            [
                "ATRI" => "nick,contrasenia", "TIPO" => "REQUERIDO",
                "MENSAJE" => "Campos obligatorios sin rellenar"
            ],
            [
                "ATRI" => "nick", "TIPO" => "CADENA", "TAMANIO" => 40,
                "MENSAJE" => "No puede superar los 40 caracteres"
            ],
            [
                "ATRI" => "contrasenia", "TIPO" => "CADENA", "TAMANIO" => 30,
                "MENSAJE" => "No puede superar los 30 caracteres"
            ],
            [
                "ATRI" => "contrasenia", "TIPO" => "FUNCION", "FUNCION" => "autenticar"
            ]
        ];
    }

    protected function afterCreate()
    {
        $this->nick = "";
        $this->contrasenia = "";
    }

/**
 * Esta es una función que autentica las credenciales de inicio de sesión de un usuario y
 * registra su información si es válida; de lo contrario, genera un mensaje de error.
 */

    public function autenticar(){

        if(Sistema::app()->ACL()->esValido($this->nick,$this->contrasenia)){

            Sistema::app()->Acceso()->registrarUsuario($this->nick,
            Sistema::app()->ACL()->getNombre(Sistema::app()->ACL()->getCodUsuario($this->nick)),
            Sistema::app()->ACL()->getPermisos(Sistema::app()->ACL()->getCodUsuario($this->nick)));

        }
        else{
            $this->setError("contrasenia","Valores de inicio de sesión inválidos");
        }

    }


}
