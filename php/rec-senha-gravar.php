<?php
	include "../php/phpmailer.php";

	include "../php/pegachave.php";

	$email = $_POST['email'];
	$senha1 = $_POST['senha1'];
	$senha2 = $_POST['senha2'];

	$cp = extract_from_image("../img/porco.png");

    	$teste = preg_split("/[;]/",$cp);

	$conn = new PDO("mysql:host=$teste[0];dbname=$teste[3]", $teste[1], $teste[2]);

	$pattern = '/.*@.*\..*/';

	$msg = array();

	$json = 0;

	if(preg_match($pattern, $email)){
		if($senha1 == $senha1){
  			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE users SET senha='$senha1' WHERE email='$email'";
  			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$res = $stmt->rowCount();

			if($res == 1){
				array_push($msg, '1');
				array_push($msg, "senha trocada");
			}
			else{
				array_push($msg, "0");
				array_push($msg, "erro de autenticação");
			}
		}
		else{
			array_push($msg, "0");
			array_push($msg, "senha errada");
		}
	}
	else{
		array_push($msg, "0");
		array_push($msg, "email errado");
	}

	$json = json_encode($msg);

	echo $json;
    
?>
