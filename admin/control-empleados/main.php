<?php
if(isset($_POST['action'])){
	include '../../classes/empleados.php';
	header('Content-Type: application/json');
	$obj =  new Empleados();
	switch ($_POST['action']) {
		case 'new':
		echo $obj->newUsuario($_POST['dtcu'],$_POST['dtus']);
		break;
        case 'get':
		echo $obj->getEmpleados();
		break;
		case 'getData':
		echo $obj->getModalUsuarios($_POST['id']);
		break;
        case 'update':
		echo $obj->updateUsuario($_POST['dtus'],$_POST['dtcu']);
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>