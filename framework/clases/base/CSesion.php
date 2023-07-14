<?php

class CSesion {

    public function __construct()
    {
        
    }

    public function crearSesion():void{

        if(!$this->haySesion())
            session_start();

    }

    public function haySesion():bool{

        return isset($_SESSION);

    }

    public function destruirSesion(){
        session_destroy();
    }

}