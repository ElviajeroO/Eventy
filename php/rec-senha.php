
<?php
	include "../php/phpmailer.php";

	$email = $_POST['email'];

	$pattern = '/.*@.*\..*/';

	$msg = array();

	$json = 0;

	$servername = '127.0.0.1:3306';
	$username = 'root';
	$password = 'root';	
	$dbname = 'web';

	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

	if(preg_match($pattern, $email)){
		$codigo = abs(random_int(-9999,9999));

		mandar($email, $codigo);
		
  		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE users SET codsenha='$codigo' where email='$email'";
  		$stmt = $conn->prepare($sql);
		$stmt->execute();

		array_push($msg, "1");
		array_push($msg, "codigo de autenticação enviado para seu email");
	}else{
		array_push($msg, "0");
		array_push($msg, 'email invalido');
	}

	$json = json_encode($msg);

	echo $json;
    
?>
