<?php
require_once('ecryption_config.php'); 
function encrypt($string){
	$ouput = false;
	$key = hash('sha256', SECRET_KEY);
	$iv = substr(hash('sha256', SECRET_IV), 0,16);
	$ouput = openssl_encrypt($string, METHOD, $key, 0, $iv);
	$ouput = base64_encode($ouput);
	return $ouput;
}
?>