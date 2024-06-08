<?php
	$codconfirmacao = $_POST['codigo'];
	$email = $_POST['email'];

	$msg = array();

	$json = 0;

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT codsenha FROM users WHERE email = '$email'";
	$resultado = mysqli_query($connection, $query);
	

	$row = mysqli_fetch_assoc($resultado);
	$cod2 = $row['codsenha']; 
	$cod2 = intval($cod2);
	$codconfirmacao = intval($codconfirmacao);

	if ($codconfirmacao == $cod2) {
		array_push($msg, "1");
		array_push($msg, "Confirmado");	
	}else{
		
		array_push($msg, "0");
		array_push($msg, "Não confirmado");	
	}

	$json =json_encode($msg);
	echo $json;
?>
