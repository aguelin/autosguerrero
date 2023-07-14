<?php

class CCaja extends CWidget
{
    private static int $_Contador = 1;
    private string $_titulo = "";
    private string $_contenido = "";
    private array $_atributosHTML = [];

    public function __construct($titulo, $contenido = "", $atributosHTML = array())
    {

        //verifico la ruta de la imagen  
        if ($contenido != "")
            $this->_contenido = $contenido;


        //verifico el titulo
        if ($titulo == "")
            $titulo = "sin titulo";
        $this->_titulo = $titulo;
        ++self::$_Contador;

        $this->_atributosHTML = $atributosHTML;
        if (!isset($this->_atributosHTML["class"]))
            $this->_atributosHTML["class"] = "caja";
    }

    public function dibujaApertura()
    {
        //inicio de la captura de la salida estandar
        ob_start();
        echo CHTML::dibujaEtiqueta("div", ["class" => $this->_atributosHTML["class"]], "", false) . PHP_EOL;


        echo CHTML::dibujaEtiqueta(
            "div",
            ["class" => "titulo"],
            $this->_titulo,
            false
        ) . PHP_EOL;

?>
        
<?php

        echo CHTML::dibujaEtiquetaCierre("div");


        echo CHTML::dibujaEtiqueta(
            "div",
            ["class" => "cuerpo"],
            $this->_contenido,
            false
        ) . PHP_EOL;

        $content = ob_get_contents();
        ob_end_clean();

        return $content;

    }

    public function dibujaFin(): string
    {
        return CHTML::dibujaEtiquetaCierre("div");
    }

    public function dibujate(): string
    {
        return $this->dibujaApertura() . $this->dibujaFin();
    }

    public static function requisitos(): string
    {
        $codigo = <<<EOF
			function cCajaBoton(cadena)
			{
				alert(cadena);
			}
EOF;
        return CHTML::script($codigo);
    }
}
