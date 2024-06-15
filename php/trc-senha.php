<?php
	include_once "./banco.php";
	$email = $_POST['email'];
	$senha1 = $_POST['senha1'];
	$senha2 = $_POST['senha2'];

	$pattern = '/.*@.*\..*/';

	$msg = array();

	if(preg_match($pattern, $email)){
		if($senha1 == $senha1){

			$msg = autentica_user($email, $senha1);

		}
		else{
			array_push($msg, "0");
			array_push($msg, "senhas diferentes");
		}
	}
	else{
		array_push($msg, "0");
		array_push($msg, "email errado");
	}

	$json = json_encode($msg);

	echo $json;
    
?>
