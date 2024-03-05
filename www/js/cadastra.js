async function Cadastrar(){
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);

	var promise = await fetch('../php/cadastra.php',{
		method:'POST',
		body:dados
	});

}
