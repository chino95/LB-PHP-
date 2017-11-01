<?php
require_once('../../cnf/pdocnx.php');

class Shistorial extends ConnectionManager{

    function getMServicio(){
		$retval=array('data'=>false,
			'error'=>false,
            'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Cliente'),array('title'=>'Fecha'),array('title'=>'Hora'),array('title'=>'Status'),array('title'=>'Accion')));
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT s.ID_Servicio, c.Nombre_empresa, s.Fecha, s.Hora, s.status FROM sservicio s  
			INNER JOIN clientes c ON s.ID_Cliente = c.ID_Cliente");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				array_push($retval['r'], array($row['ID_Servicio'], $row['Nombre_empresa'], $row['Fecha'], $row['Hora'], $row['status'],
				'<button class="btn btn-embossed btn-success m-r-20" onclick="VerServicio('.$row['ID_Servicio'].')">Ver</button>'));
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

	function getModalMServicio($id){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>array());
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT s.ID_Servicio, c.Nombre_empresa, s.Fecha, s.Hora, s.Foraneo, s.Tipo_Carga, s.Origen, s.Destino, s.Peso, s.PesoM, s.Bultos, s.BultosM, s.Comentarios FROM sservicio s  
			INNER JOIN clientes c ON s.ID_Cliente = c.ID_Cliente
			WHERE s.ID_Servicio = :id");
			$sth->bindParam(":id", $id);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				
				$foraneo = $row['Foraneo'] == 1 ?  '<span class="label label-sm label-primary"> Foraneo </span>' : '<span class="label label-sm label-warning"> No Foraneo </span>';
				array_push($retval['r'],  
				$row['Nombre_empresa'], 
				$row['Fecha'],
				$row['Hora'], 
				$foraneo,
				$row['Tipo_Carga'], 
				$row['Origen'],
				$row['Destino'], 
				$row['Peso'].' '.$row['PesoM'], 
				$row['Bultos'].' '.$row['BultosM'], 
				$row['Comentarios']
				);
			}
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

	function getEmpVeh(){
		$retval=array('data'=>false,
			'error'=>false,
			'e'=>"<option>Seleccione una opcion</option>",
			'v'=>"<option>Seleccione una opcion</option>");
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT Nombre, Appat FROM empleados");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				$retval['e'].= "<option>".$row['Nombre'].' '.$row['Appat']."</option>";	
			}

			$sth = $cnx->prepare("SELECT Marca, Modelo FROM vehiculos");
			$sth->execute();
			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				$retval['v'].= "<option>".$row['Marca'].' '.$row['Modelo']."</option>";	
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