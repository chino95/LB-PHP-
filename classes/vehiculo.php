<?php
require_once('../../cnf/pdocnx.php');

class Vehiculo extends ConnectionManager{

	public function newVehiculo($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();

		try{
			$query="INSERT INTO vehiculos (Marca, Modelo, Serie, Tipo, Placa_Mex, Placa_Usa, Clave_Vehiculo, Numero_Economico, Capacidad_Carga, Capacidad_Volumen, Medidas) 
			VALUES (:marca, :modelo, :serie, :tipov, :placam, :placau, :clavev, :numeco, :capcar, :capvol, :medidas)";
			$sth = $cnx->prepare($query);
			$sth->execute($dt);
			if($retval['r']=$sth->rowCount()){
				$retval['data']=true;
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
			if($e->getCode() == "23000")
				$retval['r']="Usuario duplicado";
			else
				$retval['r']=$e->getMessage()."  Error Code: ".$e->getCode();
		}
		return json_encode($retval);
	}

	function getVehiculos(){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Marca'),array('title'=>'Modelo'),array('title'=>'Serie'),array('title'=>'Tipo'),array('title'=>'Placa MEX'),array('title'=>'Placa USA'),array('title'=>'Clave'),array('title'=>'# Economico'),array('title'=>'Capacidad de Carga'),array('title'=>'Capacidad de Volumen'),array('title'=>'Medidas'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT v.ID_Vehiculo, v.Marca, v.Modelo, v.Serie, v.Tipo, v.Placa_Mex, v.Placa_Usa, v.Clave_Vehiculo, v.Numero_Economico, v.Capacidad_Carga, v.Capacidad_Volumen, v.Medidas FROM vehiculos v");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], array($row['ID_Vehiculo'], $row['Marca'], $row['Modelo'], $row['Serie'], $row['Tipo'], $row['Placa_Mex'], $row['Placa_Usa'], $row['Clave_Vehiculo'], $row['Numero_Economico'], $row['Capacidad_Carga'], $row['Capacidad_Volumen'], $row['Medidas'],
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="MostrarModal('.$row['ID_Vehiculo'].')">Modificar</button>'));
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

function getModalVehiculo($id){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array());
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT v.ID_Vehiculo, v.Marca, v.Modelo, v.Serie, v.Tipo, v.Placa_Mex, v.Placa_Usa, v.Clave_Vehiculo, v.Numero_Economico, v.Capacidad_Carga, v.Capacidad_Volumen, v.Medidas FROM vehiculos v
			WHERE ID_Vehiculo = :id");
			$sth->bindParam(":id", $id);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'],  
				$row['Marca'], 
				$row['Modelo'], 
				$row['Serie'], 
				$row['Tipo'], 
				$row['Placa_Mex'], 
				$row['Placa_Usa'], 
				$row['Clave_Vehiculo'], 
				$row['Numero_Economico'], 
                $row['Capacidad_Carga'], 
				$row['Capacidad_Volumen'], 
				$row['Medidas']
				);
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

	public function updateVehiculo($dt){
		$retval=array('data'=>false,
			'error'=>false,
            'r'=>'');
            
		$cnx = $this-> connectMysql();
		try{
			$query="UPDATE vehiculos SET Marca = :marca, Modelo= :modelo, Serie= :serie, Tipo = :tipov, Placa_Mex= :placam, Placa_Usa = :placau, Clave_Vehiculo= :clavev, Numero_Economico= :numeco, Capacidad_Carga= :capcar, Capacidad_Volumen= :capvol, Medidas= :medidas WHERE ID_Vehiculo = :id";
			$sth = $cnx->prepare($query);
			$sth->execute($dt);
			$retval['s']=$query;
			if($retval['r']=$sth->rowCount()){
				$retval['data']=true;
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

	public function updateCliente($dtcl, $dtcu){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');
		$obj = new ConnectionManager();
		$cnx = $obj-> connectMysql();
		$dtcu["psw"]=hash('sha256', $dtcu['psw']);
		//$idus = $dtus['id'];
		try{
			$query="UPDATE clientes SET Nombre_contacto =:contacto, Nombre_empresa =:empresa, Direccion = :dire, Telefono = :tel, Num_Ctpat =:ctpat WHERE ID_Cliente = :idcl";
			$sth = $cnx->prepare($query);
			$sth->execute($dtcl);
			$retval['s']=$query;
			if($retval['r']=$sth->rowCount()){
				$retval['data']=true;
			}
				$query="UPDATE cuentas SET Correo =:cor, Psw= :psw WHERE ID_Cuenta = :id";
				$sth = $cnx->prepare($query);
				$sth->execute($dtcu);
				$retval['s']=$query;
				if($retval['r']=$sth->rowCount())
					$retval['data']=true;
				
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}
}
?>