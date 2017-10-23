<?php
if(isset($_POST['action'])){
	include '../../classes/shistorial.php';
	header('Content-Type: application/json');
	$obj =  new Shistorial();
	switch ($_POST['action']) {
        case 'get':
		echo $obj->getMServicio();
		break;
		case 'getData':
		echo $obj->getModalMServicio($_POST['id']);
		break;
		case 'getEmpVeh':
		echo $obj->getEmpVeh();
		break;
		case 'aceptarsoli':
		echo $obj->aceptarsoli($_POST['dt']);
		break;
		case 'rechazarsoli':
		echo $obj->rechazarsoli($_POST['dt']);
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>