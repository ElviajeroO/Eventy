<?php
	$senha0 = $_POST['senha0'];
	$senha1 = $_POST['senha1'];
	$senha2 = $_POST['senha2'];

    if (!$senha0 || !$senha1 || !$senha2) {
        echo 'Os campos devem ser preenchidos'; 
    }
    else if ($senha1 != $senha2){
            echo "senhas novas nao batem";
        
    } 
    else{
        echo "foi";
    }
    
?>
