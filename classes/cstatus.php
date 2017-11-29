<?php
require_once('../../cnf/pdocnx.php');

class Cstatus extends ConnectionManager{

    function getServicios(){
		$retval=array('data'=>false,
			'error'=>false,
            'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Fecha'),array('title'=>'Hora'),array('title'=>'Accion')));
        $cnx = $this-> connectMysql();
        session_start();
        $idsession=$_SESSION['data']['idcliente'];
		$nivels=$_SESSION['data']['nivel'];
		$idemp=$_SESSION['data']['idemp'];
		
		try{
			if($nivels == 0){ //admin empresa
				$retval['c']=array(array('title'=>'ID'),array('title'=>'Realiza'),array('title'=>'Fecha'),array('title'=>'Hora'),array('title'=>'Accion'));
				$sth = $cnx->prepare("SELECT s.ID_Servicio, c.Nombre_contacto, s.Fecha, s.Hora FROM sservicio s 
				INNER JOIN clientes c ON s.ID_Cliente = c.ID_Cliente 
				WHERE s.status = 'Aceptado' && c.ID_Empresa = :idemp");
				$sth->bindParam(":idemp", $idemp);
				$sth->execute();
	
				while($row = $sth->fetch(PDO::FETCH_ASSOC)){
					$retval['data']=true;
					array_push($retval['r'], array($row['ID_Servicio'], $row['Nombre_contacto'], $row['Fecha'], $row['Hora'],
					'<button class="btn btn-embossed btn-primary m-r-20" onclick="VerServicio('.$row['ID_Servicio'].')">Ver</button>'));
				}
			}
			if($nivels == 2){ //trabajador empresa
			
			$sth = $cnx->prepare("SELECT s.ID_Servicio, s.Fecha, s.Hora FROM sservicio s  
			INNER JOIN clientes c ON s.ID_Cliente = c.ID_Cliente
            WHERE s.status = 'Aceptado' && c.ID_Cliente = :id && c.ID_Empresa = :idemp");
			$sth->bindParam(":id", $idsession);
			$sth->bindParam(":idemp", $idemp);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], array($row['ID_Servicio'], $row['Fecha'], $row['Hora'],
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="VerServicio('.$row['ID_Servicio'].')">Ver</button>'));
			}
		}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}


	function getStatusServicio($id){
		$retval=array('data'=>false,
			'error'=>false,
            'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Status'),array('title'=>'Fecha')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT ID_UpdateS, Status, Fecha FROM updateservicio
			WHERE ID_Servicio = :id");
			$sth->bindParam(":id", $id);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], 
				array($row['ID_UpdateS'], $row['Status'], $row['Fecha']));
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}
	
	public function sentUpdate($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();
		$dt["fecha"]=date('Y/m/d');
		try{
			$query="INSERT INTO updateservicio (ID_Servicio, Status, Fecha, Ubicacion) 
			VALUES (:id, :status, :fecha, :ubi)";
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




}
?>