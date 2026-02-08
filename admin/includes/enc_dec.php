<?php
function encryptStringArray ($string, $key = "pikcode") {
 //$s = strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), serialize($stringArray), MCRYPT_MODE_CBC, md5(md5($key)))), '+/=', '-_,');
// return $s;
  
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'zdNtfIKuTOTxBqKSVzhvp5cbY12Nd0TP';
    $secret_iv = 'Ymxent1gI3D5bDtMY7fhQyL6unyiA2zw';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    
    return $output;
 
}

function decryptStringArray ($string, $key = "pikcode") {
 //$s = unserialize(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(strtr($stringArray, '-_,', '+/=')), MCRYPT_MODE_CBC, md5(md5($key))), "\0"));
// return $s;
  
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'zdNtfIKuTOTxBqKSVzhvp5cbY12Nd0TP';
    $secret_iv = 'Ymxent1gI3D5bDtMY7fhQyL6unyiA2zw';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
   
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
   
    return $output;
	
}

?>