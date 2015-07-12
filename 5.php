<?php 
$im = imagecreatefromjpeg('http://img01.taobaocdn.com/bao/uploaded/i1/T1VsNZXaRNXXcJOVI9_102302.jpg_310x310.jpg'); 
imagefilter($im, IMG_FILTER_GRAYSCALE); 
header("content-type:image/jpeg;chatset=utf-8"); 
imagejpeg($im,'g.jpg'); 
imagedestroy($im); 
?> 