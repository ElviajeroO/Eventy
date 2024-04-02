<?php
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	
	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "INSERT INTO users (email, senha) VALUES ('$email', '$senha')";
	mysqli_query($connection, $query);
?>
