<?php
require_once('../../cnf/pdocnx.php');

class status extends ConnectionManager{

    function getServicios(){
		$retval=array('data'=>false,
			'error'=>false,
            'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Cliente'),array('title'=>'Fecha'),array('title'=>'Hora'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT s.ID_Servicio, c.Nombre_empresa, s.Fecha, s.Hora FROM sservicio s  
			INNER JOIN clientes c ON s.ID_Cliente = c.ID_Cliente
			WHERE s.status = 'solicitado'");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], array($row['ID_Servicio'], $row['Nombre_empresa'], $row['Fecha'], $row['Hora'],
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="VerServicio('.$row['ID_Servicio'].')">Ver</button>'));
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