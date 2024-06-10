<?php
	include "phpmailer.php";

	require '../vendor/autoload.php';
	
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$msg = array();

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT senha, otp FROM users WHERE email = '$email' and senha = '$senha' and confirmado = 1";
	$resultado = mysqli_query($connection, $query);
	
	$res =  mysqli_num_rows($resultado);

	if ($res == 1){
		array_push($msg, "1");
		array_push($msg, "usuario correto");
	}else {
		array_push($msg, "0");
		array_push($msg, "usuario incorreto");
	}

	$json = json_encode($msg);

	echo $json;
	
?>
