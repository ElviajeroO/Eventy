<?php
	include_once "./banco.php";

	$pattern = '/.*@.*\..*/';

	$msg = array();

    	$data = json_decode(file_get_contents('php://input'), true);

        $iv = hex2bin($data['iv']);
        $encryptedData = base64_decode($data['data']);
        $secretKey = hex2bin('d6e0422cef85a338055b5a4a485eecb1');

        $decryptedData = openssl_decrypt($encryptedData, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $iv);

        if ($decryptedData == False) {
            error_log('Decryption failed: ' . openssl_error_string());
            echo 'Falha ao decifrar os dados.';
        } else {
            $formData = json_decode($decryptedData, True);

            	$email = $formData['email'];
		$senha1 = $formData['senha1'];
		$senha2 = $formData['senha2'];

        }

	if(preg_match($pattern, $email)){
		if($senha1 == $senha1){

			$msg = autentica_user($email, $senha1);

		}
		else{
			array_push($msg, "0");
			array_push($msg, "senhas diferentes");
		}
	}
	else{
		array_push($msg, "0");
		array_push($msg, "email errado");
	}

	$json = json_encode($msg);

	echo $json;
    
?>
