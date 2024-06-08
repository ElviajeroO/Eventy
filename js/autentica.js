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
	
	if (cod == 1){
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
	
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	dados.append('senha', s1.toString(CryptoJS.enc.Base64));

	var promise = await fetch('../php/autentica.php',{
		method:'POST',
		body:dados
	});
	console.log(s1.toString(CryptoJS.enc.Base64));

	window.location.reload();

}
