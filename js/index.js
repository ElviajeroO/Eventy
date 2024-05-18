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
					<a href="paginas/cadastra.html">Cadastrar</a>
					<a href="paginas/autentica.html">Entrar</a>
			</div>
		</div>`;
	
	document.getElementById("cabecalho").innerHTML = card;
}
