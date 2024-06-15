<?php
	include "../php/banco.php";

	$codconfirmacao = $_POST['codconfimacao'];
	$email = $_POST['email'];

	$msg = array();

	unset($_COOKIE["Eventy"]);

	session_name("Eventy");
	session_set_cookie_params((60*5),"/");
	session_start();

	$msg = confirma_user($email, $codconfirmacao);

	$json = json_encode($msg);

	echo $json;
?>
