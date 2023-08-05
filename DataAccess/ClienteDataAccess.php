<?php 


class ClienteDataAccess
{
	 public function guardar(Cliente $pCliente)
	 {

	      try {
      		$conexion = new Conexion();
        	$consulta = $conexion->prepare('INSERT INTO clientes (NOMBRE,APELLIDO,DIRECCION,NUMDUI,NUMNIT,TELEFONO,ESTADO,RUTA,SALDO,REGFISCAL,GIRO)VALUES(?,?,?,?,?,?,?,?,?,?,?)');

			$consulta->bindValue(1, $pCliente->Nombre);
			$consulta->bindValue(2, $pCliente->Apellido);
			$consulta->bindValue(3, $pCliente->Direccion);
			$consulta->bindValue(4, $pCliente->NumDui);
			$consulta->bindValue(5, $pCliente->NumNit);
			$consulta->bindValue(6, $pCliente->Telefono);
			$consulta->bindValue(7, $pCliente->Estado);
			$consulta->bindValue(8, $pCliente->Ruta);
			$consulta->bindValue(9, 0);
			$consulta->bindValue(10, $pCliente->RegFiscal);
			$consulta->bindValue(11, $pCliente->Giro);
			
			$consulta->execute();
			//print_r($consulta->errorInfo());
			$UltimoId = $conexion->lastInsertId(); 
			$conexion = null;
			return $UltimoId;
      	

      	} catch (PDOException $e) 
      	{
			$conexion = null;
      		echo $e->getMessage();	
      	}	
		
	}

