<?php
	$codconfirmacao2 = $_POST['codconfimacao'];
	$email = $_POST['email'];

	$msg = array();

	session_name("Eventy");
	session_set_cookie_params((60*5),"/");

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT codconfirmacao FROM users WHERE email = '$email'";
	$resultado = mysqli_query($connection, $query);
	

	$tourrow = mysqli_fetch_assoc($resultado);
	$tourcodconfirmacao = $tourrow['codconfirmacao']; 
	$tourcodconfirmacao = intval($tourcodconfirmacao);
	$codconfirmacao2 = intval($codconfirmacao2);

	if ($codconfirmacao2 == $tourcodconfirmacao) {

		session_start();

		$_SESSION["email"] = $email;
		$_SESSION["autenticado"] = 1;

		if(isset($_COOKIES["Eventy"])){
			$id= $_COOKIES["Eventy"];
		}else{
			$id="test";
		}

       		$query2 = "UPDATE users SET confirmado= 1 and cookie='$id' WHERE email = '$email' AND codconfirmacao = '$codconfirmacao2'";
       		$resultado2 = mysqli_query($connection, $query2);
		
		array_push($msg,"1");
		array_push($msg,"Codigo autorizado");

	}
	else{  
		array_push($msg, "0");
		array_push($msg, "Codigo errado");
	}

	$json = json_encode($msg);

	echo $json;
?>
