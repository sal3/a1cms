<?php

if (!defined('a1cms'))
	die('Access denied to custom_fields!');

	$install_query1="CREATE TABLE IF NOT EXISTS `{P}_parameters` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(128) NOT NULL,
	`type` tinyint(1) NOT NULL,
	`technical` tinyint(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `name` (`name`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	query($install_query1) or $error[] = "Ошибка инсталляции _parameters";

	$install_query2="CREATE TABLE IF NOT EXISTS `{P}_parameters_relation` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`news_id` int(11) NOT NULL,
	`parameter_id` int(11) NOT NULL,
	`parameter_value_id` int(11) NOT NULL,
	`value` text NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	query($install_query2) or $error[] = "Ошибка инсталляции _parameters_relation";
	
	$install_query3="CREATE TABLE IF NOT EXISTS `{P}_parameter_set_values` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`category_id` int(11) NOT NULL,
	`parameter_id` int(11) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	query($install_query3) or $error[] = "Ошибка инсталляции _parameter_set_values";
		
	$install_query4="CREATE TABLE IF NOT EXISTS `{P}_parameter_types` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`typename` varchar(128) NOT NULL,
	`html_type` varchar(128) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `id` (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	query($install_query4) or $error[] = "Ошибка инсталляции _parameter_types";
	
	$install_query5="CREATE TABLE IF NOT EXISTS `{P}_parameter_values` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`parameter_id` int(11) NOT NULL,
	`value` varchar(128) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	query($install_query5) or $error[] = "Ошибка инсталляции _parameter_values";

?>
