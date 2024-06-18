<?php 
	
	include_once "./banco.php";

 
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

		$nome = $formData['nome'];
		$nmax = $formData['nmax'];
		$local = $formData['local'];
		$file = $formData['arquivo'];
        }

	$msg = gravar_evento($nome,$nmax,$local,$file);

	$json = json_encode($msg);

	echo $json;

?>
