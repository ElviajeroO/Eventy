<?php 

	session_start();
	
	$encode = array();	

	$json = 0;

	if(isset($_SESSION["tempo"])){
		$tempodevida = time() - $_SESSION["tempo"];
		if($tempodevida > 520){
			session_unset();
			session_destroy();
			session_start();
			$_SESSION["autenticado"] = 0;
			array_push($encode, $_SESSION["autenticado"]);
			$json = json_encode($encode);
		}	
	}else{
		$_SESSION["tempo"] = time();
	
		$email = $_SESSION["email"];
		$senha = $_SESSION["senha"];
	
		$connection = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'web');
		$query = "SELECT senha FROM users WHERE email = '$email' and senha = '$senha' and confirmado = 1";
		$resultado = mysqli_query($connection, $query);
		
		$res =  mysqli_num_rows($resultado);
	
		if ($res == 1){
			$_SESSION["autenticado"] = 1;
			array_push($encode, $_SESSION["autenticado"]);
			$json = json_encode($encode);
			}
		else {
			$_SESSION["autenticado"] = 0;
			array_push($encode, $_SESSION["autenticado"]);
			$json = json_encode($encode);
		}
	}

	echo $json

?>
