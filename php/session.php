<?php 
	
	$msg = array();

	if(isset($_COOKIE["Eventy"])){
	     array_push($msg, $_COOKIE["Eventy"]);
	}else{
		array_push($msg, "sessão não criada");
	}
	
	$json = json_encode($msg);

	echo $json;

?>
