var email;
window.onload = async function pagina(){
	
	var promise = await fetch('../php/session.php',{
		method:'GET'
	});

	var cod = await promise.json();
	
	if (cod[0] == 1){
		var cabecalho = `
				<div class="cabecalho">
					<div class="name">
						<h1><a href="../index.html">Eventy</a></h1>
					</div>
					<div class="bar">
						<input type="text" placeholder="Nome do evento"></input>
					</div>
					<div class="links">
							<a href="cadastra.html">Cadastrar</a>
							<a href="eventos-inscritos.html">Meu perfil</a>
							<a onclick="deslogar()">Sair</a>
					</div>
				</div>
			</div>`;
		
		document.getElementById("cabecalho").innerHTML = cabecalho;
		var teste = `
			<div class="autenticado">
				<h1> Usuário já autenticado</h1>
				</br>
				<p>Por favor prossiga para a <a href="../index.html">pagina Inicial</a></p>
			</div>`;

		document.getElementById("corpo").innerHTML = teste;
	}else{
		var card = `
			<div class="cabecalho">
				<div class="name">
					<h1><a href="../index.html">Eventy</a></h1>
				</div>
				<div class="bar">
					<input type="text" placeholder="Nome do evento"></input>
				</div>
				<div class="links">
						<a href="cadastra.html">Cadastrar</a>
						<a href="autentica.html">Entrar</a>
				</div>
			</div>`;
		
		document.getElementById("cabecalho").innerHTML = card;
	}

}

async function Autentica(){
	var s1 = CryptoJS.SHA256(document.getElementById('senha').value);
	email = document.getElementById('email').value;
	
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	dados.append('senha', s1.toString(CryptoJS.enc.Base64));
	dados.append('email', email);

	var formDataObject = {};

	dados.forEach(function(value, key){
		formDataObject[key] = value;
	});
	
	const encryptedData = encryptWithSecretKey(formDataObject, 'd6e0422cef85a338055b5a4a485eecb1' );


	var promise = await fetch('../php/autentica.php',{
		method:'POST',
            	headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify({
			iv:encryptedData.iv,
			data:encryptedData.data
		})
	});

	var resposta = await promise.json();

	window.alert(resposta[1]);

	if(resposta[0] == "1"){
		var card = `
			<div class='titulo_cadastro'>
				<h1> Digite o código do Google Authenticator</h1>
			</div>
			<br>
                        <input type="text" class="input_cadastro" id="otp" name='otp' placeholder="Digite o codigo do authenticador">
                        <br>
                        <button type="button" onclick="FA()">Autenticar</button>
                        <br>`;
		
		document.getElementById('form_cadastro').innerHTML = card;
	}
}

async function FA(){
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	dados.append('email', email);
	dados.append('otp', document.getElementById('otp').value);

	var formDataObject = {};
	dados.forEach(function(value, key){
		formDataObject[key] = value;
	});

	const encryptedData = encryptWithSecretKey(formDataObject, 'd6e0422cef85a338055b5a4a485eecb1' );

	var promise = await fetch('../php/verifica-2fa.php', {
		method:'POST',
            	headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify({
			iv:encryptedData.iv,
			data:encryptedData.data
		})
	});
	
	var resposta = await promise.json();

	window.alert(resposta[1]);

	window.location.href="../index.html";
}
async function deslogar(){

	var promise = await fetch('../php/deslogar.php', {
		method:"POST"
	});
	
	window.location.href="../index.html";
}

function encryptWithSecretKey(data, secretKey) {

    const dataString = JSON.stringify(data);
    
    const iv = CryptoJS.lib.WordArray.random(16);
    
    const encrypted = CryptoJS.AES.encrypt(dataString, CryptoJS.enc.Hex.parse(secretKey), {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7
    });
    
    const result = {
        iv: iv.toString(CryptoJS.enc.Hex),
        data: encrypted.toString()
    };

	console.log(result);

    return result;
}
