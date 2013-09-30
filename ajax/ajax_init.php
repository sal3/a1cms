<?php
header("Content-Type: application/json; charset=utf-8");

define('a1cms', 'energy', true);
header('Expires: ' . gmdate('r', 0));
session_cache_limiter('nocache');

if (!$_COOKIE['PHPSESSID'] or preg_match('/^[a-z0-9]{26}$/', $_COOKIE['PHPSESSID']))
	session_start();
    
$WHEREI['ajax']=true;

?>