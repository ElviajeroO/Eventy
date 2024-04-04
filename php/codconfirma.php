<?php
	$codconfirmacao2 = $_POST['codconfimacao'];
	$email = $_POST['email'];

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT codconfirmacao FROM users WHERE email = '$email'";
	$resultado = mysqli_query($connection, $query);
	

	$tourrow = mysqli_fetch_assoc($resultado);
	$tourcodconfirmacao = $tourrow['codconfirmacao']; 
	$tourcodconfirmacao = intval($tourcodconfirmacao);
	$codconfirmacao2 = intval($codconfirmacao2);

	if ($codconfirmacao2 == $tourcodconfirmacao) {
        $connection2 = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
        $query2 = "UPDATE users SET confirmado = 1 WHERE email = '$email' AND codconfirmacao = '$codconfirmacao2'";
        $resultado2 = mysqli_query($connection2, $query2);

	}
	else{  
		echo("codigos nao batem");
	}
?>
