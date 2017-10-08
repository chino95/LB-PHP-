<?php
if(isset($_POST['action'])){
	include '../../classes/sservicio.php';
	include '../../classes/tservicio.php';
	header('Content-Type: application/json');
	$obj =  new Sservicio();
	$objt =  new TServicio();
	switch ($_POST['action']) {
		case 'new':
		echo $obj->newServicio($_POST['dt']);
		break;
		case 'getTServicio':
		echo $objt->getTServicios();
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>