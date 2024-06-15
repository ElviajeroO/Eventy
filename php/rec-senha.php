<?php
	include_once "./banco.php";

	$email = $_POST['email'];

	$pattern = '/.*@.*\..*/';

	$msg = array();

    	$codigo_aut = abs(random_int(-9999, 9999));

	if(preg_match($pattern, $email)){
		$msg = recupera_senha($email, $codigo_aut);
	}else{
		array_push($msg, "0");
		array_push($msg, "Email invalido");
	}

	$json = json_encode($msg);

	echo $json;
    
?>
