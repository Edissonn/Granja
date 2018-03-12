<?php 
require_once('ecryption_config.php'); 
function decrypt($string){
	$key = hash('sha256', SECRET_KEY);
	$iv = substr(hash('sha256', SECRET_IV), 0,16);

	$output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
	return $output;
}
?>