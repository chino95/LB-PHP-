<?php
require_once('pdocnx.php');

class Usuarios extends ConnectionManager{

	public function login($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');
		$cnx = $this-> connectMysql();
		$dt['psw'] = hash('sha256', $dt['psw']);
		$idcliente = 0;
		$nomcontacto = 0;
		$nomemp = 0;
		$idemp = 0;
		try{
			$sth = $cnx->prepare("SELECT ID_Cuenta, Correo, Psw, Nivel FROM cuentas WHERE Correo=:cor AND Psw=:psw");
			$sth->execute($dt);
			if($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$idcuenta = $row['ID_Cuenta'];
				$correo = $row['Correo'];
				$nivel = $row['Nivel'];
				//if($row['Nivel'] == '0')
				//{
					$sth = $cnx->prepare("SELECT c.ID_Cliente, c.Nombre_contacto, e.Nombre_Empresa, e.ID_Empresa FROM clientes c 
					INNER JOIN empresa e ON c.ID_Empresa = e.ID_Empresa WHERE c.ID_Cuenta = :idc");
					$sth->bindParam(":idc", $idcuenta);
					$sth->execute();
					if($row = $sth->fetch(PDO::FETCH_ASSOC)){
					$idcliente = $row['ID_Cliente'];
					$nomcontacto = $row['Nombre_contacto'];	
					$nomemp = $row['Nombre_Empresa'];
					$idemp = $row['ID_Empresa'];
					//}
				}
					session_start();
					$_SESSION['data'] = array(
					'idcuenta'=> $idcuenta, 
					'correo'=> $correo, 
					'nivel'=>$nivel, 
					'idcliente'=> $idcliente, 
					'nomcont'=>$nomcontacto, 
					'idemp'=>$idemp, 
					'nomemp'=>$nomemp);
					$retval['data']=true;
					$retval['r']=$_SESSION['data'];
			}
			else{
				$retval['r']="Usuario o Contraseña Incorrectos";
				$retval['error']=true;
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}
	public function newUsuario($dtcu, $dtus){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();
		$dtcu["psw"]=hash('sha256', $dtcu['psw']);

		try{
			$query="INSERT INTO cuentas (Correo, Psw, Nivel) 
			VALUES (:cor, :psw, 1)";
			$sth = $cnx->prepare($query);
			$sth->execute($dtcu);
			$dtus['id'] = $cnx->lastInsertId();
			if($retval['r']=$sth->rowCount()){
			
			$query="INSERT INTO usuarios (ID_Cuenta, Nombre) 
			VALUES (:id, :nom)";
			$sth = $cnx->prepare($query);
			$sth->execute($dtus);
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

	function getUsuario(){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Nombre'),array('title'=>'Correo'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT u.ID_Usuario, u.Nombre, c.Correo FROM usuarios u
			INNER JOIN cuentas c ON u.ID_Cuenta = c.ID_Cuenta");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], array($row['ID_Usuario'], $row['Nombre'], $row['Correo'],
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="MostrarModal('.$row['ID_Usuario'].')">Modificar</button>'));
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
}
?>