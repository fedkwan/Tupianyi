<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include 'conn.php';
function getmicrotime()
{
list($usec,   $sec)   =   explode(" ",microtime());   
return   ((float)$usec   +   (float)$sec);   
}
$start = getmicrotime();
//mysql_query("DELETE FROM `img` WHERE code = '1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.'");
mysql_query("DELETE FROM `img` WHERE title is null");
$end = getmicrotime();
$taketime = $end - $start;   
echo  "程序运行用时:".$taketime;
?>