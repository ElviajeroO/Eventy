<?php
    $id = $_POST['id'];
    $valor = $_POST['value'];

    $conn = mysqli_connect("localhost:3306", "root", "root", "web");

    $query = "UPDATE carrinho_produto SET quantidade = $valor WHERE id_produto = $id;";

    mysqli_query($conn, $query);

    $query = "SELECT p.preco * cp.quantidade AS subtotal FROM carrinho_produto cp INNER JOIN produto p ON cp.id_produto = p.id;";
    $resultado_query = mysqli_query($conn, $query);
    $dados = array();

    while($resultado = mysqli_fetch_assoc($resultado_query)) {
        array_push($dados, $resultado);
    }

    $dados_json = json_encode($dados);
    echo $dados_json;
?>