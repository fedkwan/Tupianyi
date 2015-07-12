<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns = "http://www.w3.org/1999/xhtml">

<meta http-equiv = "Content-Type" content = "text/html; charset = utf-8" />

<?php

include 'conn.php';

$sql = "select * from `img` where code is null";

$result = mysql_query($sql);

while($row = mysql_fetch_array($result))

{

echo $row['pic_url']."<br/>";

}

?>