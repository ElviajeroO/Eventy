function Cadastrar(){
	var senha1 = document.getElementById('senha1').value;
	var senha2 = document.getElementById('senha2').value;
	email = document.getElementById('email').value;
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);

	const regex0 = /\W|_/;
	const regex1 = /[A-Z]/;
	const regex2 = /[0-9]/;
	const regex3 = /[a-z]/;
	const regex4 = /.*@.*\..*/;

	if (regex4.test(email)) {
		if (senha1 == senha2) {
			if ( (regex0.test(senha1)) && (regex1.test(senha1)) && (regex2.test(senha1)) && (regex3.test(senha1)) ){
				if (senha1.length >8) {
					CadastrarTudo();
				}else{
					alert("A senha deve ter no minimo 9 caracteres");
				}
			}else{
				alert("Tenha no minimo um: Caractere especial, letra G e P, e numero");
			}
		}else {
			alert("ERRO: As duas senhas não batem");
		}
	}else {
		alert("ERRO:email fora do padrao");
	}
}

async function CadastrarTudo(){
	var s1 = CryptoJS.SHA256(document.getElementById("senha1").value);
	var s2 = CryptoJS.SHA256(document.getElementById('senha2').value);	
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);

	dados.append('senha', s1.toString(CryptoJS.enc.Base64));

	var promise = await fetch('../php/cadastra.php',{
		method:'POST',
		body:dados
	});

	var card =`	
                    <form id="form_cadastro">
                        <div class="titulo_cadastro">
                            <h1>Insira o código de autenticação</h1>
                        </div>
				<br>
        	                <input type="text" required class="input_cadastro" id="codconfirmacao" placeholder="Digite seu código de verificação" name="codconfimacao">
        	                <br>
				<br>
        	                <button type="button" onclick="autentica()">Autenticar</button>
				<br>
				<br>
				<p id='Link'>Já tem cadastro? <a href='autentica.html' id='Link'>Log In</a></p>
                    </form>`

	document.getElementById('cadastro').innerHTML = card;
}

async function autentica(){

	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	dados.append('email', email);

	var promise = await fetch('../php/codconfirma.php',{
		method:'POST',
		body:dados
	});
}

