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
						<a href="paginas/eventos-inscritos.html">Meu perfil</a>
						<a onclick="deslogar()">Sair</a>
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
					<div class='card-cor'>
						<a>Nmax: ${dados[i].nmax}</a>
					</div>
						<div class='card-tam'>
							<a>Inscritos: ${dados[i].num}</a>
						</div>
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

	var promise = await fetch('php/add_carrinho.php', {
		method:'POST',
		body: dados
	});
	
	var resposta = await promise.json();

	window.location.reload();
}
 
async function deslogar(){

	var promise = await fetch('php/deslogar.php', {
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
