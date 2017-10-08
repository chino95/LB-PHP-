<?php
if(isset($_POST['action'])){
	include '../../classes/tservicio.php';
	header('Content-Type: application/json');
	$obj =  new TServicio();
	switch ($_POST['action']) {
		case 'new':
		echo $obj->newTServicio($_POST['dt']);
		break;
        case 'get':
		echo $obj->getTServicios();
		break;
		case 'getData':
		echo $obj->getModalTServicio($_POST['id']);
		break;
        case 'update':
		echo $obj->updateTServicio($_POST['dt']);
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>