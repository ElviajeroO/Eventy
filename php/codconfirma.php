<?php

	include "../php/pegachave.php";
	$codconfirmacao2 = $_POST['codconfimacao'];
	$email = $_POST['email'];

	$msg = array();

	unset($_COOKIE["Eventy"]);

	session_name("Eventy");
	session_set_cookie_params((60*5),"/");

	$cp = extract_from_image("../img/porco.png");

    	$teste = preg_split("/[;]/",$cp);

	$connection = mysqli_connect($teste[0], $teste[1], $teste[2], $teste[3]);

	$query = "SELECT codconfirmacao FROM users WHERE email = '$email'";
	$resultado = mysqli_query($connection, $query);
	

	$tourrow = mysqli_fetch_assoc($resultado);
	$tourcodconfirmacao = $tourrow['codconfirmacao']; 
	$tourcodconfirmacao = intval($tourcodconfirmacao);
	$codconfirmacao2 = intval($codconfirmacao2);

	if ($codconfirmacao2 == $tourcodconfirmacao) {

		if(session_status() !== PHP_SESSION_ACTIVE){
			session_start();
		}else{
			session_destroy();
			session_start();
		}

		$_SESSION["email"] = $email;
		$_SESSION["autenticado"] = 1;

		$id = session_id();

       		$query2 = "UPDATE users SET confirmado=1, cookie='$id' WHERE email = '$email' AND codconfirmacao = '$codconfirmacao2'";
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
