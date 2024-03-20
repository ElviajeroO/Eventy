<?php
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT senha FROM users WHERE email = '$email' and senha = '$senha'";
	
	$resultado = mysqli_query($connection, $query);
	
	$res =  mysqli_num_rows($resultado);

	if ($res == 1){echo 'deu';} else {echo 'ndeu';}


	
?>
