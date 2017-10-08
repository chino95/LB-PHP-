<?php
require_once('../../cnf/pdocnx.php');

class TServicio extends ConnectionManager{

	public function newTServicio($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();

		try{
			$query="INSERT INTO tservicio (Tipo) 
			VALUES (:nom)";
			$sth = $cnx->prepare($query);
			$sth->execute($dt);
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

	function getTServicios(){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Nombre del Servicio'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT ID_TipoServicio, Tipo FROM tservicio");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], array($row['ID_TipoServicio'], $row['Tipo'],
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="MostrarModal('.$row['ID_TipoServicio'].')">Modificar</button>'));
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

	function getTServiciosM(){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Nombre del Servicio'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT ID_TipoServicio, Tipo FROM tservicio");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], array($row['ID_TipoServicio'], $row['Tipo'],
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="MostrarModal('.$row['ID_TipoServicio'].')">Modificar</button>'));
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

function getModalTServicio($id){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array());
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT Tipo FROM tservicio
            WHERE ID_TipoServicio = :id");
			$sth->bindParam(":id", $id);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'],  
				$row['Tipo']
				);
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
    }

	public function updateTServicio($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');
		$obj = new ConnectionManager();
		$cnx = $obj-> connectMysql();
		try{
			$query="UPDATE tservicio SET Tipo =:nom WHERE ID_TipoServicio = :id";
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
}
?>