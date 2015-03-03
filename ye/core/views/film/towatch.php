<?php include(VIEWDIR.'head.php'); ?>

<div class="toptitle">
	叶影之未来
</div>

<div class="topLink">
	<span>当前位置：</span>
	<a href="index.php">叶</a>
	<span>-></span>
	<a href="index.php?ctl=film&act=index">叶影</a>
	<span>-></span>
	<span>叶影之未来</span>
	<br>
	<span class="total_count">
    共
    <strong><?php echo $res->get('total_num');?></strong> 
    条记录
	</span>
</div>

<div>
	<table class="commonTablePosition">
		<tr>
			<td></td>
			<td width="150px">叶影</td>
			<td width="100px">创建时间</td>
			<td width="50px"></td>
			<td width="50px"></td>
			<td width="50px"></td>
		</tr>
		<?php
			$i = count($res->get('filmlist'));
			foreach($res->get('filmlist') as $v)
			{
		?>
		<tr>
			<td>
				<?php echo $i--; ?>
			</td>
			<td class="name">
				<?php echo $v['t_filmname']; ?>
			</td>
			<td>
				<?php echo $v['t_time']; ?>
			</td>
			<td>
				<input type="button" id="<?php echo $v['id']; ?>" class="editBtn" value="编辑" />
			</td>
			<td>
				<a href="index.php?ctl=film&act=delete&id=<?php echo $v['id'];?>">
					<input type="button" class="deleteBtn" value="删除" />
				</a>
			</td>
			<td>
				<a href="index.php?ctl=film&act=watch&id=<?php echo $v['id'];?>">
					<input type="button" class="watchBtn" value="观看" />
				</a>
			</td>
		</tr>
		<?php
			}
		?>
	</table>

	<div class="pageset">
		<?php echo $res->get('pageset');?>
	</div>

	<div class="insert">
		<input type="button" class="button" id="insertBtn" value="添加" />
	</div>

	<a href="index.php?ctl=film&act=towatch_log" id="logDiv">
		<input type="button" class="button" id="logBtn" value="生成日志" />
	</a>

</div>

<div style="display:none;" id="insertForm">
	<form method="post" action="index.php?ctl=film&act=insert&type=towatch" onsubmit="return checkInsert()">
		<span>叶影名</span>
		<input type="text" id="insertName" name="filmname" />
		<br>
		<input type="button" class="button" id="insertCancel" value="取消" />
		<input type="submit" class="button" id="insertSubmit" value="提交" />
	</form>
</div>

<div style="display:none" id="editForm">
	<form method="post" action="index.php?ctl=film&act=edit&type=towatch" onsubmit="return checkEdit()"> 
		<span>叶影名</span>
		<input type="text" id="editName" name="filmname" />
		<input type="hidden" id="id" name="id" />
		<br>
		<input type="button" class="button" id="editCancel" value="取消" />
		<input type="submit" class="button" id="editSubmit" value="提交" />
	</form>
</div>

<script type="text/javascript">
	$('.editBtn').click(function(){
		$('#insertForm').hide();
		$('#editName').val(trim($(this).parents().siblings('.name').text()));
		$('#id').val($(this).attr('id'));
		$('#editForm').show();
	});
	function checkInsert()
	{
		if(!trim($('#insertName').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}
	function checkEdit()
	{
		if(!trim($('#editName').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}
</script>
<?php include(VIEWDIR.'foot.php'); ?>