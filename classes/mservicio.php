<?php
require_once('../../cnf/pdocnx.php');

class Mservicio extends ConnectionManager{

	public function aceptarsoli($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();
		$ids = $dt["idser"];
		try{
			$query="INSERT INTO aservicio (ID_Servicio, ID_Empleado, ID_Vehiculo, precio) 
			VALUES (:idser, :emp, :veh, :precio)";
			$sth = $cnx->prepare($query);
			$sth->execute($dt);
			if($retval['r']=$sth->rowCount()){
				$query="UPDATE sservicio SET status = 'Aceptado' WHERE ID_Servicio = :id";			
				$sth = $cnx->prepare($query);
				$sth->bindParam(':id', $ids);
				$sth->execute();
				if($retval['r']=$sth->rowCount()){
				$retval['data']=true;
				}
			}
		}
		catch(PDOException $e){
            $retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}

    function getMServicio(){
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
				'<button class="btn btn-embossed btn-success m-r-20" onclick="VerServicio('.$row['ID_Servicio'].')">Ver</button>
				<button class="btn btn-embossed btn-danger m-r-20" onclick="RechazarServicio('.$row['ID_Servicio'].')">Rechazar</button>'));
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