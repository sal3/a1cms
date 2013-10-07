<?
if (!defined('a1cms'))
	die('Access denied to admin_category!');

	//DROP TABLE IF EXISTS `{P}_online`;
	$install_query = "
		CREATE TABLE IF NOT EXISTS `{P}_categories` (
		`id` smallint(5) NOT NULL AUTO_INCREMENT,
		`parentid` smallint(5) NOT NULL DEFAULT '0',
		`position` smallint(5) NOT NULL DEFAULT '1',
		`name` varchar(50) NOT NULL DEFAULT '',
		`url_name` varchar(50) NOT NULL DEFAULT '',
		`description` varchar(300) NOT NULL DEFAULT '',
		`keywords` text NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	query($install_query) or $error[] = "Ошибка инсталляции _categories";

?>
