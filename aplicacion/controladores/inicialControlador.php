<?php
	 
	class inicialControlador extends CControlador
	{
		
		// Controlador inicial

		public function accionIndex()
		{
			$this->dibujaVista("index",[],"Autos Guerrero");
		}

	}
