<?php
if(isset($_POST['action'])){
	include '../../classes/sservicio.php';
	header('Content-Type: application/json');
	$obj =  new Sservicio();
	switch ($_POST['action']) {
		case 'new':
		echo $obj->newServicio($_POST['dt']);
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>