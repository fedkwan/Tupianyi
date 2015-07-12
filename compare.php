<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="2.css" rel="stylesheet" />
<style>
a {
	color:#0099CC;
	text-decoration:none;
}
div {
	font-family:"微软雅黑";
	font-size:11px;
}
.item {
	float:left;  
	width:186px;
	height:230px;
	margin-left:25px;
	margin-right:25px;
	margin-top:20px;
	margin-bottom:20px;
}
.title {
	width:186px;    
	white-space:nowrap;  
	overflow:hidden;  
	float:left;  
	-o-text-overflow:ellipsis;     /* for Opera */  
	text-overflow:ellipsis;        /* for IE */  
}  
.title:after {
	content:"...";/* for Firefox */
}  
.searchend {
	float:left;  
	margin-top:10px;
	border:1px solid #DDDDDD;
	float:left;
}
.price {
	float:left;  
	width:186px;
}
</style>
<?php
include 'conn.php';
$timestamp =  time();

$image = imagecreatetruecolor(8,8); // 创建新图片
	$img=imagecreatefromjpeg($_GET['pic']);
	$thumbw=imagesx($img);//原图宽 
	$thumbh=imagesy($img);//原图高 
	
	$dims=imagecreatetruecolor($thumbw,$thumbh);//创建目标图gd1 
	for($x=0;$x<$thumbw;$x++)for($y=0;$y<$thumbh;$y++){imagecopyresized($dims,$img,$thumbw-$x-1,$y,$x,$y,1,1,1,1);}
	imagejpeg($dims,"pic/".$timestamp.".jpg");
	
	imagecopyresized ($image,$img,0,0,0,0,8,8,$thumbw,$thumbh);
	imagefilter($image, IMG_FILTER_GRAYSCALE); //变灰
	for($y=0;$y<8;$y++){for($x=0;$x<8;$x++){$rgb=ImageColorAt($image,$x,$y);$r=($rgb>>16)&0xFF;$s=$s+$r;}}//获取灰度
	for($y=0;$y<8;$y++){for($x=0;$x<8;$x++){$rgb=ImageColorAt($image,$x,$y);$r=($rgb>>16)&0xFF;if ($r<($s/64)){$a=$a.'0.';}else{$a=$a.'1.';}}}//灰度平均值偏离数列//无翻转输出图片

$sss = imagecreatetruecolor(8,8); // 创建新图片
	$imgs=imagecreatefromjpeg("pic/".$timestamp.".jpg");
	$sw=imagesx($imgs);//原图宽 
	$sh=imagesy($imgs);//原图高 
	
	imagecopyresized ($sss,$imgs,0,0,0,0,8,8,$sw,$sh);
	imagefilter($sss, IMG_FILTER_GRAYSCALE); //变灰
	for($ys=0;$ys<8;$ys++){for($xs=0;$xs<8;$xs++){$rgbs=ImageColorAt($sss,$xs,$ys);$rs=($rgbs>>16)&0xFF;$ss=$ss+$rs;}}//获取灰度
	for($ys=0;$ys<8;$ys++){for($xs=0;$xs<8;$xs++){$rgbs=ImageColorAt($sss,$xs,$ys);$rs=($rgbs>>16)&0xFF;if ($rs<($ss/64)){$as=$as.'0.';}else{$as=$as.'1.';}}}//灰度平均值偏离数列//水平翻转



$result = mysql_query("select * from img");
$aa = explode('.',$a); $asa = explode('.',$as);
while($row = mysql_fetch_array($result))
{$bb = explode('.',$row['code']);
for ($i=0;$i<64;$i++)
{
if ($aa[$i]==$bb[$i])
{$g =$g+1;}
else if ($aa[$i]!=$bb[$i])
{$f =$f+1;}
}
for ($is=0;$is<64;$is++)
{
if ($asa[$is]==$bb[$is])
{$gs =$gs+1;}
else if ($asa[$is]!=$bb[$is])
{$fs =$fs+1;}
}
if ($f<=5 ||$fs<=5)
{
echo "<div class='item'><a href='".$row['detail_url']."' target='_blank'><img width='180px' height='180px' class='searchend' src=".$row['pic_url']."></a><div class='title'><a href='".$row['detail_url']."' target='_blank'>".$row['title']."</a></div><div class='price'>包邮总价".($row['price']+$row['post_fee'])."元</div></div>";
$coun = $coun +1;}
$f = 0;$g = 0;}

if ($coun == 0 && $couns == 0){echo '<p>很抱歉，图便宜没有找到类似商品。</p>';}
?>