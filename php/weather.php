<?php
	header("Content-Type:text/json;charset=gb2312");
	$a = file_get_contents("https://free-api.heweather.com/s6/weather/now?location=武汉&key=dd1496ab65914c34ae60802696e039eb");
	print_r($a);
?>