var email;
window.onload = async function pagina(){
	
	var cabecalho = `
		<div class="cabecalho">
			<div class="name">
				<h1>Eventy</h1>
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
	var promise = await fetch('../php/session.php',{
		method:'GET'
	});

	var cod = await promise.json();

	
	if (cod[0] == 1){
		var teste = `
			<div class="autenticado">
				<h1> Usuário já autenticado</h1>
				</br>
				<p>Por favor prossiga para a <a href="../index.html">pagina Inicial</a></p>
			</div>`;

		document.getElementById("corpo").innerHTML = teste;
	}

}

async function Autentica(){
	var s1 = CryptoJS.SHA256(document.getElementById('senha').value);
	email = document.getElementById('email').value;
	
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	dados.append('senha', s1.toString(CryptoJS.enc.Base64));

	var promise = await fetch('../php/autentica.php',{
		method:'POST',
		body:dados
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

	var promise = await fetch('../php/verifica-2fa.php', {
		method:'POST',
		body:dados
	});
	
	var resposta = await promise.json();


	if(resposta[0] == '1'){
		await window.alert(resposta[1]);

		window.location.href = "../index.html";
	}
}
