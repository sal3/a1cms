<?php
if (!defined('a1cms'))
	die('Access denied to mysql.php!');

include_once root.'/sys/dbconfig.php';
$QUERIES_COUNTER =(int) 0;
$dbconnect='';

function dbconnect ()
{
    global $error, $dbconnect, $host, $dbase_user_name, $dbase_user_password, $db_name; //FIXME: плохо делать глобал этих переменных
    
    if(!$dbconnect)
    {
	$dbconnect = @mysqli_connect ($host, $dbase_user_name, $dbase_user_password) or $error[] = "Не удалось соединиться с mysql";
	
	if($dbconnect)
	{
		mysqli_select_db ($dbconnect, $db_name) or $error[] = "Не удалось выбрать базу $db_name";
		mysqli_query($dbconnect, "SET NAMES 'utf8'");
		return true; //коннект создался
	}
	else //коннект не создался
		return false;
    }
    else //коннект уже был
	return true;
}

function query ($query, $variables_array=false, $dont_quotes=false)
{
//$dont_quotes - костыль для search.php, чтобы не менять "<" на " ' "
// var_dump($variables_array);

	global $dbconnect, $table_prefix, $QUERIES_COUNTER, $QUERIES_TIME_COUNTER, $error,$debug;

	$query_start_time = microtime(true);

	if(dbconnect())
	{
		$query=str_replace("{P}", $table_prefix, $query);

		if($variables_array != false)
		foreach ($variables_array as $key => $value)
		{
	//  		echo $key;echo $value;
			$query=str_replace("i<".$key.">", intval($value), $query);

			if ($dont_quotes)
				$query=str_replace("<".$key.">", mysqli_real_escape_string($dbconnect, $value), $query);
			else
				$query=str_replace("<".$key.">", "'".mysqli_real_escape_string($dbconnect, $value)."'", $query);

		}
		elseif(preg_match('/(update|insert)/siu',$query))
			die('Insert и update без $variables_array не разрешен!');

			$debug[] = $query.'<br />';
	//  		echo $query;

		$query_result= mysqli_query($dbconnect, $query) or //$error[]="Не удалось выполнить запрос";
		$debug[] = "Не удалось выполнить запрос " . mysqli_error($dbconnect)."<br />".$query;

			$query_execute_time = microtime(true) - $query_start_time;
			$QUERIES_TIME_COUNTER += $query_execute_time;
			unset($query_execute_time);

			$QUERIES_COUNTER++;

		return $query_result;
	}
	else
		$error[]="Нет соединения с базой. Выполнение запросов невозможно.";
}

#*** Простой запрос единичной строки ***#
function single_query($q,$v=false)
{
	global $dbconnect;

	if(dbconnect())
		return mysqli_fetch_assoc(query($q,$v));
	else
		$error[]="Нет соединения с базой. Выполнение запросов невозможно.";
}

#*** Выборка ассоциативного массива ***#
function fetch_assoc($r)
{
	global $dbconnect;
	if(dbconnect())
		return mysqli_fetch_assoc( $r );
	else
		$error[]="Нет соединения с базой. Выполнение запросов невозможно.";
}

#*** Выборка массива ***#
function fetch_array($r,$t)
{
	global $dbconnect;
	if(dbconnect())
		return mysqli_fetch_array($r, $t);
	else
		$error[]="Нет соединения с базой. Выполнение запросов невозможно.";
}

#*** Выборка массива ***#
function num_rows($r)
{
	global $dbconnect;
	if(dbconnect())
		return mysqli_num_rows($r);
	else
		$error[]="Нет соединения с базой. Выполнение запросов невозможно.";
}

function insert_id ()
{
	global $dbconnect;
	if(dbconnect())
		return mysqli_insert_id($dbconnect);
	else
		$error[]="Нет соединения с базой. Выполнение запросов невозможно.";
}


?>