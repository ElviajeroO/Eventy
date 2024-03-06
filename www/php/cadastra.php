<?php
	$email = $_POST['email'];
	$senha1 = $_POST['senha1'];
	$senha2 = $_POST['senha2'];
	
	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	if(preg_match("/@gmail.com\z/", $email, $matches)){
		if($senha1 == $senha2){
			$query = "INSERT INTO users (email, senha) VALUES ('$email', '$senha1')";
			mysqli_query($connection, $query);
			echo "funfo";
		}
		else{
			echo"senhas diferentes";
		}
	} else{
	}
?>
