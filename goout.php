<?
error_reporting(0);
/*if (!strpos ($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']))
        header ("Location: /");
else*/
        header ("Location: {$_GET['url']}");
?>
