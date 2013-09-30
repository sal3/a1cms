<?php



// include_once '/ajax/ajax_init.php';
ini_set('session.hash_bits_per_character', 5);
include_once 'kcaptcha/kcaptcha.php';

if(isset($_REQUEST[session_name()])){
	session_start();
}

$captcha = new KCAPTCHA();

if($_REQUEST[session_name()]){
	echo $_SESSION['captcha_keystring'] = $captcha->getKeyString();
}
echo $_SESSION['captcha_keystring'];

?>