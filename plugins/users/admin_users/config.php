<?php

if (!defined('a1cms'))
	die('Access denied!');

$plugin_list['admin_users']=array (
  'title' => 'Управление пользователями',
  'version' => '0.1',
  'site' => '',
  'cat' => 'users',
  'priority' => 1000,
  'install_state' => '2',
  'state' => 1,
  'allowed_groups' =>
  array (
    0 => 1,
    1 => 2,
  ),
  'icon' => 'group.png',
  'allowed_users' =>
  array (
    0 => '',
  ),
);

$users_menu=array(
	array(
	'pluginname'=>'admin_users',
	'title'=>'Добавить',
	'get_params'=>'&undermod=add',
	'position'=>10,
	'icon'=>"<i class='fam-user-add'></i>",
	),
	array(
	'pluginname'=>'admin_users',
	'title'=>'Группы',
	'get_params'=>'&undermod=groups',
	'position'=>20,
	'icon'=>"<i class='fam-group'></i>",
	),
	array(
	'pluginname'=>'admin_users',
	'title'=>'Поиск',
	'get_params'=>'&undermod=search',
	'position'=>30,
	'icon'=>"<i class='fam-magnifier'></i>",
	)
);
$admin_menu=@array_merge($admin_menu,$users_menu);




?>
