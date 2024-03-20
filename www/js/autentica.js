async function Autentica(){
	var s1 = CryptoJS.SHA256(document.getElementById('senha'));
	
	var form = document.getElementById('form_cadastro');
	var dados = new FormData(form);
	dados.append('senha', s1.toString(CryptoJS.enc.Base64));

	var promise = await fetch('php/autentica.php',{
		method:'POST',
		body:dados
	});
	console.log(s1.toString(CryptoJS.enc.Base64));

}
