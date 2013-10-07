<?
if (!defined('a1cms')) 
	die('Access denied to auth_check.php!');

if((!isset($_SESSION['user_id']) or !$_SESSION['user_id']) and isset($_COOKIE['user_name']) and $_COOKIE['user_name'] and isset($_COOKIE['sessid']) and $_COOKIE['sessid'])
{
	
	include_once 'auth-function.php';
	fauthority($_COOKIE['user_name'], false, $_COOKIE['sessid']);
}

?>