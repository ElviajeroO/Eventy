<?php 
	
	$msg = array();
	
	session_name("Eventy");
	session_set_cookie_params((60*5),"/");

	session_start();

	$id = session_id();

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT cookie FROM users WHERE cookie='$id'";
	$resultado = mysqli_query($connection, $query);

	$res = mysqli_num_rows($resultado);

	if($res == 1){
		if(isset($_SESSION["autenticado"])){

			array_push($msg, "1");
			array_push($msg, "Sessão autenticada");
			array_push($msg, $id);

		}else{
			array_push($msg, "0");
			array_push($msg, "sessão não autenticada");
		}
	}else{
		array_push($msg, "0");
		array_push($msg, "sessão inexistenten");
	}


	
	$json = json_encode($msg);

	echo $json;

?>
