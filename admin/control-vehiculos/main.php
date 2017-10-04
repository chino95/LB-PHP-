<?php
if(isset($_POST['action'])){
	include '../../cnf/usuarios.php';
	header('Content-Type: application/json');
	$obj =  new Usuarios();
	switch ($_POST['action']) {
		case 'new':
		echo $obj->newUsuario($_POST['dtcu'],$_POST['dtus']);
		break;
        case 'get':
		echo $obj->getUsuario();
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