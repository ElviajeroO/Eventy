<?php
	include_once "./banco.php";

	$codconfirmacao = $_POST['codigo'];
	$email = $_POST['email'];

	$msg = array();

	$msg = verifica_codsenha($email, $codconfirmacao);

	$json =json_encode($msg);
	echo $json;
?>
