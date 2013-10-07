<?

if (!defined('a1cms'))
	die('Access denied to admin_category!');

	$install_query = "DROP TABLE IF EXISTS `{P}_categories`;";
	query($install_query) or $error[] = "Ошибка деинсталляции _categories";

?>