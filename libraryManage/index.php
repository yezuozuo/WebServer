<?php
	include('connect.php');
?>
<!doctype html>
<html>
<head>
<meta charset = "utf-8" />
<title>图书馆勤工助学排班管理</title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/default.css">
<script type="text/javascript" src="js/jquery-2.0.0.min.js"></script>
</head>
<body>
	<form method="post" action="doAction.php" onsubmit="addData()">
		<table>
			<tr>
				<td></td>
				<td>姓名</td>
				<td>周一下午</td>
				<td>周二下午</td>
				<td>周三下午</td>
				<td>周四下午</td>
				<td>周五下午</td>
				<td>周一晚上</td>
				<td>周二晚上</td>
				<td>周三晚上</td>
				<td>周四晚上</td>
				<td>周五晚上</td>
				<td>周六下午</td>
				<td>周日下午</td>
				<td>周日晚上</td>
			</tr>
			<?php
				$i = 0;
				$a;
				foreach($namearr as $v)
				{
					$a = $i + 1;
					echo '<tr>';
					echo '<td>'.$a.'</td>';
					echo '<td>'.$v.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="a'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="c'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="e'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="g'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="i'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="b'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="d'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="f'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="h'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="j'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="k'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="l'.$i.'" />'.'</td>';
					echo '<td>'.'<input type="checkbox" class="checkbox" name="m'.$i.'" />'.'</td>';
					echo '</tr>';
					$i++;
				}
			?>
		</table>
		<input type="submit" class="button" value="提交" />
	</form>
	 <script type="text/javascript">
	function addData(){
		// //周一下午
		// $('input[name="a6"]').attr('checked',true);
		// $('input[name="a8"]').attr('checked',true);
		// $('input[name="a16"]').attr('checked',true);
		// //$('input[name="a24"]').attr('checked',true);
		// $('input[name="a26"]').attr('checked',true);
		// // $('input[name="a15"]').attr('checked',true);
		// // $('input[name="a16"]').attr('checked',true);
		// // $('input[name="a26"]').attr('checked',true);
		// // $('input[name="a32"]').attr('checked',true);

		// //周二下午
		// $('input[name="c25"]').attr('checked',true);
		// //$('input[name="c32"]').attr('checked',true);
		// $('input[name="c33"]').attr('checked',true);
		// $('input[name="c34"]').attr('checked',true);
		// $('input[name="c35"]').attr('checked',true);
		// $('input[name="c36"]').attr('checked',true);
		// // $('input[name="c16"]').attr('checked',true);
		// // $('input[name="c17"]').attr('checked',true);
		// // $('input[name="c21"]').attr('checked',true);
		// // $('input[name="c34"]').attr('checked',true);
		// // $('input[name="c35"]').attr('checked',true);
		// // $('input[name="c36"]').attr('checked',true);

		// //周三下午
		// // $('input[name="e39"]').attr('checked',true);

		// //周四下午
		// $('input[name="g5"]').attr('checked',true);
		// $('input[name="g6"]').attr('checked',true);
		// $('input[name="g7"]').attr('checked',true);
		// $('input[name="g8"]').attr('checked',true);
		// $('input[name="g9"]').attr('checked',true);
		// $('input[name="g10"]').attr('checked',true);
		// $('input[name="g11"]').attr('checked',true);
		// $('input[name="g12"]').attr('checked',true);
		// $('input[name="g16"]').attr('checked',true);
		// $('input[name="g25"]').attr('checked',true);
		// $('input[name="g33"]').attr('checked',true);
		// $('input[name="g45"]').attr('checked',true);
		// $('input[name="g46"]').attr('checked',true);
		// $('input[name="g47"]').attr('checked',true);

		// //周五下午
		// $('input[name="i5"]').attr('checked',true);
		// $('input[name="i12"]').attr('checked',true);
		// $('input[name="i22"]').attr('checked',true);
		// $('input[name="i27"]').attr('checked',true);

		// //周一晚上
		// $('input[name="b5"]').attr('checked',true);
		// $('input[name="b6"]').attr('checked',true);
		// $('input[name="b7"]').attr('checked',true);

		// $('input[name="b9"]').attr('checked',true);
		// $('input[name="b10"]').attr('checked',true);
		// $('input[name="b11"]').attr('checked',true);
		// $('input[name="b12"]').attr('checked',true);
		// $('input[name="b13"]').attr('checked',true);
		// $('input[name="b14"]').attr('checked',true);
		
		// $('input[name="b16"]').attr('checked',true);
		// $('input[name="b17"]').attr('checked',true);
		
		// $('input[name="b19"]').attr('checked',true);
		// $('input[name="b20"]').attr('checked',true);

		// $('input[name="b22"]').attr('checked',true);

		// $('input[name="b25"]').attr('checked',true);

		// $('input[name="b27"]').attr('checked',true);

		// $('input[name="b34"]').attr('checked',true);

		// $('input[name="b36"]').attr('checked',true);
		// $('input[name="b37"]').attr('checked',true);
		// $('input[name="b38"]').attr('checked',true);
		// $('input[name="b39"]').attr('checked',true);
		// $('input[name="b40"]').attr('checked',true);
		// $('input[name="b41"]').attr('checked',true);
		// $('input[name="b42"]').attr('checked',true);
		// $('input[name="b43"]').attr('checked',true);
		// $('input[name="b44"]').attr('checked',true);

		// //周二晚上
		// $('input[name="d3"]').attr('checked',true);
		// $('input[name="d4"]').attr('checked',true);
		// $('input[name="d7"]').attr('checked',true);
		// $('input[name="d19"]').attr('checked',true);

		// $('input[name="d26"]').attr('checked',true);
		// $('input[name="d27"]').attr('checked',true);
		// $('input[name="d28"]').attr('checked',true);
		// $('input[name="d29"]').attr('checked',true);

		// $('input[name="d31"]').attr('checked',true);

		// $('input[name="d34"]').attr('checked',true);
		// $('input[name="d35"]').attr('checked',true);

		// $('input[name="d39"]').attr('checked',true);
		// $('input[name="d40"]').attr('checked',true);
		// $('input[name="d41"]').attr('checked',true);
		// $('input[name="d42"]').attr('checked',true);
		// $('input[name="d43"]').attr('checked',true);
		// $('input[name="d44"]').attr('checked',true);

		// $('input[name="d46"]').attr('checked',true);
		// $('input[name="d48"]').attr('checked',true);
		// $('input[name="d49"]').attr('checked',true);

		// //周三晚上
		// $('input[name="f1"]').attr('checked',true);
		// $('input[name="f2"]').attr('checked',true);
		// $('input[name="f5"]').attr('checked',true);
		// $('input[name="f6"]').attr('checked',true);
		// $('input[name="f7"]').attr('checked',true);
		// $('input[name="f8"]').attr('checked',true);
		// $('input[name="f9"]').attr('checked',true);
		// $('input[name="f10"]').attr('checked',true);
		// $('input[name="f11"]').attr('checked',true);

		// $('input[name="f13"]').attr('checked',true);
		// $('input[name="f14"]').attr('checked',true);
		// $('input[name="f15"]').attr('checked',true);
		// $('input[name="f16"]').attr('checked',true);
		// $('input[name="f17"]').attr('checked',true);
		// $('input[name="f18"]').attr('checked',true);

		// $('input[name="f21"]').attr('checked',true);
		// $('input[name="f22"]').attr('checked',true);
		// $('input[name="f23"]').attr('checked',true);
		// $('input[name="f25"]').attr('checked',true);
		// $('input[name="f26"]').attr('checked',true);
		// $('input[name="f27"]').attr('checked',true);

		// $('input[name="f29"]').attr('checked',true);
		// $('input[name="f30"]').attr('checked',true);
		// $('input[name="f31"]').attr('checked',true);

		// $('input[name="f34"]').attr('checked',true);
		// $('input[name="f35"]').attr('checked',true);
		// $('input[name="f36"]').attr('checked',true);
		// $('input[name="f37"]').attr('checked',true);
		// $('input[name="f38"]').attr('checked',true);
		// $('input[name="f39"]').attr('checked',true);
		// $('input[name="f40"]').attr('checked',true);
		// $('input[name="f41"]').attr('checked',true);

		// $('input[name="f46"]').attr('checked',true);
		// $('input[name="f47"]').attr('checked',true);
		// $('input[name="f48"]').attr('checked',true);
		// $('input[name="f49"]').attr('checked',true);

		// //周四晚上
		// $('input[name="h0"]').attr('checked',true);
		// $('input[name="h1"]').attr('checked',true);
		// $('input[name="h2"]').attr('checked',true);
		// $('input[name="h3"]').attr('checked',true);

		// $('input[name="h5"]').attr('checked',true);
		// $('input[name="h6"]').attr('checked',true);
		// $('input[name="h7"]').attr('checked',true);

		// $('input[name="h9"]').attr('checked',true);
		// $('input[name="h10"]').attr('checked',true);
		// $('input[name="h11"]').attr('checked',true);

		// $('input[name="h13"]').attr('checked',true);
		// $('input[name="h14"]').attr('checked',true);
		// $('input[name="h15"]').attr('checked',true);

		// $('input[name="h17"]').attr('checked',true);
		// $('input[name="h18"]').attr('checked',true);

		// $('input[name="h20"]').attr('checked',true);
		// $('input[name="h21"]').attr('checked',true);

		// $('input[name="h23"]').attr('checked',true);
		// $('input[name="h25"]').attr('checked',true);

		// $('input[name="h27"]').attr('checked',true);

		// $('input[name="h29"]').attr('checked',true);

		// $('input[name="h31"]').attr('checked',true);

		// $('input[name="h34"]').attr('checked',true);
		// $('input[name="h35"]').attr('checked',true);
		// $('input[name="h36"]').attr('checked',true);
		// $('input[name="h37"]').attr('checked',true);

		// $('input[name="h42"]').attr('checked',true);
		// $('input[name="h43"]').attr('checked',true);
		// $('input[name="h44"]').attr('checked',true);
		// $('input[name="h45"]').attr('checked',true);
		// $('input[name="h46"]').attr('checked',true);
		// $('input[name="h47"]').attr('checked',true);

		// //周五晚上
		// $('input[name="j0"]').attr('checked',true);
		// $('input[name="j1"]').attr('checked',true);
		// $('input[name="j2"]').attr('checked',true);
		// $('input[name="j4"]').attr('checked',true);
		// $('input[name="j8"]').attr('checked',true);

		// $('input[name="j12"]').attr('checked',true);
		// $('input[name="j13"]').attr('checked',true);
		// $('input[name="j14"]').attr('checked',true);
		// $('input[name="j15"]').attr('checked',true);

		// $('input[name="j18"]').attr('checked',true);
		// $('input[name="j21"]').attr('checked',true);
		// $('input[name="j25"]').attr('checked',true);

		// $('input[name="j26"]').attr('checked',true);
		// $('input[name="j27"]').attr('checked',true);
		// $('input[name="j29"]').attr('checked',true);
		// $('input[name="j32"]').attr('checked',true);
		
		// $('input[name="j34"]').attr('checked',true);
		// $('input[name="j35"]').attr('checked',true);
		// $('input[name="j36"]').attr('checked',true);

		// $('input[name="j41"]').attr('checked',true);
		// $('input[name="j42"]').attr('checked',true);
		// $('input[name="j43"]').attr('checked',true);
		// $('input[name="j44"]').attr('checked',true);
		// $('input[name="j45"]').attr('checked',true);
		// $('input[name="j46"]').attr('checked',true);
		// $('input[name="j47"]').attr('checked',true);

		// //周六下午
		// $('input[name="k0"]').attr('checked',true);
		// $('input[name="k1"]').attr('checked',true);
		// $('input[name="k2"]').attr('checked',true);
	
		// $('input[name="k4"]').attr('checked',true);
		// $('input[name="k5"]').attr('checked',true);
		// $('input[name="k6"]').attr('checked',true);
		// $('input[name="k7"]').attr('checked',true);
		// $('input[name="k8"]').attr('checked',true);
		// $('input[name="k9"]').attr('checked',true);
		// $('input[name="k10"]').attr('checked',true);
		// $('input[name="k11"]').attr('checked',true);

		// $('input[name="k13"]').attr('checked',true);
		// $('input[name="k14"]').attr('checked',true);
		// $('input[name="k15"]').attr('checked',true);
		// $('input[name="k16"]').attr('checked',true);
		// $('input[name="k17"]').attr('checked',true);
		// $('input[name="k18"]').attr('checked',true);
		// $('input[name="k19"]').attr('checked',true);
		// $('input[name="k20"]').attr('checked',true);
		// $('input[name="k21"]').attr('checked',true);
		// $('input[name="k22"]').attr('checked',true);
		// $('input[name="k23"]').attr('checked',true);

		// $('input[name="k26"]').attr('checked',true);
		// $('input[name="k27"]').attr('checked',true);
		// $('input[name="k28"]').attr('checked',true);
		// $('input[name="k29"]').attr('checked',true);

		// $('input[name="k32"]').attr('checked',true);
		// $('input[name="k33"]').attr('checked',true);
		// $('input[name="k34"]').attr('checked',true);
		// $('input[name="k35"]').attr('checked',true);
		// $('input[name="k36"]').attr('checked',true);
		// $('input[name="k37"]').attr('checked',true);
		// $('input[name="k38"]').attr('checked',true);
		// $('input[name="k39"]').attr('checked',true);
		// $('input[name="k40"]').attr('checked',true);
		// $('input[name="k41"]').attr('checked',true);
		// $('input[name="k42"]').attr('checked',true);
		// $('input[name="k43"]').attr('checked',true);
		// $('input[name="k44"]').attr('checked',true);
		// $('input[name="k45"]').attr('checked',true);
		// $('input[name="k46"]').attr('checked',true);
		// $('input[name="k47"]').attr('checked',true);
		
		// $('input[name="k49"]').attr('checked',true);

		// //周日下午
		// $('input[name="l1"]').attr('checked',true);
		// $('input[name="l2"]').attr('checked',true);
		// $('input[name="l3"]').attr('checked',true);
		// $('input[name="l4"]').attr('checked',true);
		// $('input[name="l5"]').attr('checked',true);
		// $('input[name="l6"]').attr('checked',true);
		// $('input[name="l7"]').attr('checked',true);
		// $('input[name="l8"]').attr('checked',true);
		// $('input[name="l9"]').attr('checked',true);
		// $('input[name="l10"]').attr('checked',true);
		// $('input[name="l11"]').attr('checked',true);

		// $('input[name="l13"]').attr('checked',true);
		// $('input[name="l14"]').attr('checked',true);
		// $('input[name="l15"]').attr('checked',true);
		// $('input[name="l16"]').attr('checked',true);
		// $('input[name="l17"]').attr('checked',true);
		// $('input[name="l18"]').attr('checked',true);

		// $('input[name="l21"]').attr('checked',true);
		// $('input[name="l22"]').attr('checked',true);
		// $('input[name="l23"]').attr('checked',true);

		// $('input[name="l27"]').attr('checked',true);
		// $('input[name="l28"]').attr('checked',true);
		// $('input[name="l29"]').attr('checked',true);

		// $('input[name="l32"]').attr('checked',true);
		// $('input[name="l33"]').attr('checked',true);
		// $('input[name="l34"]').attr('checked',true);
		// $('input[name="l35"]').attr('checked',true);
		// $('input[name="l36"]').attr('checked',true);
		// $('input[name="l37"]').attr('checked',true);
		// $('input[name="l38"]').attr('checked',true);

		// $('input[name="l41"]').attr('checked',true);
		// $('input[name="l42"]').attr('checked',true);
		// $('input[name="l43"]').attr('checked',true);
		// $('input[name="l44"]').attr('checked',true);
		// $('input[name="l45"]').attr('checked',true);
		// $('input[name="l46"]').attr('checked',true);
		// $('input[name="l47"]').attr('checked',true);

		// $('input[name="l49"]').attr('checked',true);

		// //周日晚上
		// $('input[name="m0"]').attr('checked',true);
		// $('input[name="m1"]').attr('checked',true);
		// $('input[name="m2"]').attr('checked',true);
		// $('input[name="m3"]').attr('checked',true);
		// $('input[name="m4"]').attr('checked',true);
		// $('input[name="m5"]').attr('checked',true);

		// $('input[name="m7"]').attr('checked',true);
		// $('input[name="m8"]').attr('checked',true);
		// $('input[name="m9"]').attr('checked',true);
		// $('input[name="m10"]').attr('checked',true);
		// $('input[name="m11"]').attr('checked',true);
		// $('input[name="m12"]').attr('checked',true);
		// $('input[name="m13"]').attr('checked',true);
		// $('input[name="m14"]').attr('checked',true);
		// $('input[name="m15"]').attr('checked',true);
		// $('input[name="m16"]').attr('checked',true);
		// $('input[name="m17"]').attr('checked',true);

		// $('input[name="m20"]').attr('checked',true);

		// $('input[name="m24"]').attr('checked',true);
			
		// $('input[name="m27"]').attr('checked',true);
		// $('input[name="m28"]').attr('checked',true);
		// $('input[name="m29"]').attr('checked',true);
		// $('input[name="m30"]').attr('checked',true);

		// $('input[name="m32"]').attr('checked',true);

		// $('input[name="m36"]').attr('checked',true);
		// $('input[name="m37"]').attr('checked',true);

		// $('input[name="m39"]').attr('checked',true);
		// $('input[name="m40"]').attr('checked',true);
		// $('input[name="m41"]').attr('checked',true);
		// $('input[name="m42"]').attr('checked',true);
		// $('input[name="m43"]').attr('checked',true);

		// $('input[name="m46"]').attr('checked',true);
		// $('input[name="m48"]').attr('checked',true);
	}
	</script>
</body>
</html>
<?php

?>