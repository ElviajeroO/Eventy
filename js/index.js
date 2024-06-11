window.onload = async function pagina(){


	var promise = await fetch("php/session.php", {
		method:"POST"
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
						<a href="./paginas/cadastra.html">Cadastrar</a>
						<a href="./paginas/perfil.html">Perfil</a>
				</div>
			</div>`;
		
		document.getElementById("cabecalho").innerHTML = card;
	}else{

		var card = `
			<div class="cabecalho">
				<div class="name">
					<h1><a href="index.html">Eventy</a></h1>
				</div>
				<div class="bar">
					<input type="text" placeholder="Nome do evento"></input>
				</div>
				<div class="links">
						<a href="./paginas/cadastra.html">Cadastrar</a>
						<a href="./paginas/autentica.html">Entrar</a>
				</div>
			</div>`;
		
		document.getElementById("cabecalho").innerHTML = card;
	}
}
