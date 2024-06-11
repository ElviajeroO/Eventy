<?php 
	
	$msg = array();
	
	session_name("Eventy");
	session_set_cookie_params((60*5),"/");

	session_start();

	if(isset($_SESSION["autenticado"])){

		array_push($msg, "1");
		array_push($msg, "Sessão autenticada");
		array_push($msg, $_COOKIE["Eventy"]);

	}else{
		array_push($msg, "sessão não autenticada");
	}
	
	$json = json_encode($msg);

	echo $json;

?>
