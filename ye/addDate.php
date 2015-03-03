<!doctype html>
<html>
<head>
<meta charset = "utf-8" />
<title></title>
<style type="text/css">
	body{
		background: #dddddd;
	}
</style>
<script type="text/javascript">

</script>
</head>
<body>
<?php
	$fileName = 'not.txt';
	$className = 'notread';
	
	if(file_exists($fileName))
	{

	}
	else
	{
		die('not not exists');
	}
	$data = file_get_contents($fileName);
	$data = iconv("GBK","UTF-8",$data);
	$arr = explode('#', $data);

	$conn = mysql_connect("localhost:3305","root","123") or die("连接数据库失败!").mysql_error();
	$select = mysql_select_db("ye",$conn);
	if($select)
	{
		echo "数据库连接成功";
	}
	var_dump($arr);
	mysql_query("set names utf8");
	echo $arr[0];
	echo $arr[1];
	echo floor(count($arr)/2);
	for($i = 0;$i < count($arr);$i++)
	{
		$sql = "insert into notread(n_bookname,n_stoptime) values('".$arr[$i]."','".$arr[++$i]."');";
		mysql_query($sql,$conn);
	}
	$sql = 'delete from '.$className;
	//mysql_query($sql);
	
?>
</body>
</html>
