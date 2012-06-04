<?
include('sq.php');
include('config.php');
include('config_version.php');
include('url_config.php');
include('mysqlclass.php');
include('function.php');
include('myfunction.php');
include('privilege.php');
sqlEncode($_COOKIE);
sqlEncode($_POST);
sqlEncode($_GET);
$db = new SQL($dbfile);
session_start();
date_default_timezone_set('PRC') ;
header('Content-Type:text/html;charset=GB2312');
?>
