<?php

if (!defined('a1cms'))
	die('Access denied admin_news config!');

$plugin_list['admin_news']=array (
  'title' => 'Управление новостями',
  'version' => '0.1',
  'site' => 'http://site.ru/',
  'cat' => 'content',
  'priority' => 1000,
  'install_state' => 2,
  'state' => 1,
  'icon' => 'page_gear.png',

);

// $admin_menu[]=array(
// 'pluginname'=>'admin_news',
// 'title'=>'Добавить новость',
// 'get_params'=>'',
// 'position'=>10,
// 'icon'=>"<i class='fam-page-white-add'></i>",
// );
?>
