<?php

if (!defined('a1cms'))
	die('Access denied to comments!');

$plugin_list['comments']=array (
  'title' => 'Комментарии',
  'version' => '0.1',
  'site' => '',
  'cat' => 'content',
  'priority' => 1000,
  'install_state' => 1,
  'state' => 1,
  'icon' => 'comments.png',
);
/*
$admin_menu[]=array(
'pluginname'=>'comments',
'title'=>'Комментарии',
'cat' => 'configuration',
'get_params'=>'',
'position'=>100,
'icon'=>"<i class='fam-wrench-orange'></i>",
);*/

?>