<?php 
/**
 * 
 */
class Errores
{
	
	Public int $NoError;
	Public $Descripcion;
	

	public function _get($p)
	{
		return $this->$p;
	}

	public function _set($p,$v)
	{
		return $this->$p = $v;
	}

}

 ?>