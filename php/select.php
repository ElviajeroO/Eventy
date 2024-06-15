<?php
	include_once "./banco.php";

	$dados = array();
	
	$dados = select_all();

	$json = json_encode($dados);
	echo $json;

?>
