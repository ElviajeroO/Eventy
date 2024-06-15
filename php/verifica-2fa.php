<?php
	include_once "./banco.php";

	$email = $_POST['email'];
	$otp = $_POST['otp'];

	$msg = array();

	session_name("Eventy");
	session_set_cookie_params((60*5),"/");

	session_start();
	
	$msg = verifica_2fa($email, $otp);

	$json = json_encode($msg);

	echo $json;

?>
	
