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
						<a href="eventos-inscritos.html">Meus Eventos</a>
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
		var teste = `
			<div class="autenticado">
				<h1> Usuário nao autenticado</h1>
				</br>
				<p>Por favor prossiga para a autenticacao <a href="autentica.html">Entrar</a></p>
			</div>`;

		document.getElementById("corpo").innerHTML = teste;
	}

}


async function Gravar(){

    var form = document.getElementById('cadastra-forms');
    var file = document.getElementById('file').files;
    var dados = new FormData(form);
    dados.append('arquivo', file[0]);
    console.log(dados);
    var promise = await fetch('../php/gravar-evento.php', {
        method: 'POST',
        body: dados
    });

var resposta = await promise.json();


var template = `<a>${resposta[1]}</a>`;

document.getElementById('resposta').innerHTML = template;

}
