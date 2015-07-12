<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns = "http://www.w3.org/1999/xhtml">

<meta http-equiv = "Content-Type" content = "text/html; charset = utf-8" />

<?php

function getmicrotime()
		 {
		  list($usec,$sec) = explode(" ",microtime());   
		  return ((float)$usec + (float)$sec);   
		 }
						
$start = getmicrotime();

include 'conn.php';
include 'list.php';

for ($ig = 0; $ig < 50; $ig++)
{
	
	$url = $girl_url[$ig];

	$m = file_get_contents($url);
	$de = get_object_vars(json_decode($m));
	$de = get_object_vars($de['items_get_response']);
	$de = get_object_vars($de['items']);
	$de = $de['item'];//得到和拆开，鄙视淘宝的烂API╮(╯_╰)╭
	
	for ($i = 0; $i<200; $i++)
	{
		$a = get_object_vars($de[$i]);
		$mb = $a['pic_url']."_310x310.jpg";
		$ti = $a['title'];
		$ti = strip_tags($ti);
		$pp = $a['price']+$a['post_fee'];
		$sql = "insert into img (id,title,pic_url,price,delist_time,post_fee,pp,score,volume,detail_url) values (null,'$ti','$mb','$a[price]','$a[delist_time]','$a[post_fee]','$pp','$a[score]','$a[volume]','$a[detail_url]')";
		mysql_query($sql);//写入数据库
	}
}

$end = getmicrotime();

$taketime = $end - $start;   

echo  "程序运行用时:".$taketime;

?>