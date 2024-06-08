<?php
	include "../php/phpmailer.php";

	$email = $_POST['email'];
	$senha1 = $_POST['senha1'];
	$senha2 = $_POST['senha2'];

	$pattern = '/.*@.*\..*/';

	$msg = array();

	$json = 0;

	if(preg_match($pattern, $email)){
		if($senha1 == $senha1){
    			$codigo_aut = abs(random_int(-9999, 9999));
			$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
			$query = "SELECT senha FROM users WHERE email = '$email' and senha = '$senha1' and confirmado = 1";
			$resultado = mysqli_query($connection, $query);
			$res =  mysqli_num_rows($resultado);

			if($res == 1){
				array_push($msg, '1');
				array_push($msg, "autenticado");
			}
			else{
				array_push($msg, "0");
				array_push($msg, "erro de autenticação");
			}
		}
		else{
			array_push($msg, "0");
			array_push($msg, "senha errada");
		}
	}
	else{
		array_push($msg, "0");
		array_push($msg, "email errado");
	}

	$json = json_encode($msg);

	echo $json;
    
?>
