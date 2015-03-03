<?php include('head.php'); ?>
	<!--地图显示-->
	<div id="map_display"></div>

	<!--输入面板-->
	<div id="map_input">
		<div>
			<p>查询公交线路：</p>
			<span>输入线路号码：</span>
			<input type="text" id="route_input" />
			<br>
			<input type="button" id="route_input_btn" value="查询" />
		</div>

		<hr />
		
		<div id="r-result">
			<p>查询乘坐线路：</p>
			<span>起点：</span>
			<input type="text" id="suggestId_begin" size="20" style="width:150px;" />

			<br>

			<span>终点：</span>
			<input type="text" id="suggestId_end" size="20" style="width:150px;" />

			<br>
			<div id="driving_way">
				<select>
					<option value="0">最少时间</option>
					<option value="1">最少换乘</option>
					<option value="2">最少步行</option>
					<option value="3">不乘地铁</option>
				</select>
			</div>
			<input type="button" value="搜索" id="route_search_btn" />
		</div>

		<hr />

		<div>
			<p>根据站点查询线路：</p>
			<span>输入站点：</span>
			<form action="index.php?ctl=default&act=check" method="post">
				<input type="text" id="input_station" name="station" />
				<br>
				<input type="submit" id="input_station_btn" value="查询" />
			</form>
		</div>

		<hr />

		<div>
			<p>标注查询时刻正在行驶的车辆：</p>
			<span>输入线路号码：</span>
			<form action="index.php?ctl=default&act=callout" method="post">
				<input type="text" id="bus_running_num" name="running_no" />
				<input type="submit" value="标注" />
			</form>
		</div>
		
		<div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
	</div>

	<!--结果显示面板-->
	<div id="map_needline_result"></div>

	<div id="map_stationline_result">
		<span>
			经过
			<?php echo $res->get('station');?>
			的线路有：
		</span>
		<?php
			if($res->get('flag') == 1)
			{
					foreach($res->get('noList') as $key => $value) 
					{
						echo $value."路"."    |";	
					}
			}
			else if($res->get('flag') == 0)
			{
				echo "没有查询到相关信息";
			}
			else
			{

			}
		?>
	</div>

	<script type="text/javascript" src="js/doMap.js"></script>
	<?php
		if($res->get('pos_flag') == 1)
		{
			if(count($res->get('positionList')))
			{
	?>
		<div>
			<input id="longitude" type="hidden" value="<?php echo $res->get('positionList')[0]['longitude']; ?>" />
			<input id="latitude" type="hidden" value="<?php echo $res->get('positionList')[0]['latitude']; ?>" />
		</div>
	<script type="text/javascript">
		setPosition($('#longitude').val(),$('#latitude').val());
	</script>
	<?php
			}
			else if($res->get('pos_flag') == 0)
			{
				echo "没有查询到相关信息";
			}
			else
			{
				
			}
		}
	?>
<?php include('foot.php'); ?>
