<?php
if(isset($_POST['action'])){
	include '../../classes/status.php';
	header('Content-Type: application/json');
	$obj =  new status();
	switch ($_POST['action']) {
        case 'get':
		echo $obj->getServicios();
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>