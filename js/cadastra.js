var email;
var secretkey;
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
	}else{
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
						<a href="autentica.html">Entrar</a>
				</div>
			</div>`;
		
		document.getElementById("cabecalho").innerHTML = cabecalho;
	}

}

function Cadastrar(){
	var senha1 = document.getElementById('senha1').value;
	var senha2 = document.getElementById('senha2').value;
	email = document.getElementById('email').value;
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);

	const regex0 = /\W|_/;
	const regex1 = /[A-Z]/;
	const regex2 = /[0-9]/;
	const regex3 = /[a-z]/;
	const regex4 = /.*@.*\..*/;

	if (regex4.test(email)) {
		if (senha1 == senha2) {
			if ( (regex0.test(senha1)) && (regex1.test(senha1)) && (regex2.test(senha1)) && (regex3.test(senha1)) ){
				if (senha1.length >8) {
					CadastrarTudo();
				}else{
					alert("A senha deve ter no minimo 9 caracteres");
				}
			}else{
				alert("Tenha no minimo um: Caractere especial, letra G e P, e numero");
			}
		}else {
			alert("ERRO: As duas senhas não batem");
		}
	}else {
		alert("ERRO:email fora do padrao");
	}
}

async function CadastrarTudo(){
	var s1 = CryptoJS.SHA256(document.getElementById("senha1").value);
	var s2 = CryptoJS.SHA256(document.getElementById('senha2').value);	
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);

	dados.append('senha', s1.toString(CryptoJS.enc.Base64));
	dados.append('email', document.getElementById("email").value);

	var formDataObject = {};

	dados.forEach(function(value, key){
		formDataObject[key] = value;
	});

	const encryptedData = encryptWithSecretKey(formDataObject, 'd6e0422cef85a338055b5a4a485eecb1' );


	var promise = await fetch('../php/cadastra.php',{
		method:'POST',
            	headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify({
			iv:encryptedData.iv,
			data:encryptedData.data
		})
	});

	var resposta = await promise.json();

	if(resposta[0]=="0"){
		
		window.alert(resposta[1]);

	}else{
		var card =`	
        	            <form id="form_cadastro">
        	                <div class="titulo_cadastro">
        	                    <h1>Insira o código de autenticação</h1>
        	                </div>
					<br>
        		                <input type="text" required class="input_cadastro" id="codconfirmacao" placeholder="Digite seu código de autenticação" name="codconfimacao">
        		                <br>
					<br>
        		                <button type="button" onclick="autentica()">Autenticar</button>
					<br>
					<br>
					<p id='Link'>Já tem cadastro? <a href='autentica.html' id='Link'>Entrar</a></p>
        	            </form>
        	       	    <div class="img">
        	       	        <img src="${resposta[1]}" alt="">
        	       	    </div>`;

		document.getElementById('cadastro').innerHTML = card;

	}
	
}

async function autentica(){
	var codigo = document.getElementById("codconfirmacao").value;

	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	
	dados.append('email', email);
	dados.append('codconfirmacao', codigo);

	var formDataObject = {};
	dados.forEach(function(value, key){
		formDataObject[key] = value;
	});

	const encryptedData = encryptWithSecretKey(formDataObject, 'd6e0422cef85a338055b5a4a485eecb1' );

	var promise = await fetch('../php/codconfirma.php',{
		method:'POST',
            	headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify({
			iv:encryptedData.iv,
			data:encryptedData.data
		})
	});

	var resposta = await promise.json();

	await window.alert(resposta[1]);

	if(resposta[0] == "1"){
		window.location.href = "../index.html";
	}

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
