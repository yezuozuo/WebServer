<?php include(VIEWDIR.'head.php'); ?>

<div class="toptitle">
	叶音
</div>

<div class="topLink">
	<span>当前位置：</span>
	<a href="index.php">叶</a>
	<span>-></span>
	<span>叶音</span>
	<br>
	<span class="sunRecord">
    共 
    <strong><?php echo $res->get('total_num');?></strong> 
    条记录
  </span>
</div>

<div>
	<table class="commonTablePosition">
		<tr>
			<td></td>
			<td width="100px">音乐名</td>
			<td width="100px">演唱者</td>
			<td width="100px">创建时间</td>
			<td></td>
			<td></td>
		</tr>
		<?php
			$i = count($res->get('musiclist'));
			foreach($res->get('musiclist') as $v)
			{
		?>
		<tr>
			<td>
				<?php echo $i--; ?>
			</td>
			<td class="name">
				<?php echo trim($v['m_musicname']); ?>
			</td>
			<td class="singer">
				<?php echo trim($v['m_singer']); ?>
			</td>
			<td>
				<?php echo trim($v['m_time']); ?>
			</td>
			<td>
				<input type="button" id="<?php echo $v['id']; ?>" class="editBtn" value="编辑" />
			</td>
			<td>
				<a href="index.php?ctl=music&act=delete&id=<?php echo $v['id'];?>">
					<input type="button" class="deleteBtn" value="删除" />
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
		<input type="button" class="button" id="insertBtn" value="添加音乐" />
	</div>

	<a href="index.php?ctl=music&act=log" id="logDiv">
		<input type="button" class="button" id="logBtn" value="生成日志" />
	</a>
</div>

<div style="display:none;" id="insertForm">
	<p>插入</p>
	<form method="post" action="index.php?ctl=music&act=insert" onsubmit="return checkInsert()">
		<span>叶音</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="insertName" name="musicname" />
		<br>
		<span>演唱者</span>
		<input type="text" id="insertSinger" name="singer" />
		<br>
		<input type="button" class="button" id="insertCancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<div style="display:none" id="editForm">
	<p>编辑</p>
	<form method="post" action="index.php?ctl=music&act=edit" onsubmit="return checkEdit()"> 
		<span>叶音</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="editName" name="musicname" />
		<input type="hidden" id="id" name="id" />
		<br>
		<span>演唱者</span>
		<input type="text" id="editSinger" name="musicsinger">
		<br>
		<input type="button" class="button" id="editCancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<script type="text/javascript">
	$('.editBtn').click(function(){
		$('#insertForm').hide();
		$('#editName').val(trim($(this).parents().siblings('.name').text()));
		$('#editSinger').val(trim($(this).parents().siblings('.singer').text()));
		$('#id').val($(this).attr('id'));
		$('#editForm').show();
	});

	function checkInsert()
	{
		if(!trim($('#insertName').val()) || !trim($('#insertSinger').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}

	function checkEdit()
	{
		if(!trim($('#editMusicName').val()) || !trim($('#editMusicSinger').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}
</script>
<?php include(VIEWDIR.'foot.php'); ?>