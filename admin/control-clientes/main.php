<?php
if(isset($_POST['action'])){
	include '../../cnf/clientes.php';
	header('Content-Type: application/json');
	$obj =  new Clientes();
	switch ($_POST['action']) {
        case 'get':
		echo $obj->getClientes();
		break;
		case 'getData':
		echo $obj->getModalCliente($_POST['id']);
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