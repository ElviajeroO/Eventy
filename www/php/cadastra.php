<?php
	$email = $_POST['email'];
	$username = $_POST['username'];
	$senha1 = $_POST['senha1'];
	$senha2 = $_POST['senha2'];
	
	if(preg_match("/@gmail.com\z/", $email, $matches)){
		echo "foi";
	} else{
		echo "Email errado";
	}
?>
