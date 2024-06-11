<?php
    $conn = mysqli_connect("localhost:3306", "root", "root", "web");
    
    $query = "DELETE FROM carrinho_produto WHERE quantidade = 0;";
    mysqli_query($conn, $query);

    echo '';
?>