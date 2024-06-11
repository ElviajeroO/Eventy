<?php 

	$nome = $_POST['nome'];
	$preco = $_POST['preco'];
	$cor = $_POST['cor'];
	$tamanho = $_POST['tamanho'];
	$file = $_FILES['arquivo'];


	$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
	if (empty($nome)||empty($preco)||empty($cor)||empty($tamanho)||empty($file['type']))
		echo 'Preencha todos os campos';
	else
		$query = "INSERT INTO produto (nome, preco, cor, tamanho) VALUES('$nome', '$preco', '$cor', '$tamanho')";
		mysqli_query($connection, $query);
		$novo = "../upload/".$nome;
            move_uploaded_file($file["tmp_name"], $novo);
		echo 'Imagem e produto inseridos com sucesso';
?>