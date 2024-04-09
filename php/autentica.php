<?php
	include "phpmailer.php";
	use OTPHP\TOTP;

    	require '../vendor/autoload.php';

	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$otp = TOTP::generate();
	$secret = $otp->getSecret();

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT senha FROM users WHERE email = '$email' and senha = '$senha' and confirmado = 1";
	$resultado = mysqli_query($connection, $query);
	
	$res =  mysqli_num_rows($resultado);

	if ($res == 1){
		echo 'deu $otp';
		mandar($email,$secret);}
       	else {echo 'ndeu';}


	
?>
