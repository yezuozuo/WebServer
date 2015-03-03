<?php
error_reporting(E_ERROR);
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset = "utf-8" />
<title>拼图游戏</title>
<style type="text/css">
	body{
		font-size:12px;
	}
	a.tu{
		display:block;
		width:100px;
		height:100px; 
		text-decoration:none;
	}

	<?php
	$i = 0;
	for($h = 0;$h >= -300;$h -= 100)
	{
		for($l = 0;$l >= -300;$l -= 100)
		{
			$i++;
			echo("#pic".$i."{");
			echo("background-image:url(Waterlilies.jpg);");
			echo("background-position:".$l."px ".$h."px;");
			echo("}");
		}
	}
	?>
</style>
</head>
<body>

<div align="center">
	<a href="JigsawPuzzle.php">开始新游戏</a>
	<hr />
</div>
<div style="width:900px;">
	 <div style="width:450px;float:left;">
		<img src="Waterlilies.jpg" width="400" height="400" />
	</div>
	 <div style="width:450px;float:left;">

		<?php
			$action = $_GET["action"];	//通过action参数来选择要调用的游戏函数

			if($action == "" || $action == "start")
			{
				start();	//调用 开始函数
			}
			if($action == "see") 
			{
				see();		//调用 显示函数
			}
			if($action == "move")
			{
				move();		//调用 处理函数
			}
		?>
	</div>
</div>
<div style="font-size:18px;">
	<span>点击的次数：</span>
	<?php
		echo $_SESSION["time"];
	?>
</div>
</body>
</html>
<?php 

//======游戏初始化函数=================================
function start()
{
	$count = 0;
	$temp = 0;

	//为每一个小的图片加一个标志
	for($h = 0;$h < 4;$h++)
	{
		for($l = 0;$l < 4;$l++)
		{
			$ges[$h][$l] = $count;
			$count++;
		}
	}
	
	//该循环的目的是为了打乱顺序
	for($ci = 0;$ci < 15;$ci++)
	{
		//mt_rand() 使用 Mersenne Twister 算法返回随机整数。
		//速度可以加快4倍
		$h1= mt_rand(0,3);
		$l1= mt_rand(0,3);

		$h2= mt_rand(0,3);
		$l2= mt_rand(0,3);

		$temp = $ges[$h1][$l1];
		$ges[$h1][$l1] = $ges[$h2][$l2];
		$ges[$h2][$l2] = $temp;
	}

	//记录Session
	$_SESSION["ges"] = $ges;
	$_SESSION["time"] = 0;
	//导航到?action=see也就是导航到see函数去
	echo("<script type='text/javascript'>location.href='?action=see';</script>");
}

//======游戏界面显示函数=================================
function see()
{
	//获取存储的session的值
	$ges = $_SESSION["ges"];

	//这个循环为可以移动的部分设定链接，当点击的时候触发move()函数
	for($h = 0;$h < 4;$h++)
	{
		for($l = 0;$l < 4;$l++)
		{
			$can = false;
		?>
			<div style="width:100px;height:100px;float:left;margin:1px;" onmouseover="this.bgColor='#CCFFFF'" onmouseout="this.bgColor='#ffffff' " id="<?php	
			if($ges[$h][$l] != 0)
			{ 
				echo( "pic".$ges[$h][$l] );
			}
			?>">

				<?php
				if($ges[$h][$l] != 0) 
				{
					if($h == 0)
					{
						if($ges[$h + 1][$l] == 0)
						{
							$can = true;
						}
					}
					if($h == 3)
					{
						if($ges[$h - 1][$l] == 0)
						{
							$can = true;
						}
					}
					if($h > 0 && $h < 3) 
					{
						if($ges[$h + 1][$l] == 0)
						{
							$can = true;
						}
						if($ges[$h - 1][$l] == 0)
						{
							$can = true;
						}
					}

					if($l == 0)
					{
						if($ges[$h][$l + 1] == 0)
						{
							$can = true;
						}
					}
					if($l == 3)
					{
						if($ges[$h][$l - 1] == 0)
						{
							$can = true;
						}
					}
					if($l > 0 && $l < 3)
					{
						if($ges[$h][$l + 1] == 0)
						{
							$can = true;
						}
						if($ges[$h][$l - 1] == 0) 
						{
							$can = true;
						}
					}					
					
					if($can == true)
					{
				?>
					<a href="?h=<?php echo($h)?>&l=<?php echo($l) ?>&action=move" class="tu">					
						&nbsp;&nbsp;
					</a>
				<?php
					}
					else
					{
					?>
						&nbsp;&nbsp;
					<?php
					}
				}

				//数组中标号为0的，不显示图像
				else
				{
				?>
					&nbsp;
				<?php 
					} 
				?>
			</div>
		<?php
		}
	}
}
//======游戏处理函数=================================
function move()
{
	//获取session中存储的值
	$ges = $_SESSION["ges"];
	
	//获取传递来的参数
	$h = $_GET["h"];
	$l = $_GET["l"];

	//以下4个判断用来交换空白处和可点击交换的图形
	if(($h > 0) && ($ges[$h - 1][$l] == 0))
  {
		$ges[$h - 1][$l] = $ges[$h][$l];
		$ges[$h][$l] = 0;
  } 
	if($h < 3 && $ges[$h + 1][$l] == 0)
  {
		$ges[$h + 1][$l] = $ges[$h][$l];
		$ges[$h][$l] = 0;
	}

	if($l > 0 && $ges[$h][$l - 1] == 0)
	{
		$ges[$h][$l - 1] = $ges[$h][$l];
		$ges[$h][$l] = 0;
	}
	if ($l < 3 && $ges[$h][$l + 1] == 0)
	{
		$ges[$h][$l + 1] = $ges[$h][$l];
		$ges[$h][$l] = 0;
	}
	
	//储存session
	$_SESSION["ges"] = $ges;

	//点击次数加1
	$_SESSION["time"]++;

	echo("<script type='text/javascript'>location.href='?action=see';</script>");
	}
?>

