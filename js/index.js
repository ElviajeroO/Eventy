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
						<a href="paginas/cadastra.html">Cadastrar</a>
						<a href="paginas/eventos-inscritos.html">Meus Eventos</a>
				</div>
			</div>`;
		
		document.getElementById("cabecalho").innerHTML = card;
		var promise = await fetch("php/select.php", {
			method: 'GET',
		});
		 
		var dados = await promise.json();
		user = dados;
		console.log(dados);

		for(var i = 0; i < dados.length; i++){
			var card = 
			`<div class='card'>
				<div class='card-nome'>
					<a>${dados[i].nome}</a>
				</div>
				<div class='card-imagem'>
					<img src='upload/${dados[i].nome}'></img>
				</div>
				<div class='card-adic'>
					<div class='card-cor'><a>Nmax: ${dados[i].nmax}</a></div>
					<div class='card-tam'><a>${dados[i].num}</a></div>
				</div>
				<div class='card-valor'>
					<a>Local: ${dados[i].local}</a>
				</div>
				<div class='card-acao' onclick='AddCarrinho(${dados[i].id})'>
					<a>Inscrever no evento</a>
				</div>
			</div>`
			
			document.getElementById('produtos').innerHTML += card;
		}
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
						<a href="paginas/cadastra.html">Cadastrar</a>
						<a href="paginas/autentica.html">Entrar</a>
				</div>
			</div>`;
		
		document.getElementById("cabecalho").innerHTML = card;
		var promise = await fetch("php/select.php", {
			method: 'GET',
		});
		 
		var dados = await promise.json();
		user = dados;
		console.log(dados);

		for(var i = 0; i < dados.length; i++){
			var card = 
			`<div class='card'>
				<div class='card-nome'>
					<a>${dados[i].nome}</a>
				</div>
				<div class='card-imagem'>
					<img src='upload/${dados[i].nome}'></img>
				</div>
				<div class='card-adic'>
					<div class='card-cor'><a>${dados[i].nmax}</a></div>
						<div class='card-tam'><a>${dados[i].num}</a></div>
				</div>
				<div class='card-valor1'>
					<a>Local: ${dados[i].local}</a>
				</div>
			</div>`
			
			document.getElementById('produtos').innerHTML += card;
		}
	}


}

async function AddCarrinho(id){

	var dados = new FormData();

	dados.append('id_produto', id);

	console.log(dados);
	var promise = await fetch('php/add_carrinho.php', {
		method:"POST",
		body: dados
	});
	
	var resposta = await promise.json();


}
 
