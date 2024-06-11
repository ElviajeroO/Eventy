<?php
	include "phpmailer.php";
	include "../php/pegachave.php";

	require '../vendor/autoload.php';
	
	$email = $_POST['email'];
	$otp = $_POST['otp'];

	$msg = array();

	session_name("Eventy");
	session_set_cookie_params((60*5),"/");

	session_start();

	$cp = extract_from_image("../img/porco.png");

    	$teste = preg_split("/[;]/",$cp);

	$connection = mysqli_connect($teste[0], $teste[1], $teste[2], $teste[3]);
	$query = "SELECT otp FROM users WHERE email = '$email' and confirmado = 1";
	$resultado = mysqli_query($connection, $query);
	
	while($tourrow = mysqli_fetch_assoc($resultado)){
		$secret = $tourrow['otp'];	
	}


	$authenticator = new PHPGangsta_GoogleAuthenticator();

	$tolerance = 1;	

	$checkResult = $authenticator->verifyCode($secret, $otp, 2);    
	
	if ($checkResult) 
	{

		$_SESSION["email"] = $email;
		$_SESSION["autenticado"] = 1;

	$id = session_id();
	$query = "UPDATE users SET cookie='$id' where email='$email' and confirmado='1'";
	mysqli_query($connection, $query);

	array_push($msg, $_SESSION['autenticado']);
	array_push($msg, 'autenticado');	

	} else {
	   	array_push($msg, '0');
	       	array_push($msg, 'codigo errado');	
	}

	$json = json_encode($msg);

	echo $json;

?>
	
