<?php
if(isset($_POST['action'])){
	include '../../classes/cstatus.php';
	header('Content-Type: application/json');
	$obj =  new Cstatus();
	switch ($_POST['action']) {
        case 'get':
		echo $obj->getServicios();
		break;
		case 'getDataVer':
		echo $obj->getStatusServicio($_POST['id']);
		break;
		case 'sentUpdate':
		echo $obj->sentUpdate($_POST['dt']);
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>