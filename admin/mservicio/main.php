<?php
if(isset($_POST['action'])){
	include '../../classes/mservicio.php';
	header('Content-Type: application/json');
	$obj =  new MServicio();
	switch ($_POST['action']) {
        case 'get':
		echo $obj->getMServicio();
		break;
		case 'getData':
		echo $obj->getModalCliente($_POST['id']);
		break;
       
		default:
		echo "Opción Inválida";
		break;
	}
}
?>