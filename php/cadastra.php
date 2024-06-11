<?php
	require "../vendor/autoload.php";
	include "../php/phpmailer.php";

	include "../php/pegachave.php";

	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$msg = array();

    	$codigo_aut = abs(random_int(-9999, 9999));

	mandar($email, $codigo_aut);

	$authenticator = new PHPGangsta_GoogleAuthenticator();

	$secret = $authenticator->createSecret();

	$website = 'http://Eventy.com';

	$title= 'Eventy';

	$qrCodeUrl = $authenticator->getQRCodeGoogleUrl($title, $secret);

	$cp = extract_from_image("../img/porco.png");

    	$teste = preg_split("/[;]/",$cp);

	$connection = mysqli_connect($teste[0], $teste[1], $teste[2], $teste[3]);

	$query = "SELECT email FROM users WHERE email='$email'";

	$resultado = mysqli_query($connection, $query);
	
	$res =  mysqli_num_rows($resultado);

	if($res > 0){
		array_push($msg, "0");
		array_push($msg, "Email existente");

	}else{
	
		$query = "INSERT INTO users (email, senha ,codconfirmacao, otp) VALUES ('$email', '$senha', '$codigo_aut', '$secret')";

		mysqli_query($connection, $query);

		array_push($msg, $secret);

		array_push($msg, $qrCodeUrl);
	}


	$json = json_encode($msg);

	echo $json;

?>
