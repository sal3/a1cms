<?php

if (!defined('a1cms'))
	die('Access denied to amanager!');

	$install_query = "CREATE TABLE IF NOT EXISTS `{P}_adv` (
	`id` smallint(5) NOT NULL AUTO_INCREMENT,
	`name` varchar(40) NOT NULL DEFAULT '',
	`description` varchar(200) NOT NULL DEFAULT '',
	`code` text NOT NULL,
	`enabled` tinyint(1) NOT NULL DEFAULT '0',
	`show_for` varchar(100) NOT NULL DEFAULT 'all',
	`show_on` tinyint(1) NOT NULL COMMENT '0,пусто-везде, 1-на главной, 2-в категории, 3-в новости',
	`block` tinyint(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	query($install_query) or $error[] = "Ошибка создания таблицы _adv";

?>
