var email;
window.onload = async function pagina(){
	var promise = await fetch("../php/session.php", {
		method:"GET"
	});

	var resposta = await promise.json();

	if(resposta[0] == "1"){
		var card = `
			<div class="cabecalho">
				<div class="name">
					<h1><a href="index.html">Eventy</a></h1>
				</div>
				<div class="bar">
					<input type="text" placeholder="Nome do evento"></input>
				</div>
				<div class="links">
						<a href="paginas/cadastra.html">Cadastrar</a>
						<a href="paginas/eventos-inscritos.html">Meu perfil</a>
						<a onclick="deslogar()">Sair</a>
				</div>
			</div>`;
		
		document.getElementById("cabecalho").innerHTML = card;
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

async function Trocar(){
	var senha1 = CryptoJS.SHA256(document.getElementById('senha1').value);
	var senha2 = CryptoJS.SHA256(document.getElementById('senha2').value);
	email = document.getElementById('email').value;
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	
	dados.append('senha1', senha1.toString(CryptoJS.enc.Base64));
	dados.append('senha2', senha2.toString(CryptoJS.enc.Base64));
	dados.append('email', email);

	var formDataObject = {};
	dados.forEach(function(value, key){
		formDataObject[key] = value;
	});

	const encryptedData = encryptWithSecretKey(formDataObject, 'd6e0422cef85a338055b5a4a485eecb1' );

	var promise = await fetch('../php/trc-senha.php',{
		method:'POST',
            	headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify({
			iv:encryptedData.iv,
			data:encryptedData.data
		})
	});

	var resposta = await promise.json();

	await window.alert(resposta[1]);

	if(resposta[0] == '1'){
		var form = `
			<br>
                        <input type="password" class="input_cadastro" id="senha1" placeholder="Digite a senha nova">
                        <br>
                        <input type="password" class="input_cadastro" id="senha2" placeholder="Confirme a senha nova">
                        <br>
                        <button type="button" onclick="Gravar()">Trocar</button>
                        <br>`;

		document.getElementById('form_cadastro').innerHTML = form;
	}
}

async function Gravar(){
	var senha1 = CryptoJS.SHA256(document.getElementById('senha1').value);
	var senha2 = CryptoJS.SHA256(document.getElementById('senha2').value);

	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	
	dados.append('senha1', senha1.toString(CryptoJS.enc.Base64));
	dados.append('senha2', senha2.toString(CryptoJS.enc.Base64));
	dados.append('email', email);

	var formDataObject = {};
	dados.forEach(function(value, key){
		formDataObject[key] = value;
	});

	const encryptedData = encryptWithSecretKey(formDataObject, 'd6e0422cef85a338055b5a4a485eecb1' );

	var promise = await fetch('../php/trc-senha-gravar.php',{ 
		method:'POST',
            	headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify({
			iv:encryptedData.iv,
			data:encryptedData.data
		})
	});

	var resposta = await promise.json();

	await window.alert(resposta[1]);

	if(resposta[0] == '1'){
		document.getElementById('form_cadastro').innerHTML = `
			<br>
			<h1> Senha Gravada com sucesso, proseguir para autenticação</h1>
			</br>
			<p id='Link'><a href='autentica.html'>Autenticar</a></p>`;
	}
	
}
async function deslogar(){

	var promise = await fetch('../php/deslogar.php', {
		method:"POST"
	});
	
	window.location.href="index.html";
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
