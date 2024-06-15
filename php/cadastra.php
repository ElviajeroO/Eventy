<?php
	require "../vendor/autoload.php";
	include_once "../php/phpmailer.php";
	include_once "./banco.php";

	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$codigo_aut = abs(random_int(-9999, 9999));

	$msg = array();

	$msg = cadastra_user($email, $senha, $codigo_aut);


	$json = json_encode($msg);

	echo $json;

?>
