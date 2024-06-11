<?php

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');

	$query = 'SELECT * FROM produto;';


	$resultado = mysqli_query($connection, $query);
	
	$dados = array();
	
	while ($row = mysqli_fetch_assoc($resultado)){
		array_push($dados, $row);
	}

	$json = json_encode($dados);
	echo $json;

?>