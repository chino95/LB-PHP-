<?php
if(isset($_POST['action'])){
	include '../../classes/csubusuarios.php';
	header('Content-Type: application/json');
	$obj =  new SubUsuarios();
	switch ($_POST['action']) {
		case 'new':
		echo $obj->newSubUsuario($_POST['dtc'],$_POST['dt']);
		break;
        case 'get':
		echo $obj->getSubUsuarios();
		break;
		case 'getData':
		echo $obj->getModalSubUsuarios($_POST['idc']);
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