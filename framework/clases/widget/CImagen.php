<?php

class CImagen extends CWidget
{
   private static int $_Contador=1; 
   private string $_imagen="";
   private string $_titulo="";
   private array $_atributosHTML=[]; 
   public function __construct(string $rutaImagen, string $titulo, array $atributosHTML=[])
   {
      //verifico la ruta de la imagen  
      if ($rutaImagen!="")
          $this->_imagen=$rutaImagen;

        
      //verifico el titulo
      if ($titulo=="")
         $titulo="sin titulo";
      $this->_titulo="IMG ".self::$_Contador.":".$titulo;
      ++self::$_Contador;
      
      $this->_atributosHTML=$atributosHTML;
      if (!isset($this->_atributosHTML["class"]))
          $this->_atributosHTML["class"]="cimg";
                      
      
   }
   
   public function dibujaApertura():string
   {
      //inicio de la captura de la salida estandar
      ob_start(); 
      echo CHTML::dibujaEtiqueta("div",["class"=>$this->_atributosHTML["class"]],"",false).PHP_EOL;
?>
<button onclick="cImagenBoton('hola');">Imagen</button><br>
<?php
      $atri=$this->_atributosHTML;
      unset($atri["class"]);
      echo CHTML::imagen($this->_imagen,"img",$atri).PHP_EOL;
      echo "<br>";
      echo CHTML::dibujaEtiqueta("div",["class"=>"cimg_tit"],
                        $this->_titulo).PHP_EOL;
      $contenido=ob_get_contents();
      ob_end_clean();

      return $contenido;
   }

   public function dibujaFin():string
   {
     return CHTML::dibujaEtiquetaCierre("div");
   }

   public function dibujate():string
   {
        return $this->dibujaApertura().$this->dibujaFin();
   }
   public static function requisitos():string
   {
    $codigo=<<<EOF
			function cImagenBoton(cadena)
			{
				alert(cadena);
			}
EOF;
	return CHTML::script($codigo);
   }
}