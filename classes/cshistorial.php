<?php
require_once('../../cnf/pdocnx.php');

class CShistorial extends ConnectionManager{

    
    function getMServicio(){
		$retval=array('data'=>false,
			'error'=>false,
            'r'=>array(),
			'c'=>array(array('title'=>'ID'),array('title'=>'Fecha'),array('title'=>'Hora'),array('title'=>'Status'),array('title'=>'Accion')));
        $cnx = $this-> connectMysql();
        session_start();
		$idsession=$_SESSION['data']['idcliente'];
		$nivels=$_SESSION['data']['nivel'];
		$idemp=$_SESSION['data']['idemp'];
		$status =" ";
		try{
			if($nivels == 0){ //admin empresa	
				$retval['c']=array(array('title'=>'ID'),array('title'=>'Realiza'),array('title'=>'Fecha'),array('title'=>'Hora'),array('title'=>'Status'),array('title'=>'Accion'));
				$sth = $cnx->prepare("SELECT s.ID_Servicio, c.Nombre_contacto, e.Nombre_empresa, s.Fecha, s.Hora, s.status FROM sservicio s  
				INNER JOIN clientes c ON s.ID_Cliente = c.ID_Cliente
				INNER JOIN empresa e ON c.ID_Empresa = e.ID_Empresa
				WHERE c.ID_Empresa = :idemp");
				$sth->bindParam(":idemp", $idemp);
				$sth->execute();
				
				while($row = $sth->fetch(PDO::FETCH_ASSOC)){
					$retval['data']=true;
					
					switch($row['status']){
						case "Solicitado":
						$status = '<span class="label label-primary">Solicitado</span>';
						break;
						case "Aceptado":
						$status = '<span class="label label-success">En proceso</span>';
						break;
						case "Rechazado":
						$status = '<span class="label label-danger">Rechazado</span>';
						break;
						case "Finalizado":
						$status = '<span class="label label-warning">Finalizado</span>';
						break;
					}
					array_push($retval['r'], array($row['ID_Servicio'], $row['Nombre_contacto'], $row['Fecha'], $row['Hora'], $status,
					'<button class="btn btn-embossed btn-success m-r-20" onclick="VerServicio('.$row['ID_Servicio'].')">Ver</button>'));
				}
			}
			if($nivels == 2){ //trabajador empresa
				$sth = $cnx->prepare("SELECT s.ID_Servicio, c.Nombre_contacto, e.Nombre_empresa, s.Fecha, s.Hora, s.status FROM sservicio s  
				INNER JOIN clientes c ON s.ID_Cliente = c.ID_Cliente
				INNER JOIN empresa e ON c.ID_Empresa = e.ID_Empresa
				WHERE c.ID_Cliente = :id && c.ID_Empresa = :idemp");
				$sth->bindParam(":idemp", $idemp);
				$sth->bindParam(":id", $idsession);
				$sth->execute();
				while($row = $sth->fetch(PDO::FETCH_ASSOC)){
					$retval['data']=true;
					switch($row['status']){
						case "Solicitado":
						$status = '<span class="label label-primary">Solicitado</span>';
						break;
						case "Aceptado":
						$status = '<span class="label label-success">En proceso</span>';
						break;
						case "Rechazado":
						$status = '<span class="label label-danger">Rechazado</span>';
						break;
						case "Finalizado":
						$status = '<span class="label label-warning">Finalizado</span>';
						break;
					}
					array_push($retval['r'], array($row['ID_Servicio'], $row['Fecha'], $row['Hora'], $status,
					'<button class="btn btn-embossed btn-success m-r-20" onclick="VerServicio('.$row['ID_Servicio'].')">Ver</button>'));
				}
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
			$sth = $cnx->prepare("SELECT s.ID_Servicio, s.Fecha, s.Hora, s.Foraneo, s.Tipo_Carga, s.Origen, s.Destino, s.Peso, s.PesoM, s.Bultos, s.BultosM, s.Comentarios FROM sservicio s  
			INNER JOIN clientes c ON s.ID_Cliente = c.ID_Cliente
			WHERE s.ID_Servicio = :id");
			$sth->bindParam(":id", $id);
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
				
				$foraneo = $row['Foraneo'] == 1 ?  '<span class="label label-sm label-primary"> Foraneo </span>' : '<span class="label label-sm label-warning"> No Foraneo </span>';
				array_push($retval['r'],  
				//$row['Nombre_empresa'], 
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