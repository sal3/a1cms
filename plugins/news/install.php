<?

if (!defined('a1cms'))
	die('Access denied!');

	//DROP TABLE IF EXISTS `{P}_online`;
	$install_query1 = "
		CREATE TABLE IF NOT EXISTS `{P}_news` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`user_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
		`date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		`createdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		`poster` varchar(255) NOT NULL,
		`short_text` text NOT NULL,
		`full_text` text NOT NULL,
		`title` varchar(255) NOT NULL DEFAULT '',
		`description` varchar(200) NOT NULL DEFAULT '',
		`keywords` text NOT NULL,
		`category_id` varchar(200) NOT NULL DEFAULT '0',
		`url_name` varchar(200) NOT NULL DEFAULT '',
		`comments_quantity` smallint(5) unsigned NOT NULL DEFAULT '0',
		`allow_comments` tinyint(1) NOT NULL DEFAULT '1',
		`show_on_main` tinyint(1) unsigned NOT NULL DEFAULT '1',
		`approved` tinyint(1) NOT NULL DEFAULT '0',
		`pinned` tinyint(1) NOT NULL DEFAULT '0',
		`views` mediumint(8) unsigned NOT NULL DEFAULT '0',
		`editdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		`editor` varchar(40) NOT NULL DEFAULT '',
		`edit_reason` varchar(255) NOT NULL DEFAULT '',
		`tags` varchar(255) NOT NULL DEFAULT '',
		`on_moderation` tinyint(4) NOT NULL,
		`approver` varchar(40) NOT NULL,
		PRIMARY KEY (`id`),
		KEY `autor` (`user_name`),
		KEY `alt_name` (`url_name`),
		KEY `category` (`category_id`),
		KEY `approve` (`approved`),
		KEY `allow_main` (`show_on_main`),
		KEY `date` (`date`),
		KEY `comm_num` (`comments_quantity`),
		KEY `tags` (`tags`),
		FULLTEXT KEY `title` (`title`),
		FULLTEXT KEY `short_story` (`short_text`,`full_text`,`title`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	query($install_query1) or $error[] = "Ошибка инсталляции _news";

	
	$install_query2 = "
		CREATE TABLE IF NOT EXISTS `fb_views` (
		`id` mediumint(8) NOT NULL AUTO_INCREMENT,
		`news_id` int(11) NOT NULL DEFAULT '0',
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;";
	query($install_query2) or $error[] = "Ошибка инсталляции _views";
?>
