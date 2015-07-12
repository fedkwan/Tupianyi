<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" href="2.css" rel="stylesheet" />

<script type="text/javascript" src='jq.js'></script>
<script type="text/javascript">
$(document).ready(function(){
$(".tpy").click(function(){
var n = $('#pic').val()
$("#listshow").load("compare.php?pic="+n);
});
});
</script>

</head>

<?php 

preg_match("/^http:\/\/item.tmall.com\/item.htm/", $_GET['url'],$tmall);

preg_match("/^http:\/\/item.taobao.com\/item.htm/", $_GET['url'],$taobao);

if ($tmall[0] == 'http://item.tmall.com/item.htm' || $taobao[0] == 'http://item.taobao.com/item.htm')
{
$con = file_get_contents($_GET['url']);

preg_match('/]*id="J_ImgBooth"[^r]*rc=\"([^"]*)\"[^>]*>/', $con, $img); //正则取310x310图

preg_match('/\<h3\>\<a target="_blank" href="(.*?)\>(.*?)\<\/h3\>/',$con,$title);//正则取标题

	if ($title[2] == '')//这里没有东西，就是item.taobao的。
	{
		preg_match('/\<title\>(.*?)\<\/title\>/',$con,$title);

		$titlez=iconv('GBK','UTF-8',$title[1]);
	}
	else if ($title[2] !== '')//这里有东西，就是item.tmall的。
	{
		$titlez=iconv('GBK','UTF-8',$title[2]);
	}

preg_match('/]*id="J_StrPrice" >(.*?)\<\/strong\>/',$con,$price);	//正则获取价钱是通用的，促销的价钱某些获取不了

if ($price[1] == '')
{

preg_match('/]*id="J_SpanLimitProm">(.*?)\<\/strong\>/',$con,$priceh);  //正则获取促销价格，促销的价钱某些获取不了//再次鄙视淘宝的空格

$price[1] = $priceh[1];

}

if ($tmall[0] == 'http://item.tmall.com/item.htm')
{

$from = '淘宝商城(http://www.tmall.com)';

}
else if ($taobao[0] == 'http://item.taobao.com/item.htm')
{

$from = '淘宝(http://www.taobao.com)';

}

echo "<div style='background-color:#DAF5FE; height:220px; width:1200px;'>

<div id='z1' style='width:220px; height:220px; float:left;'><img src=".$img[1]." style='width:200px; height:200px; margin:10px 0px 0px 10px;'><input id='pic' name='pic' type='hidden' value='".$img[1]."' /></div>

<div id='z2'>商品名称：".$titlez."</div>

<div id='z3'>商品价钱：".$price[1]."元</div>

<div id='z3'>来至：".$from."</div>

<div id='z4'><input type='submit' value='图便宜' class='tpy' /></div>

<div id='z3'>获取数据过程请稍等十数秒</div>

</div>

";

}

else { echo "<div style='margin:0 auto; text-align:center;'>商品网址输入错误</div>"; }
//http://item.tmall.com/item.htm?id=4601493210&cm_cat=50010167&pm2=1&source=dou&prt=1320338682586&prc=1 //实例网址
?>

</html>