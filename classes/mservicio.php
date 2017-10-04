<?php
require_once('../../cnf/pdocnx.php');

class Mservicio extends ConnectionManager{


    function getMServicio(){
		$retval=array('data'=>false,
			'error'=>false,
            'r'=>array(),
            // (ID_Cliente, Foraneo, Tipo_Carga, Origen, Destino, Fecha, Hora, Peso, Bultos, Comentarios) 
			'c'=>array(array('title'=>'ID'),array('title'=>'Cliente'),array('title'=>'Fecha'),array('title'=>'Hora'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT s.ID_Servicio, c.Nombre_empresa, s.Fecha, s.Hora FROM sservicio s  
			INNER JOIN clientes c ON s.ID_Cliente = c.ID_Cliente");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				//$status = $row['Num_Ctpat'] != 0 ?  $row['Num_Ctpat'] : '<span class="label label-sm label-danger"> No cuenta con CTPAT </span>';
				
				array_push($retval['r'], array($row['ID_Servicio'], $row['Nombre_empresa'], $row['Fecha'], $row['Hora'],
				'<button class="btn btn-embossed btn-primary m-r-20" onclick="MostrarModal('.$row['ID_Servicio'].')">Ver</button>'));
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