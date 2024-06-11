<?php
	include "phpmailer.php";
	include "../php/pegachave.php";

	require '../vendor/autoload.php';
	
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$msg = array();

	$cp = extract_from_image("../img/porco.png");

    	$teste = preg_split("/[;]/",$cp);

	$connection = mysqli_connect($teste[0], $teste[1], $teste[2], $teste[3]);

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
