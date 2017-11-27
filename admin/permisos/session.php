<?php
if(isset($_POST['action'])){
	header('Content-Type: application/json');
	session_start();
	switch ($_POST['action']) {
		case 'logout':
			session_destroy();
			echo json_encode(array('data' =>true));
		break;
		case 'check':
			if(isset($_SESSION['data']['correo']))
				echo json_encode(array('data' =>true,'nivel' =>$_SESSION['data']['nivel'], 'correo' =>$_SESSION['data']['correo'], 'nomemp' =>$_SESSION['data']['nomemp']));
			else
				echo json_encode(array('data' =>false));
		break;
	}
}