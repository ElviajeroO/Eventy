<?php
	include_once "./banco.php";

	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$msg = array();
	
	$msg = autentica_user($email, $senha);

	$json = json_encode($msg);

	echo $json;
	
?>
