<?php
	$codconfimacao = $_POST['codconfimacao'];
	$email = $_POST['email'];
	
	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	$query = "SELECT codconfirmacao FROM users WHERE email = '$email' and codconfirmacao = '$codconfimacao '";
	$resultado = mysqli_query($connection, $query);
	
	$res =  mysqli_num_rows($resultado);

	if ($res == 1){
		echo 'deu';
       	} 
	
	else {
		echo 'ndeu';
	}
?>
