<?php include('head.php'); ?>
<div>
	<button id="recordBtn" class="button">recorder</button>
	<button id="thinkBtn" class="button">thinker</button>
	<button id="reviewBtn" class="button">review</button>
	<?php
		if($res->get('flag') == 1)
		{
	?>
		<a href="index.php">
			<button id="return" class="button">return</button>
		</a>
	<?php 
		}
	?>
</div>

<div id="all_record">
	<div id="datepicker"></div>
	<br>
	<div>
		<div id="sentence_nav"> 
    <span class="total_count">
    	<?php
    		$v = $res->get('recordList');
    		$v = $v[0];
				$time = array();
				$time_t = array();
				$time_t_t = array();
				$time = str_split($v['time'],8);
				$time_t = str_split($time[0],4);
				$time_t_t = str_split($time_t[1],2);
		 		echo $time_t[0]."年".$time_t_t[0]."月".$time_t_t[1]."日";
		 	?>
      共
      <strong><?php echo $res->get('record_total_num');?></strong> 
      条记录
    </span>
		</div>
		<table id="recordTable">
			<tr>
				<td width="20px"></td>
				<td width="50px">time</td>
				<td width="200px">record</td>
				<td width="200px">think</td>
			</tr>
			<?php
				$i = 0;
				foreach($res->get('recordList') as $v)
				{
			?>
				<tr>
					<td><?php echo $i ?></td>
					<td>
						<?php
							$time = array();
							$time_t = array();
							$time_t_t = array();
							$time = str_split($v['time'],8);
							$time_t = str_split($time[1],2);
					 		echo $time_t[0].":".$time_t[1];
					 	?>
					</td>
					<td><?php echo $v['thing'] ?></td>
					<td><?php echo $v['think'] ?></td>
				</tr>
			<?php
					$i++;
				}
			?>
		</table>
	</div>
</div>

<div id="all_think">
	<span>thinks</span>
	<span>
		共
    <strong><?php echo $res->get('think_total_num');?></strong> 
    条记录
  </span>
	<table>
		<tr>
			<td width="20px"></td>
			<td width="120px">time</td>
			<td width="200px">think</td>
			<td></td>
		</tr>
		<?php
			$i = 0;
			foreach($res->get('thinkList') as $v)
			{
		?>
			<tr>
				<td><?php echo $i ?></td>
				<td width="100px">
					<?php
						$time = array();
						$time_t = array();
						$time_t_t = array();
						$time = str_split($v['time'],8);
						$time_t = str_split($time[1],2);
						$time_t_1 = str_split($time[0],4);
						$time_t_t = str_split($time_t_1[1],2);
						echo $time_t_1[0]."年".$time_t_t[0]."月".$time_t_t[1]."日";
				 		echo $time_t[0].":".$time_t[1];
				 	?>
				</td>
				<td width="100px">
					<?php echo $v['think'] ?>
				</td>
				<td>
					<a href="index.php?ctl=default&act=think_delete&id=<?php echo $v['time'];?>">
						<input type="button" value="删除" />
					</a>
				</td>
			</tr>
		<?php
				$i++;
			}
		?>
	</table>
</div>

<div style="display:none;" id="recordContent">
	<form method="post" action="index.php?ctl=default&act=record_summit" onsubmit="return checkRecord();">
		<span>时间</span>
		<input type="text" id="r_time" name="time" /> 
		<br>
		<span>事情</span>
		<input type="text" id="r_record" name="record" />
		<br>
		<span>感想</span>
		<input type="text" id="r_think" name="think" />
		<br>
		<button>确定</button>
	</form>
</div>

<div style="display:none;" id="thinkContent">
	<form method="post" action="index.php?ctl=default&act=think_summit" onsubmit="return checkThink();">
		<span>thinker</span>
		<input type="text" id="t_think" name="think" />
		<br>
		<button>确定</button>
	</form>
</div>

