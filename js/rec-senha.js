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
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);

	var promise = await fetch('../php/rec-senha.php',{
		method:'POST',
		body:dados
	});

}
