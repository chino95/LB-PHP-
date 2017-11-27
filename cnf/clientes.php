<?php
require_once('pdocnx.php');

class Clientes extends ConnectionManager{


	public function newCliente($dtce, $dtcl, $dtcld, $dtcu){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();
		$dtcu["psw"]=hash('sha256', $dtcu['psw']);

		try{
			$query="INSERT INTO empresa (Nombre_Empresa, Num_Ctpat) 
			VALUES (:empresa, :ctpat)";
			$sth = $cnx->prepare($query);
			$sth->execute($dtce);
			$dtcl['idce'] = $cnx->lastInsertId();
			if($retval['r']=$sth->rowCount()){

			$query="INSERT INTO cuentas (Correo, Psw, Nivel) 
			VALUES (:cor, :psw, 0)";
			$sth = $cnx->prepare($query);
			$sth->execute($dtcu);
			$dtcl['idcu'] = $cnx->lastInsertId();
			if($retval['r']=$sth->rowCount()){
			
			$query="INSERT INTO clientes (ID_Cuenta, ID_Empresa, Nombre_contacto) 
			VALUES (:idcu, :idce, :contacto)";
			$sth = $cnx->prepare($query);
			$sth->execute($dtcl);
			$dtcld['idcl'] = $cnx->lastInsertId();
			if($retval['r']=$sth->rowCount()){
				
				$query="INSERT INTO clientes_detalle (ID_Cliente, Direccion, Telefono) 
				VALUES (:idcl, :dire, :tel)";
				$sth = $cnx->prepare($query);
				$sth->execute($dtcld);
				if($retval['r']=$sth->rowCount())
				$retval['data']=true;
			}
			}
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

	function getClientes(){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Nombre de contacto'),array('title'=>'Nombre de empresa'),array('title'=>'Direccion'),array('title'=>'Telefono'),array('title'=>'CTPAT'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT e.ID_Cliente, e.ID_Cuenta, e.Nombre_contacto, e.Nombre_empresa, e.Direccion, e.Telefono, e.Num_Ctpat FROM clientes e
			INNER JOIN cuentas c ON e.ID_Cuenta = c.ID_Cuenta");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				$status = $row['Num_Ctpat'] != 0 ?  $row['Num_Ctpat'] : '<span class="label label-sm label-danger"> No cuenta con CTPAT </span>';
				
				array_push($retval['r'], array($row['ID_Cliente'], $row['Nombre_contacto'], $row['Nombre_empresa'], $row['Direccion'], $row['Telefono'], $status,
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="MostrarModal('.$row['ID_Cliente'].','.$row['ID_Cuenta'].')">Modificar</button>'));
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