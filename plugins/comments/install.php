<?

if (!defined('a1cms'))
	die('Access denied to comments!');

	//DROP TABLE IF EXISTS `{P}_online`;
	$install_query = "CREATE TABLE IF NOT EXISTS `{P}_comments` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`news_id` int(11) NOT NULL DEFAULT '0',
	`user_id` mediumint(8) NOT NULL DEFAULT '0',
	`date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`user_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
	`text` text NOT NULL,
	PRIMARY KEY (`id`),
	KEY `user_id` (`user_id`),
	FULLTEXT KEY `text` (`text`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	
	query($install_query);

?>
