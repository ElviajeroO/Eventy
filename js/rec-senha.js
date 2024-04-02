async function Trocar(){
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);

	var promise = await fetch('../php/rec-senha.php',{
		method:'POST',
		body:dados
	});

}
