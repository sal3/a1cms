<?

if (!defined('a1cms'))
	die('Access denied to online!');

	//DROP TABLE IF EXISTS `{P}_online`;
	$install_query = "CREATE TABLE IF NOT EXISTS `{P}_online` (
	`user_id` varchar(11) NOT NULL,
	`user_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
	`ip` varchar(34) NOT NULL,
	`time` varchar(20) NOT NULL,
	`user_group` varchar(11) NOT NULL DEFAULT 'unknown',
	PRIMARY KEY (`ip`)
	) ENGINE=MEMORY DEFAULT CHARSET=utf8;";
	query($install_query) or $error[] = "Ошибка инсталляции _online";

?>
