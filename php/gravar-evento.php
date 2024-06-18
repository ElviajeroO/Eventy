<?php 
	
	include_once "./banco.php";
	
	$nome = $_POST['nome'];
	$nmax = $_POST['nmax'];
	$local = $_POST['local'];
	$file = $_FILES['arquivo'];
 
	$msg = array();

	$msg = gravar_evento($nome,$nmax,$local,$file);

	$json = json_encode($msg);

	echo $json;

?>
