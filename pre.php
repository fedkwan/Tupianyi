<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php

function getmicrotime()
						{
						  list($usec,   $sec)   =   explode(" ",microtime());   
						  return   ((float)$usec   +   (float)$sec);   
						}
						
$start = getmicrotime();

include 'conn.php';
include 'list.php';

for ($ig=0; $ig<5; $ig++)
{
	
	$url = $girl_url[$ig];
	
	$m = file_get_contents($url);
	$de = get_object_vars(json_decode($m));
	$de = get_object_vars($de['items_get_response']);
	$de = get_object_vars($de['items']);
	$de = $de['item'];//得到和拆开，鄙视淘宝的烂API╮(╯_╰)╭
	
	for ($i=0; $i<200; $i++)
	{
		$a = get_object_vars($de[$i]);
		$img=imagecreatefromjpeg($a['pic_url']); //获得源文件
		
		$x=imagesx($img); //获得图片的长
		$y=imagesy($img); //获得图片的宽
		
		$image = imagecreatetruecolor(8,8); //创建新图片
		imagecopyresized ($image,$img,0,0,0,0,8,8,$x,$y);//调整图片大小
		
		for($y=0;$y<8;$y++)
		{
			for($x=0;$x<8;$x++)
			{
				$gray=(ImageColorAt($image,$x,$y)>>8)&0xFF;
				imagesetpixel ($image,$x,$y,ImageColorAllocate($image,$gray,$gray,$gray));
			}
		}
	
		for($y=0;$y<8;$y++)
		{
			for($x=0;$x<8;$x++)
			{
				$rgb=ImageColorAt($image,$x,$y);
				$r=($rgb>>16)&0xFF;
				$s=$s+$r;
			}
		}

		for($y=0;$y<8;$y++)
		{
			for($x=0;$x<8;$x++)
			{
				$rgb=ImageColorAt($image,$x,$y);
				$r=($rgb>>16)&0xFF;
	
				if ($r<($s/64))
				{
					$cod[$i]=$cod[$i].'0.';
				}
				else
				{
					$cod[$i]=$cod[$i].'1.';
				}
			}
		}
		$s = 0;$r = 0;
		$c = $cod[$i];
		$mb = $a[pic_url]."_310x310.jpg";//转换成310小图
	
		$id = $a['num_iid'];
		$sql = "insert into img (id,num_iid,title,pic_url,price,type,delist_time,post_fee,score,volume,detail_url,code) values (null,'$id','$a[title]','$mb','$a[price]','$a[type]','$a[delist_time]','$a[post_fee]','$a[score]','$a[volume]','$a[detail_url]','$c')";
	
		mysql_query($sql);//写入数据库
		
		$cod[$i] = '';
	}
}

$end = getmicrotime();

$taketime = $end - $start;   

echo  "程序运行用时:".$taketime;

?>