<?php 
	
	include_once "./banco.php";
	$msg = array();
	
	session_name("Eventy");
	session_set_cookie_params((60*5),"/");

	session_start();

	$id = session_id();

	$msg = verifica_session($id);

	$json = json_encode($msg);

	echo $json;

?>
