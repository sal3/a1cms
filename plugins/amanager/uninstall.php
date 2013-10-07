<?php

if (!defined('a1cms'))
	die('Access denied to amanager!');

	$install_query = "DROP TABLE IF EXISTS `{P}_adv`;";
	query($install_query) or $error[] = "Ошибка удаления таблицы _adv";

?>
