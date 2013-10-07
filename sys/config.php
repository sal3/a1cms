<?php

if (!defined('a1cms'))
	die('Access denied to config.php!');

ini_set('session.hash_bits_per_character', 5);
mb_regex_encoding("UTF-8");
date_default_timezone_set('Europe/Kiev');

$engine_config=array (
  'site_title' => 'A1CMS',
  'site_short_title' => '',
  'site_description' => '',
  'site_keywords' => '',
  'charset' => 'utf-8',
  'subfolder' => '',
  'template_name' => 'juery-ui',
  'admin_template_name' => 'ant',
  'cache_enable' => false,
  'avatar_dir_config' => '/uploads/avatar',
  'images_dir_config' => '/uploads/images',
  'cache_dir_config' => '/cache',
  'new_news_instruction_link' => '',
  'http_photohost_name_regexp' => '',
  'photohost_name' => '',
  'smiles' => 
  array (
    0 => 'am',
    1 => 'angry',
    2 => 'belay',
    3 => 'bully',
    4 => 'crying',
    5 => 'feel',
    6 => 'fellow',
    7 => 'laughing',
    8 => 'lol',
    9 => 'love',
    10 => 'no',
    11 => 'recourse',
    12 => 'request',
    13 => 'yahoo',
    14 => 'greeting',
    15 => 'bye2',
    16 => 'drinks',
    17 => 'sad',
    18 => 'smile',
    19 => 'tongue',
    20 => 'wassat',
    21 => 'what',
    22 => 'wink',
    23 => 'winked',
  ),
  'default_avatar_path_config' => '/images/noavatar.png',
  'alloved_avatar_ext' => 
  array (
    0 => 'gif',
    1 => 'jpg',
    2 => 'png',
    3 => 'jpeg',
    4 => 'bmp',
  ),
  'alloved_avatar_maxwidth' => 110,
  'alloved_avatar_maxheight' => 110,
  'alloved_avatar_maxsize' => 100,
  'is_installed' => 0,
);
?>