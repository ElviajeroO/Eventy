<?php
	unset($_COOKIE["Eventy"]);
	session_name("Eventy");
	session_set_cookie_params((60*5),"/");
	session_start();
?>
