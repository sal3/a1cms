<?php
if (!defined('a1cms'))
	die('Access denied!');

$news_config=array (
  'use_cache' => false,
  'news_on_main' => true,
  'require_poster' => true,
  'redirect_to_rigth_news_path' => true,
  'news_on_page' => 10,
  'pagelinks' => 10,
  'news_in_admin_on_page' => 30,
  'short_cache_time' => 60,
  'full_cache_time' => 3600,
  'min_title_length' => 5,
  'max_title_length' => 255,
  'max_poster_size' => 1024000,
  'min_full_text' => 5,
  'always_regenerate_meta' => true,
  'cache_news_views' => true,
  'news_views_taskperiod' => 900,
  'rss_enable' => true,
  'rss_limit' => 30,
  'site_short_title_to_rsstitle' => false,
  'allow_add_posts' => 
  array (
    0 => '1',
    1 => '2',
    2 => '6',
    3 => '3',
    4 => '4',
  ),
  'allow_edit_own_posts' => 
  array (
    0 => '1',
    1 => '2',
    2 => '6',
    3 => '3',
    4 => '4',
  ),
  'allow_edit_all_posts' => 
  array (
    0 => '1',
    1 => '2',
    2 => '6',
  ),
  'allow_post_main' => 
  array (
    0 => '1',
    1 => '2',
    2 => '6',
    3 => '3',
    4 => '4',
  ),
  'allow_post_wout_moderation' => 
  array (
    0 => '1',
    1 => '2',
    2 => '6',
    3 => '3',
  ),
  'allow_configure_news' => 
  array (
    0 => '1',
  ),
);
?>