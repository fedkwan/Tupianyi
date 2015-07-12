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

for ($ig = 0; $ig < 1; $ig++)
{
	
	$url = $girl_url[$ig];

	$m = file_get_contents($url);
	$de = get_object_vars(json_decode($m));
	$de = get_object_vars($de['items_get_response']);
	$de = get_object_vars($de['items']);
	$de = $de['item'];//得到和拆开，鄙视淘宝的烂API╮(╯_╰)╭
	
	for ($i = 0; $i < 10; $i++)
	{
		$a = get_object_vars($de[$i]);
		$mb = $a['pic_url']."_310x310.jpg";
		$img = imagecreatefromjpeg($mb); //获得源文件
		
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

		$c = $cod[$i];
		$cod[$i] = ''; $s = ''; $r = 0;
		$ti = $a['title'];
		$ti = strip_tags($ti);
		$sql = "insert into img (id,title,pic_url,price,delist_time,post_fee,score,volume,detail_url,code) values (null,'$ti','$mb','$a[price]','$a[delist_time]','$a[post_fee]','$a[score]','$a[volume]','$a[detail_url]','$c')";
		mysql_query($sql);//写入数据库
	}
}

$end = getmicrotime();

$taketime = $end - $start;   

echo  "程序运行用时:".$taketime;

?>