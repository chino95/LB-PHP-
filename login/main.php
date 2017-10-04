<?php
if(isset($_POST['action'])){
	include '../cnf/usuarios.php';
	include '../cnf/clientes.php';
	header('Content-Type: application/json');
	
	switch ($_POST['action']) {
		case 'login':
		$obj =  new Usuarios();
		echo $obj->login($_POST['dt']);
		break;
		case 'new':
		$obj =  new Clientes();
		echo $obj->newCliente($_POST['dtcl'],$_POST['dtcu']);
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>