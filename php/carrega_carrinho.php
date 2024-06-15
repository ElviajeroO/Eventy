<?php

	include_once "./banco.php";
    $dados = array();

    $dados = carrega_eventos();

    $dados_json = json_encode($dados);

    echo $dados_json;
?>
