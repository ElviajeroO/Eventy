<?php
	require "../vendor/autoload.php";
	include "../php/phpmailer.php";

	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$msg = array();

    	$codigo_aut = abs(random_int(-9999, 9999));

	mandar($email, $codigo_aut);

	$authenticator = new PHPGangsta_GoogleAuthenticator();

	$secret = $authenticator->createSecret();

	$website = 'http://Eventy.com';

	$title= 'Eventy';

	$qrCodeUrl = $authenticator->getQRCodeGoogleUrl($title, $secret);

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');

	$query = "SELECT email FROM users WHERE email='$email'";

	$resultado = mysqli_query($connection, $query);
	
	$res =  mysqli_num_rows($resultado);

	if($res > 0){
		array_push($msg, "0");
		array_push($msg, "Email existente");

	}else{
	
		$query = "INSERT INTO users (email, senha ,codconfirmacao, otp) VALUES ('$email', '$senha', '$codigo_aut', '$secret')";

		mysqli_query($connection, $query);

		array_push($msg, $secret);

		array_push($msg, $qrCodeUrl);
	}


	$json = json_encode($msg);

	echo $json;

?>
