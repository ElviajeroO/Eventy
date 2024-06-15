window.onload = async function(){
	
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
						<a href="../index.html">Pagina Principal</a>
				</div>
			</div>`;
		
		document.getElementById("cabecalho").innerHTML = cabecalho;
		var promise = await fetch("../php/carrega_carrinho.php", {
			method: "GET"
		});

		var carrinho = await promise.json();

		for(var i = 0; i < carrinho.length; i++) {
        	//Template string para a descrição do produto
			var template =
			`<div class="descricao-conteudo">
				<div class="descricao-img">
					<img src="../upload/${carrinho[i].nome}" />
				</div>
			
				<div class="descricao-texto">
					Nome: ${carrinho[i].nome}

				</div>
			
			</div>`
		
			document.getElementById('descricao').innerHTML += template;

        	//Template string para a quantidade do produto
			template = 
			`<div class="quantidade-input">

				${carrinho[i].local}

			</div>`

			document.getElementById('quantidade').innerHTML += template;

        	//Template string para o preço do produto
			template =
			`<div class="preco-texto">
				Nmax: ${parseFloat(carrinho[i].nmax)}
			</div>`

			document.getElementById('preco').innerHTML += template;

			//Template string para o subtotal da compra
			template =
			`<div class="subtotal-texto">
				Desc: ${carrinho[i].num}

			</div>`

			document.getElementById('subtotal').innerHTML += template;
		}

		if(carrinho.length > 0) {

		}

		else {
			var template = 
			`<div class="finalizar-aviso">
				<h2>
					Você não possui nenhum item na sua lista de eventos.
				</h2>
				<a href="../index.html" class="aviso-button">
					<button>
						Retornar à pagina
					</button>
				</a>
			</div>`

			document.getElementById('finalizar').innerHTML = template;
		}
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
		var teste = `
			<div class="autenticado">
				<h1> Usuário nao autenticado</h1>
				</br>
				<p>Por favor prossiga para a autenticacao <a href="autentica.html">Entrar</a></p>
			</div>`;

		document.getElementById("corpo").innerHTML = teste;
	}
}
