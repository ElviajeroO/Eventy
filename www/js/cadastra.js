function Cadastrar(){
	var senha1 = document.getElementById('senha1').value;
	var senha2 = document.getElementById('senha2').value;
	var email = document.getElementById('email').value;

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
	alert("chegamos ai fim");
	var form = document.getElementById('form_cadastro');
		var dados = new FormData(form);
	
		var promise = await fetch('../php/cadastra.php',{
			method:'POST',
			body:dados
		});
}
