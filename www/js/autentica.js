async function Autentica(){
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);

	var promise = await fetch('php/autentica.php',{
		method:'POST',
		body:dados
	});

}
