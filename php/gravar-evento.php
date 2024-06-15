<?php 
	
	include_once "./banco.php";

	$nome = $_POST['nome'];
	$preco = $_POST['preco'];
	$cor = $_POST['cor'];
	$tamanho = $_POST['tamanho'];
	$file = $_FILES['arquivo'];

	$msg = array();

	$msg = gravar_evento($nome,$preco,$cor,$tamanho,$file);

	$json = json_encode($msg);

	echo $json;

?>
