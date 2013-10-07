<?php
if (!defined('a1cms'))
	die('Access denied to comments!');

$comment_options=array (
  'enable_add_new_comments' => true,
  'signature_enable' => false,
  'moderation_enable' => true,
  'comments_on_page' => 20,
  'allow_add_comments' => 
  array (
    0 => '1',
    1 => '2',
    2 => '6',
    3 => '3',
    4 => '4',
  ),
  'allow_add_wout_moderation' => 
  array (
    0 => 1,
    1 => 2,
    2 => 3,
  ),
  'allow_edit_own_comments' => 
  array (
    0 => '1',
    1 => '2',
    2 => '6',
    3 => '3',
    4 => '4',
  ),
  'allow_edit_all_comments' => 
  array (
    0 => '1',
    1 => '2',
  ),
  'allow_control' => 
  array (
    0 => '1',
  ),
);
?>