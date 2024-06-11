<?php
	include "../php/pegachave.php";

	$codconfirmacao = $_POST['codigo'];
	$email = $_POST['email'];

	$msg = array();

	$json = 0;

	$cp = extract_from_image("../img/porco.png");

    	$teste = preg_split("/[;]/",$cp);

	$connection = mysqli_connect($teste[0], $teste[1], $teste[2], $teste[3]);

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
