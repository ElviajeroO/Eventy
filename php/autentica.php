<?php
	#include "phpmailer.php";
	#use OTPHP\TOTP;

    	#require '../vendor/autoload.php';
	
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	session_start();
	$_SESSION["tempo"] = time();

	if (!empty($_SESSION["autenticado"])){
		$_SESSION["email"] = $email;
		$_SESSION["senha"] = $senha;
	}else{
		session_unset();
		session_destroy();
		session_start();
		$_SESSION["email"] = $email;
		$_SESSION["senha"] = $senha;
	}

	#$otp = TOTP::generate();
	#$secret = $otp->getSecret();

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT senha FROM users WHERE email = '$email' and senha = '$senha' and confirmado = 1";
	$resultado = mysqli_query($connection, $query);
	
	$res =  mysqli_num_rows($resultado);

	if ($res == 1){
		$_SESSION["ID"] = 1;
		$_SESSION["nome"] = $email;
		#mandar($email,$secret);
		}
	else {
		$_SESSION["autenticado"] = 0;
		echo $_SESSION["autenticado"];
	}


	
?>