	public function Modificar(Cliente $pCliente)
	{
		$conexion = new Conexion();
        	$consulta = $conexion->prepare('
        		UPDATE clientes SET NOMBRE = ?, APELLIDO = ?, DIRECCION = ?, NUMDUI = ?, NUMNIT = ?, RUTA = ?, REGFISCAL = ?, GIRO = ? WHERE IDCLIENTE = ?
        		');
        	$consulta->bindValue(1, $pCliente->Nombre);
			$consulta->bindValue(2, $pCliente->Apellido);
			$consulta->bindValue(3, $pCliente->Direccion);
			$consulta->bindValue(4, $pCliente->NumDui);
			$consulta->bindValue(5, $pCliente->NumNit);
			$consulta->bindValue(6, $pCliente->Ruta);
			$consulta->bindValue(7, $pCliente->RegFiscal);
			$consulta->bindValue(8, $pCliente->Giro);
			$consulta->bindValue(9, $pCliente->IdCliente);

			$consulta->execute();
			//print_r($consulta->errorInfo());
			$UltimoId = $pCliente->IdCliente; 
			$conexion = null;
			return $UltimoId;
	}

	public function Eliminar($pId)
	{
		$conexion = new Conexion();
		$consulta = $conexion->prepare('DELETE FROM clientes WHERE IDCLIENTE = :idcliente');
		$consulta->bindParam(':idcliente',$pId);
		$consulta->execute();
		$conexion = null;
	}

	public function Buscar(Cliente $pCliente)
	{
		try {
			$campos = array();
			$SQL = "SELECT IDCLIENTE,NOMBRE,APELLIDO,DIRECCION,NUMDUI,NUMNIT,TELEFONO,CLIENTEDE,ESTADO,RUTA,SALDO,REGFISCAL,GIRO,NIVEL FROM clientes";
			$WhereSQL = "";
			$ContadorCampos = 0;
			if (!empty($pCliente->_get('Nombre'))) {
				if ($ContadorCampos > 0) {
					$WhereSQL = $WhereSQL . " AND ";
					
				}
				$ContadorCampos = $ContadorCampos + 1;
				$WhereSQL = $WhereSQL." NOMBRE Like ? ";
				$campos[$ContadorCampos] = "%".$pCliente->_get('Nombre')."%";
			}
			if (!empty($pCliente->_get('Ruta'))) {
				if ($ContadorCampos > 0) {
					$WhereSQL = $WhereSQL . " AND ";
					
				}
				$ContadorCampos = $ContadorCampos + 1;
				$WhereSQL = $WhereSQL." RUTA Like ? ";
				$campos[$ContadorCampos] = "%".$pCliente->_get('Ruta')."%";
			}

			if (!empty($WhereSQL)) {
				$WhereSQL = " WHERE " . $WhereSQL. " ORDER BY NOMBRE ASC";
				$SQL = $SQL . $WhereSQL;
				

				$conexion = new Conexion();
				$consulta = $conexion->prepare($SQL);
				
				foreach ($campos as $key => $value) {
					$consulta->bindValue($key,$value);
					
				}
				
				$consulta->execute();
				
				
			}else{
				$SQL = $SQL. " ORDER BY Nombre ASC";
				$conexion = new Conexion();
				$consulta = $conexion->prepare($SQL);
				$consulta->execute();
			}

			

			$array = array();
			while ($Ob = $consulta->fetch(PDO::FETCH_OBJ)) {
				$Cliente = new Cliente();

				$Cliente->_set('IdCliente',$Ob->IDCLIENTE);
				$Cliente->_set('Nombre',$Ob->NOMBRE);
				$Cliente->_set('Apellido',$Ob->APELLIDO);
				$Cliente->_set('Direccion',$Ob->DIRECCION);
				$Cliente->_set('NumDui',$Ob->NUMDUI);
				$Cliente->_set('NumNit',$Ob->NUMNIT);
				$Cliente->_set('Telefono',$Ob->TELEFONO);
				$Cliente->_set('Clientede',$Ob->CLIENTEDE);
				$Cliente->_set('Estado',$Ob->ESTADO);
				$Cliente->_set('Ruta',$Ob->RUTA);
				$Cliente->_set('Saldo',$Ob->SALDO);
				$Cliente->_set('RegFiscal',$Ob->REGFISCAL);
				$Cliente->_set('Giro',$Ob->GIRO);
				$Cliente->_set('Nivel',$Ob->NIVEL);
				$array[] = $Cliente;
			}

			$conexion = null;
			return $array;

		} catch (Exception $e) {
			$conexion = null;
			return $e;
		}
	}

	public function BuscarPorId(int $pId)
	{
		try {
			
				$conexion = new Conexion();
				$consulta = $conexion->prepare('SELECT IDCLIENTE,NOMBRE,APELLIDO,DIRECCION,
					NUMDUI,NUMNIT,TELEFONO,CLIENTEDE,ESTADO,RUTA,SALDO,REGFISCAL,GIRO FROM clientes WHERE IDCLIENTE = ? ORDER BY NOMBRE ASC');
				$consulta->bindValue(1,$pId);
				$consulta->execute();
		
				$Cliente = new Cliente();
			
			while ($Ob = $consulta->fetch(PDO::FETCH_OBJ)) {

				$Cliente->_set('IdCliente',$Ob->IDCLIENTE);
				$Cliente->_set('Nombre',$Ob->NOMBRE);
				$Cliente->_set('Apellido',$Ob->APELLIDO);
				$Cliente->_set('Direccion',$Ob->DIRECCION);
				$Cliente->_set('NumDui',$Ob->NUMDUI);
				$Cliente->_set('NumNit',$Ob->NUMNIT);
				$Cliente->_set('Telefono',$Ob->TELEFONO);
				$Cliente->_set('Clientede',$Ob->CLIENTEDE);
				$Cliente->_set('Estado',$Ob->ESTADO);
				$Cliente->_set('Ruta',$Ob->RUTA);
				$Cliente->_set('Saldo',$Ob->SALDO);
				$Cliente->_set('RegFiscal',$Ob->REGFISCAL);
				$Cliente->_set('Giro',$Ob->GIRO);
				
			}

			$conexion = null;
			return $Cliente;

		} 
		catch (PDOException  $e) 
		{
			$conexion = null;
			echo $e->getMessage().' '.$e->getCode();
		}
	}

	public function Abono($IdCliente,$Monto)
	{
		$conexion = new Conexion();
		$conexion = new Conexion();
		$consulta = $conexion->prepare("CALL Abono('$IdCliente','$Monto')");
		

		$consulta->execute();
		$Saldo = 0.00;
		
		while ($Ob = $consulta->fetch(PDO::FETCH_OBJ)) 
		{
			$Saldo = $Ob->SALDO;
					
		}

		$conexion = null;
		return $Saldo;

	}

	public function Cargo($IdCliente,$Monto)
	{
		$conexion = new Conexion();
		$consulta = $conexion->prepare("CALL Cargo('$IdCliente','$Monto')");
		

		$consulta->execute();
		$Saldo = 0.00;
		
		while ($Ob = $consulta->fetch(PDO::FETCH_OBJ)) 
		{
			$Saldo = $Ob->SALDO;
			$conexion = null;		
		}

		return $Saldo;

	}

	

}

 ?>