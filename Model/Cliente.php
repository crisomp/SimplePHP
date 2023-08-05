<?php 
/**
 * 
 */
class Cliente
{
	
	Public int $IdCliente;
	Public $Nombre;
	Public $Apellido;
	Public $Direccion;
	Public $NumDui;
	Public $NumNit;
	Public $Telefono;
	Public $ClienteDe;
	Public $Estado;
	Public $Ruta;
	public $Saldo;
	Public $RegFiscal;
	Public $Giro;
	public $Nivel;

	public function _get($p)
	{
		return $this->$p;
	}

	public function _set($p,$v)
	{
		return $this->$p = $v;
	}

	public function Validar()
	{
		//pueden agregar la validaciones necesarias al Modelo
		
		$Error = array();

		if (empty($this->Nombre)) 
		{
			$Error['Nombre'] = 'Obligatorio';
		}
		if (empty($this->Apellido)) 
		{
			$Error['Apellido'] = 'Obligatorio';
		}
		if (empty($this->Direccion)) 
		{
			$Error['Direccion'] = 'Obligatorio';
		}
		if (empty($this->Ruta)) 
		{
			$Error['Ruta'] = 'Obligatorio';
		}

		if (empty($Error)) 
		{
			return 1;
		}else
		{
			return $Error;
		}
	}
}

 ?>