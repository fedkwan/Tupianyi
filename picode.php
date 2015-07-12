<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns = "http://www.w3.org/1999/xhtml">

<meta http-equiv = "Content-Type" content = "text/html; charset = utf-8" />

<?php

include 'conn.php';

$sql = "select * from `img` where code is null";

$result = mysql_query($sql);

date_default_timezone_set('Asia/Chongqing');

$date = date('Y-m-d');

while($row = mysql_fetch_array($result))

{

	$name = preg_replace('/http:\/\/img([0-9]{2})?\.taobaocdn\.com\/bao\/uploaded\/i\d\/([0-9]*\/)?/','',$row['pic_url']);
	echo $name."<br>";
	$img = imagecreatefromjpeg("tmpic/".$date."/".$name); //获得源文件
	
	$x = imagesx($img); //获得图片的长
	$y = imagesy($img); //获得图片的宽
	
	$image = imagecreatetruecolor(8,8); //创建新图片
	imagecopyresized ($image,$img,0,0,0,0,8,8,$x,$y);//调整图片大小
	
	imagefilter($image, IMG_FILTER_GRAYSCALE); //变灰
	
	$s = array();	
	for($y = 0; $y < 8; $y++)
	{
		for($x = 0; $x < 8; $x++)
		{
			$rgb = ImageColorAt($image,$x,$y);
			$r = ($rgb >> 16) & 0xFF;
			$s[] = $r;
		}
	}
	$sum = array_sum($s);
	foreach ($s as $k  => $v) 
	{
		if ($s[$k] < ($sum / 64))
		{
			$cod[$i] = $cod[$i].'0.';
		}
		else
		{
			$cod[$i] = $cod[$i].'1.';
		}
	}
	
	$c = $cod[$i]; $u = $row['detail_url'];
	$cod[$i] = ''; $s = ''; $r = 0;
	echo $c;
	echo $u."<br>";
	$sql2 = "update `img` set code = '$c' where `detail_url` = '$u' ";
	mysql_query($sql2);//写入数据库*/
}
		
?>