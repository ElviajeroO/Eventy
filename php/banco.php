<?php 
	require "../vendor/autoload.php";
	include "../php/pegachave.php";
	include_once "./phpmailer.php";
	
	function cadastra_user($email, $senha, $codigo_aut){
		
		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);
	
		$select = "SELECT email FROM users WHERE email='$email'";

		$res = mysqli_query($connection, $select);

		$res =  mysqli_num_rows($res);

		if($res === 0){

			$authenticator = new PHPGangsta_GoogleAuthenticator();

			$secret = $authenticator->createSecret();

			$website = 'http://Eventy.com';

			$title= 'Eventy';

			$qrCodeUrl = $authenticator->getQRCodeGoogleUrl($title, $secret);

			$cp = extract_from_image("../img/porco.png");

			$teste = preg_split("/[;]/",$cp);

			$query = "INSERT INTO users (email, senha ,codconfirmacao, otp) VALUES ('$email', '$senha', '$codigo_aut', '$secret')";
				
		
			$res = mysqli_query($connection, $query);
				
			if($res){
				array_push($msg, "1");
				array_push($msg, $qrCodeUrl);
				mandar($email, $codigo_aut);

			}else{
				array_push($msg, "0");
				array_push($msg, "Erro de inserção");
			}
			return $msg;
		}else{
			array_push($msg, "0");
			array_push($msg, "email repetido");

			return $msg;
		}
	}

	function confirma_user($email, $codconfirmacao){

		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);

		$select = "SELECT codconfirmacao FROM users WHERE email = '$email'";

		$resultado = mysqli_query($connection, $select);

		$tourrow = mysqli_fetch_assoc($resultado);
		$codconfirmacao2 = intval($tourrow['codconfirmacao']); 
		$codconfirmacao = intval($codconfirmacao);

		if ($codconfirmacao == $codconfirmacao2) {

			if(session_status() !== PHP_SESSION_ACTIVE){
				session_start();
			}else{
				session_destroy();
				session_start();
			}

			$_SESSION["email"] = $email;
			$_SESSION["autenticado"] = 1;

			$id = session_id();

			$update = "UPDATE users SET confirmado=1, cookie='$id' WHERE email = '$email' AND codconfirmacao = '$codconfirmacao'";

			$resultado2 = mysqli_query($connection, $update);
			
			array_push($msg,"1");
			array_push($msg,"Codigo autorizado");

		}
		else{  
			array_push($msg, "0");
			array_push($msg, "Codigo errado");
		}

		return $msg;
	}

	function verifica_session($id){	

		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);

		$select = "SELECT cookie FROM users WHERE cookie='$id'";

		$res = mysqli_query($connection, $select);

		$res = mysqli_num_rows($res);

		if($res == 1){
			if(isset($_SESSION["autenticado"])){

				array_push($msg, "1");
				array_push($msg, "Sessão autenticada");
				array_push($msg, $id);

			}else{
				array_push($msg, "0");
				array_push($msg, "sessão não autenticada");
			}
		}else{
			array_push($msg, "0");
			array_push($msg, "sessão inexistenten");
		}

		return $msg;
	}

	function autentica_user($email, $senha){

		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);
		
		$select = "SELECT senha, otp FROM users WHERE email = '$email' and senha = '$senha' and confirmado = 1";
		$res = mysqli_query($connection, $select);

		$res =  mysqli_num_rows($res);

		if ($res == 1){
			array_push($msg, "1");
			array_push($msg, "usuario correto");
		}else {
			array_push($msg, "0");
			array_push($msg, "usuario incorreto");
		}

		return $msg;
	
	}

	function verifica_2fa($email, $otp){ 

		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);

		$select = "SELECT otp FROM users WHERE email = '$email' and confirmado = 1";
		$resultado = mysqli_query($connection, $select);

		$tourrow = mysqli_fetch_assoc($resultado);
		$secret = $tourrow['otp']; 

		$authenticator = new PHPGangsta_GoogleAuthenticator();

		$tolerance = 1;	

		$checkResult = $authenticator->verifyCode($secret, $otp, $tolerance);    

		if ($checkResult) 
		{

			$_SESSION["email"] = $email;
			$_SESSION["autenticado"] = 1;

			$id = session_id();
			$update = "UPDATE users SET cookie='$id' where email='$email' and confirmado='1'";
			mysqli_query($connection, $update);

			array_push($msg, $_SESSION['autenticado']);
			array_push($msg, 'autenticado');	

		} else {
			array_push($msg, '0');
			array_push($msg, 'codigo errado');	
		}

		return $msg;

	}

	function recupera_senha($email, $codigo_aut){
		
		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);

		$select = "SELECT email FROM users WHERE email='$email'";

		$update = "UPDATE users SET codsenha='$codigo_aut' where email='$email'";
		
		if(mysqli_num_rows(mysqli_query($connection, $select)) === 1){
			if(mysqli_query($connection, $update)){
			
				array_push($msg, "1");
				array_push($msg, "codigo de autenticação enviado para seu email");
				mandar($email, $codigo_aut);
			}else{
			
				array_push($msg, "0");
				array_push($msg, 'email invalido');
			}
		}else{
			array_push($msg, "0");
			array_push($msg, "Email inexistente");
		}

		return $msg;
	}

	function verifica_codsenha($email, $codconfirmacao){

		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);

		$select = "SELECT codsenha FROM users WHERE email = '$email'";

		$res = mysqli_query($connection, $select);

		$row = mysqli_fetch_assoc($res);
		$cod2 = intval($row['codsenha']);
		$codconfirmacao = intval($codconfirmacao);

		if ($codconfirmacao == $cod2) {
			array_push($msg, "1");
			array_push($msg, "Confirmado");	
		}else{
			
			array_push($msg, "0");
			array_push($msg, "Não confirmado");	
		}
		return $msg;

	}

	function recupera_senha_gravar($email, $senha){
		
		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);

		$update = "UPDATE users SET senha='$senha' WHERE email='$email'";

		if(mysqli_query($connection, $update)){
		
			array_push($msg, '1');
			array_push($msg, "senha trocada");
		}
		else{
			array_push($msg, "0");
			array_push($msg, "erro de autenticação");
		}

		return $msg;
	}

	function select_all(){

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);

		$select = "SELECT * FROM produto";
		
		$dados = array();

		$resultado = mysqli_query($connection, $select);

		while ($row = mysqli_fetch_assoc($resultado)){
			array_push($dados, $row);
		}

		return $dados;
	}

	function gravar_evento($nome, $nmax,$local, $file){ #TODO ERRO DE PERMISSÃO

		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);
		
		if (empty($nome)||empty($nmax)||empty($local)||empty($file)){
			array_push($msg, "0");
			array_push($msg, "Preencha todos os campos");	
		}else{

			$abab = $connection->query("SELECT MAX(num) AS max_num FROM produto WHERE nome ='$nome'");
			$row = $abab->fetch_assoc();
			$num = $row['max_num'] + 1; // Incrementa o valor de `num` em 1

			$query = "INSERT INTO produto (nome, nmax, num, local) VALUES('$nome', '$nmax',$num, '$local')";
			mysqli_query($connection, $query);
			$novo = "../img/".$nome;
		    	move_uploaded_file($file["tmp_name"], $novo);
			array_push($msg, "1");
			array_push($msg, "Evento inserido com sucesso");
		}

		return $msg;
	}

	function inscrever_evento($id_produto){
		
		$msg = array();
 
		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);

		$insert = "INSERT INTO carrinho_produto (id_carrinho, quantidade, id_produto) VALUES(1, 1, '$id_produto')";

		$insert2 = "SELECT * FROM carrinho_produto WHERE quantidade > 0 and id_produto = '$id_produto'";
		

		$insert3 = "UPDATE produto SET num = num + 1 WHERE id = '$id_produto'";
		if(mysqli_query($connection, $insert3)){
			array_push($msg, "1");
			array_push($msg, "numero de pessoas aumentado com sucesso");
		}else{
			array_push($msg, "0");
			array_push($msg, "deu ruim time");
		}


		if(mysqli_num_rows(mysqli_query($connection, $insert2)) === 0){
			if(mysqli_query($connection, $insert)){
				array_push($msg, "1");
				array_push($msg, "Inscrito no evento");
			}
		}else{
			array_push($msg, "0");
			array_push($msg, "erro,a ja inscrito no evento");
		}

		return $msg;
	} 

	function carrega_eventos(){

		$msg = array();

		$cp = extract_from_image("../img/porco.png");

		$conn = preg_split("/[;]/", $cp);

		$connection = mysqli_connect($conn[0], $conn[1], $conn[2], $conn[3]);
	
    		$select = "SELECT p.*, cp.quantidade, cp.quantidade * p.nmax AS subtotal FROM web.carrinho_produto cp INNER JOIN web.produto p ON cp.id_produto = p.id;";

		$result = mysqli_query($connection, $select);

	   	 while($res = mysqli_fetch_assoc($result)) {
	   	     array_push($msg, $res);
	   	 }

		return $msg;
	}


?>
