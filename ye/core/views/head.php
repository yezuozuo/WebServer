<!doctype html>
<html>
<head>
<meta charset = "utf-8" />
<title>Ye</title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/button.css">
<link rel="stylesheet" type="text/css" href="css/pageElement.css">

<link rel="stylesheet" type="text/css" href="css/search.css">

<link rel="icon" href="img/ico/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="img/ico/favicon.ico" type="image/x-icon" />


<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>

<!-- search frame -->
<script type="text/javascript" src="js/search.js"></script>

</head>
<body>
	<?php
		error_reporting(E_ERROR&~E_NOTICE);
		date_default_timezone_set('PRC'); //设置中国时区
	?>

	<!-- 如果弄这个播放音乐的话，一旦跳转页面就会重新开始，解决方法是使用iframe -->
	<!-- <div id="audio">		
		<audio src="music/feiniao.mp3" controls="controls" autoplay="autoplay" loop="loop">
				Your browser does not support the audio element.
		</audio> 
	</div> -->