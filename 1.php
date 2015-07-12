<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSS截取字符串省略号效果 兼容浏览器 - CSSBBS</title>
<style>
div {  
    width:300px;  
    white-space:nowrap;  
    overflow:hidden;  
    float:left;  
    -o-text-overflow:ellipsis;     /* for Opera */  
    text-overflow:ellipsis;        /* for IE */  
}  
div:after {  
    content:"...";   /* for Firefox */  
}  
</style>
</head>

<body>
<div>
<a href="http://www.cssbbs.com/" title="欢迎光临www.cssbbs.com">欢迎光临www.cssbbs.com</a>
<a href="http://www.cssbbs.com/" title="CSS截取字符串省略号效果 兼容浏览器">CSS截取字符串省略号效果 兼容浏览器</a>
<a href="http://www.cssbbs.com/" title="CSS截取字符串省略号效果">CSS截取字符串省略号效果</a>
<a href="http://www.cssbbs.com/" title="欢迎光临www.cssbbs.com">欢迎光临CSS论坛！</a>
<a href="http://www.cssbbs.com/" title="欢迎光临www.cssbbs.com">CSS论坛，CSS爱好者共同的家园！</a>
</div>
</body>
</html>