<div style="display:none;" id="reviewContent">
	<form method="post" action="index.php?ctl=default&act=review" onsubmit="checkReview()">
		<span>年</span>
		<select id="year">
			<option>2014</option>
			<option>2015</option>
		</select>
		<span>月</span>
		<select id="month">
			<option>01</option>
			<option>02</option>
			<option>03</option>
			<option>04</option>
			<option>05</option>
			<option>06</option>
			<option>07</option>
			<option>08</option>
			<option>09</option>
			<option>10</option>
			<option>11</option>
			<option>12</option>
		</select>
		<span>日</span>
		<select id="day" disabled="disabled">
			<option>01</option>
		</select>
		<br>
		<input id="reviewDate" type="hidden" name="reviewDate" />
		<input class="button" type="submit" value="提交" />
	</form>
</div>

<script type="text/javascript">
	$('#recordBtn').click(function(){
		$('#recordContent').show();
		$('#thinkContent').hide();
		$('#reviewContent').hide();
	});

	$('#thinkBtn').click(function(){
		$('#thinkContent').show();
		$('#recordContent').hide();
		$('#reviewContent').hide();
	});

	$('#reviewBtn').click(function(){
		$('#reviewContent').show();
		$('#thinkContent').hide();
		$('#recordContent').hide();
	});

	$('#month').focus(function(){
		$('#day').attr('disabled',false);
	});

	$('#day').focus(function(){
		if($('#month').val() == 2)
		{
			var insert;
			for(var i = 1;i <= 29;i++)
			{
				insert += '<option>';
				insert += i;
				insert += '</option>'; 
			}
			$('#day').html(insert);
		}
		else if($('#month').val() == 1 
						|| $('#month').val() == 3 
						|| $('#month').val() == 5 
						|| $('#month').val() == 7 
						|| $('#month').val() == 8 
						|| $('#month').val() == 10 
						|| $('#month').val() == 12)
		{
			var insert;
			for(var i = 1;i <= 9;i++)
			{
				insert += '<option>0';
				insert += i;
				insert += '</option>'; 
			}
			for(var i = 10;i <= 9;i++)
			{
				insert += '<option>';
				insert += i;
				insert += '</option>'; 
			}
			$('#day').html(insert);
		}	
		else
		{
			var insert;
			for(var i = 1;i <= 9;i++)
			{
				insert += '<option>0';
				insert += i;
				insert += '</option>'; 
			}
			for(var i = 10;i <= 30;i++)
			{
				insert += '<option>';
				insert += i;
				insert += '</option>'; 
			}
			$('#day').html(insert);
		}
	});

	function checkRecord()
	{
		if($('#r_time').val() == '')
		{
			alert('输入时间！');
			$('#r_time').focus();
			return false;
		}
		else if($('#r_record').val() == '')
		{
			alert('输入记录！');
			$('#r_record').focus();
			return false;
		}

		var time = $('#r_time').val();

		var timeArr = new Array();

		if(time.indexOf(':') != -1)
		{
			timeArr = time.split(":");
		}
		else if(time.indexOf('：') != -1)
		{
			timeArr = time.split("：");
		}
		time_1 = parseInt(timeArr[0]);
		time_2 = parseInt(timeArr[1]);
		if(time_1 < 0 || time_1 > 24 || time_2 > 60 || time_2 < 0)
		{
			alert('时间输入格式错误');
			return false;
		}
		if(time_1 < 10)
		{
			timeArr[0] = '0' + timeArr[0];
		}
		if(time_2 < 10)
		{
			timeArr[1] = '0' + timeArr[1];
		}
		time = timeArr[0].concat(timeArr[1]);
		fin = fin + time;
		$('#r_time').val(fin);
	}

	function checkThink()
	{
		if($('#t_think').val() == '')
		{
			alert('输入think！');
			$('#t_think').focus();
			return false;
		}
	}

	function checkReview()
	{
		$('#reviewDate').val($('#year').val() + $('#month').val() + $('#day').val());
		// alert($('#reviewDate').val());
	}
</script>
<?php include('foot.php'); ?>
