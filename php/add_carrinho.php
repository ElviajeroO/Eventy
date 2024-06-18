<?php 
	include_once "./banco.php";

	$id = $_POST['id_produto'];

	$msg = array();

	$msg = inscrever_evento($id);

	$json = json_encode($msg);

	echo $json;

?>
