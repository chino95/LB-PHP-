<?php
if(isset($_POST['action'])){
	include '../../classes/vehiculo.php';
	header('Content-Type: application/json');
	$obj =  new Vehiculo();
	switch ($_POST['action']) {
		case 'new':
		echo $obj->newVehiculo($_POST['dt']);
		break;
        case 'get':
		echo $obj->getVehiculos();
		break;
		case 'getData':
		echo $obj->getModalVehiculo($_POST['id']);
		break;
        case 'update':
		echo $obj->updateVehiculo($_POST['dt']);
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>