<?php
require_once('../cnf/pdocnx.php');
class Localizacion extends ConnectionManager
{
    public function getLocalizaciones()
    {
		$retval=array('data'=>false,
			'error'=>false,
			'r'=>""
            );
		$cnx = $this-> connectMysql();
		try{
			$sth = $cnx->prepare("SELECT ID_Localizacion, Localizacion FROM localizacion");
			$sth->execute();

			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$retval['data']=true;
                $retval['r'] .= "<option value='".$row['ID_Localizacion']."'>".utf8_encode($row['Localizacion'])."</option>";		
            }
		}
		catch(PDOException $e){
			$retval['error']=true;
			$retval['r']=$e->getMessage();
		}
		return json_encode($retval);
	}
}