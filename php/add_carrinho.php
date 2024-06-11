<?php 

	$id = $_POST['id_produto'];

	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	
	$query = "INSERT INTO carrinho_produto (id_carrinho, quantidade, id_produto) VALUES(1, 1, {$id})";

	mysqli_query($connection, $query);

	echo 'Produto Adicionado ao Carrinho';
?>