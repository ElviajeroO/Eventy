var email;
window.onload = function pagina(){
	var card = `
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
	
	document.getElementById("cabecalho").innerHTML = card;
}

async function Trocar(){
	var senha1 = CryptoJS.SHA256(document.getElementById('senha1').value);
	var senha2 = CryptoJS.SHA256(document.getElementById('senha2').value);
	email = document.getElementById('email').value;
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	
	dados.append('senha1', senha1.toString(CryptoJS.enc.Base64));
	dados.append('senha2', senha2.toString(CryptoJS.enc.Base64));

	var promise = await fetch('../php/trc-senha.php',{
		method:'POST',
		body:dados
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

	var promise = await fetch('../php/trc-senha-gravar.php',{
		method:'POST',
		body:dados
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
