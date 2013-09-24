<?
if (!defined('a1cms')) 
	die('Access denied to auth_check.php!');

if(!$_SESSION['user_id'] and $_COOKIE['user_name'] and $_COOKIE['sessid'])
{
	
	include_once 'auth-function.php';
	fauthority($_COOKIE['user_name'], false, $_COOKIE['sessid']);
}

?>