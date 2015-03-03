<!doctype html>
<html>
<head>
<meta charset = "utf-8" />
<title>ITimer</title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/button.css">
<link rel="stylesheet" type="text/css" href="css/default.css">

<link rel="icon" href="img/ico/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="img/ico/favicon.ico" type="image/x-icon" />

<link href="css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript">
	var fin;

	$(function(){
		$("#datepicker").datepicker({
			inline: true,
			onSelect:function(dateText,inst){ 
        var strs= new Array();
        strs = dateText.split("/");
        fin = strs[2].concat(strs[0]).concat(strs[1]);  

      }
		});
		
	fin = $("#datepicker").val();
	strs = fin.split("/");
	fin = strs[2].concat(strs[0]).concat(strs[1]);
	});
</script>
</head>
<body>
<?php
	error_reporting(E_ERROR&~E_NOTICE);
?>