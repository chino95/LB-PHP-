<?php
require_once('../../cnf/pdocnx.php');

class SubUsuarios extends ConnectionManager{

	public function newSubUsuario($dtc, $dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();
		$dtc["psw"] = hash('sha256', $dtc['psw']);
        session_start();
        $dt['ide']=$_SESSION['data']['idemp'];
		try{
			$query="INSERT INTO cuentas (Correo, Psw, Nivel) 
			VALUES (:cor, :psw, :nivel)";
			$sth = $cnx->prepare($query);
			$sth->execute($dtc);
			$dt['idc'] = $cnx->lastInsertId();
			if($retval['r']=$sth->rowCount()){
			
			$query="INSERT INTO clientes (ID_Cuenta, ID_Empresa, Nombre_contacto) 
			VALUES (:idc, :ide, :nom)";
			$sth = $cnx->prepare($query);
			$sth->execute($dt);
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

	function getSubUsuarios(){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array(),
			'c'=>array(array('title'=>'Nombre'),array('title'=>'Correo'),array('title'=>'Accion')));
        $cnx = $this-> connectMysql();
        session_start();
        $idemp=$_SESSION['data']['idemp'];
		try{
			$sth = $cnx->prepare("SELECT c.ID_Cuenta ,c.Nombre_contacto, cc.Correo FROM clientes c
            INNER JOIN empresa e ON c.ID_Empresa = e.ID_Empresa
            INNER JOIN  cuentas cc ON c.ID_Cuenta = cc.ID_Cuenta
            WHERE e.ID_Empresa = :idemp");
            $sth->bindParam(":idemp", $idemp);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], array($row['Nombre_contacto'], $row['Correo'],
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="MostrarModal('.$row['ID_Cuenta'].')">Modificar</button>'));
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

function getModalSubUsuarios($idc){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array());
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT c.Nombre_contacto, cc.Correo FROM clientes c INNER JOIN cuentas cc ON c.ID_Cuenta = cc.ID_Cuenta WHERE c.ID_Cuenta = :id");
			$sth->bindParam(":id", $idc);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'],  
				$row['Nombre_contacto'], 
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
		try{
			$query="UPDATE clientes SET Nombre_contacto = :nom WHERE ID_Cuenta = :idc";
			$sth = $cnx->prepare($query);
			$sth->execute($dtus);
			$retval['s']=$query;
			if($retval['r']=$sth->rowCount()){
				$retval['data']=true;
			}
				$query="UPDATE cuentas SET Correo =:cor, Psw= :psw WHERE ID_Cuenta = :idc";
				$sth = $cnx->prepare($query);
				$sth->execute($dtcu);
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