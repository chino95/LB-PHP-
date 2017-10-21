<?php
require_once('../../cnf/pdocnx.php');

class Empleados extends ConnectionManager{

	public function newCliente($dtcl, $dtcu){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();
		$dtcu["psw"]=hash('sha256', $dtcu['psw']);

		try{
			$query="INSERT INTO cuentas (Correo, Psw, Nivel) 
			VALUES (:cor, :psw, 0)";
			$sth = $cnx->prepare($query);
			$sth->execute($dtcu);
			$dtcl['idcu'] = $cnx->lastInsertId();
			if($retval['r']=$sth->rowCount()){
			
			$query="INSERT INTO clientes (ID_Cuenta, Nombre_contacto, Nombre_empresa, Direccion, Telefono, Num_Ctpat) 
			VALUES (:idcu, :contacto, :empresa, :dire, :tel, :ctpat)";
			$sth = $cnx->prepare($query);
			$sth->execute($dtcl);
			if($retval['r']=$sth->rowCount())
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

	function getEmpleados(){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Nombre'),array('title'=>'Direccion'),array('title'=>'Telefono'),array('title'=>'Licencia'),array('title'=>'Tipo Licencia'),array('title'=>'Visa'),array('title'=>'IFE'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT e.ID_Empleados, e.Nombre, e.Appat, e.Direccion, e.Telefono, e.Num_Licencia, e.Tipo_Licencia, e.Num_Visa, e.IFE FROM empleados e");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				$licencia = $row['Num_Licencia'] != 0 ?  $row['Num_Licencia'] : '<span class="label label-sm label-danger"> No cuenta con Licencia </span>';
                $visa = $row['Num_Visa'] != 0 ?  $row['Num_Visa'] : '<span class="label label-sm label-danger"> No cuenta con Visa </span>';
                
				array_push($retval['r'], array($row['ID_Empleados'], $row['Nombre'].' '.$row['Appat'], $row['Direccion'], $row['Telefono'], $licencia, $row['Tipo_Licencia'], $visa, $row['IFE'],
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="MostrarModal('.$row['ID_Empleados'].')">Modificar</button>'));
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

function getModalUsuarios($id){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array());
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT u.ID_Usuario, u.Nombre, c.Correo FROM usuarios u
			INNER JOIN cuentas c ON u.ID_Cuenta = c.ID_Cuenta WHERE ID_Usuario = :id");
			$sth->bindParam(":id", $id);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'],  
				$row['Nombre'], 
				$row['Correo']
				);
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

	function getModalCliente($id){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array());
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT c.ID_Cliente, c.Nombre_contacto, c.Nombre_empresa, c.Direccion, c.Telefono, c.Num_Ctpat, q.Correo FROM clientes c
			INNER JOIN cuentas q ON c.ID_Cuenta = q.ID_Cuenta WHERE ID_Cliente = :id");
			$sth->bindParam(":id", $id);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'],  
				$row['Nombre_contacto'], 
				$row['Nombre_empresa'],
				$row['Direccion'],
				$row['Telefono'],
				$row['Num_Ctpat'],
				$row['Correo']
				);
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

	public function updateUsuario($dtus, $dtcu){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');
		$obj = new ConnectionManager();
		$cnx = $obj-> connectMysql();
		$dtcu["psw"]=hash('sha256', $dtcu['psw']);
		$idus = $dtus['id'];
		try{
			$query="UPDATE usuarios SET Nombre =:nom WHERE ID_Usuario = :id";
			$sth = $cnx->prepare($query);
			$sth->execute($dtus);
			$retval['s']=$query;
			if($retval['r']=$sth->rowCount()){
				$retval['data']=true;
			}
			
				$sth = $cnx->prepare("SELECT ID_Cuenta FROM usuarios WHERE ID_Usuario = :id");
				$sth->bindParam(":id", $idus);
				$sth->execute();
				if($row = $sth->fetch(PDO::FETCH_ASSOC)){
					$dtcu['idcu']=$row['ID_Cuenta'];
				


				$query="UPDATE cuentas SET Correo =:cor, Psw= :psw WHERE ID_Cuenta = :idcu";
				$sth = $cnx->prepare($query);
				$sth->execute($dtcu);
				$retval['s']=$query;
				if($retval['r']=$sth->rowCount())
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