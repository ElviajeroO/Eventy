<?php
	include "phpmailer.php";

	require '../vendor/autoload.php';
	
	$email = $_POST['email'];
	$otp = $_POST['otp'];

	$msg = array();

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT otp FROM users WHERE email = '$email' and confirmado = 1";
	$resultado = mysqli_query($connection, $query);
	
	$resultado = mysqli_query($connection, $query);

	while($tourrow = mysqli_fetch_assoc($resultado)){
		$secret = $tourrow['otp'];	
	}


	$authenticator = new PHPGangsta_GoogleAuthenticator();

	$tolerance = 1;	

	$checkResult = $authenticator->verifyCode($secret, $otp, 2);    
	
    	$codigo_aut = abs(random_int(-9999, 9999));

	if ($checkResult) 
	{
		array_push($msg, '1');
	       	array_push($msg, 'autenticado');	
		setcookie("Eventy", $codigo_aut, time() + (300), "/");
		$query = "UPDATE users SET cookie='$codigo_aut' where email='$email'and confirmado=1";
		mysqli_query($connection, $query);
		array_push($msg, $_COOKIE["Eventy"]);
	} else {
	   	array_push($msg, '0');
	       	array_push($msg, 'codigo errado');	
	}

	$json = json_encode($msg);

	echo $json;

?>
	
