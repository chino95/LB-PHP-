<?php
require_once('../../cnf/pdocnx.php');

class Sservicio extends ConnectionManager{


	public function newServicio($dt){
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>'');

		$cnx = $this-> connectMysql();
        session_start();
        $dt['idcliente']=$_SESSION['data']['idcliente'];
		try{
			$query="INSERT INTO sservicio (ID_Cliente, ID_TipoServicio, Foraneo, Tipo_Carga, Origen, Destino, Fecha, Hora, Peso, PesoM, Bultos, BultosM, Comentarios, status) 
			VALUES (:idcliente, :tipos, :foraneo, :tipoe, :origen, :destino, :fecha, :hora, :peso, :pesom, :bultos, :bultosm, :comentario, :status)";
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