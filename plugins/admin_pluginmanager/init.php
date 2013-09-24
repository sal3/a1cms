<?php

if (!defined('a1cms'))
	die('Access denied to admin_pluginmanager!');

if ($WHEREI['admincenter']==true and $_GET['plugin']=='admin_pluginmanager')
{
	$groups_query = "SELECT id, group_name from {P}_groups ORDER by `Order`";
	$groups_sql = query($groups_query);
	$pluginmanager_parse['{groups_list}']="<option value='0'>Ни одной из групп</option>";
	while($groups_row = fetch_assoc($groups_sql))
	{
		$pluginmanager_parse['{groups_list}'].="<option value=\"{$groups_row['id']}\">{$groups_row['group_name']}</option>";
	}

	$tpl=get_template('pluginmanager',1);
	$parse_admin['{module}']=parse_template($tpl, $pluginmanager_parse);
}
?>