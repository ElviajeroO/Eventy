<?php
	include "phpmailer.php";
	$email = $_POST['email'];
	$senha = $_POST['senha'];
    $codigo_aut = abs(random_int(-9999, 9999));
	echo($codigo_aut);

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "INSERT INTO users (email, senha ,codconfirmacao) VALUES ('$email', '$senha', '$codigo_aut')";
	mysqli_query($connection, $query);
	mandar($email, $codigo_aut);
?>
