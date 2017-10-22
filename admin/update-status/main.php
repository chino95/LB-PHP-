<?php
if(isset($_POST['action'])){
	include '../../classes/status.php';
	header('Content-Type: application/json');
	$obj =  new status();
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