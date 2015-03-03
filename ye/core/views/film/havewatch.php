<?php include(VIEWDIR.'head.php'); ?>

<div class="toptitle">
	叶影之过去
</div>

<div class="topLink">
	<span>当前位置：</span>
	<a href="index.php" >叶</a>
	<span>-></span>
	<a href="index.php?ctl=film&act=index">叶影</a>
	<span>-></span>
	<span>叶影之过去</span>
	<br>
	<span class="sumRecord">
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
			<td width="100px">看完时间</td>
			<td width="150px">叶评</td>
			<td></td>
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
				<?php echo $v['h_filmname']; ?>
			</td>
			<td>
				<?php echo $v['h_time']; ?>
			</td>
			<td class="comment">
				<?php echo $v['h_comment']; ?>
			</td>
			<td>
				<input type="button" id="<?php echo $v['id']; ?>" class="editBtn" value="编辑" />
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
		<input class="button" type="button" id="insertBtn" value="添加" />
	</div>

	<a href="index.php?ctl=film&act=havewatch_log" id="logDiv">
		<input type="button" class="button" id="logBtn" value="生成日志" />
	</a>

</div>

<div style="display:none;" id="insertForm">
	<p>插入</p>
	<form method="post" action="index.php?ctl=film&act=insert&type=havewatch" onsubmit="return checkInsert()">
		<span>叶影名</span>
		<input type="text" id="insertName" name="filmname" />
		<br>
		<span>叶评</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="insertComment" name="comment" />
		<br>
		<input type="button" class="button" id="insertCancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<div style="display:none" id="editForm">
	<p>编辑</p>
	<form method="post" action="index.php?ctl=film&act=edit&type=havewatch" onsubmit="return checkEdit()"> 
		<span>叶影名</span>
		<input type="text" id="editName" name="filmname" />
		<br>
		<input type="hidden" id="id" name="id" />
		<span>叶评</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="editComment" name="comment" />
		<br>
		<input type="button" class="button" id="editCancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<script type="text/javascript">
	$('.editBtn').click(function(){
		$('#insertForm').hide();
		$('#editName').val(trim($(this).parents().siblings('.name').text()));
		$('#editComment').val(trim($(this).parents().siblings('.comment').text()));
		$('#id').val($(this).attr('id'));
		$('#editForm').show();
	});

	function checkInsert()
	{
		if(!trim($('#insertName').val()) || !trim($('#insertComment').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}

	function checkEdit()
	{
		if(!trim($('#editName').val()) || !trim($('#editComment').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}
</script>

<?php include(VIEWDIR.'foot.php'); ?>