<?php include(VIEWDIR.'head.php'); ?>

<div class="toptitle">
	叶语
</div>

<div class="topLink">
	<span>当前位置：</span>
	<a href="index.php">叶</a>
	<span>-></span>
	<span>叶语</span>
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
			<td width="150px">叶语</td>
			<td width="150px">叶源</td>
			<td width="100px">创建时间</td>
			<td></td>
			<td></td>
		</tr>
		<?php
			$i = count($res->get('sentencelist'));
			foreach($res->get('sentencelist') as $v)
			{
		?>
		<tr>
			<td>
				<?php echo $i--; ?>
			</td>
			<td class="content">
				<?php echo trim($v['s_content']); ?>
			</td>
			<td class="from">
				<?php echo trim($v['s_from']); ?>
			</td>
			<td>
				<?php echo trim($v['s_time']); ?>
			</td>
			<td>
				<input type="button" id="<?php echo $v['id']; ?>" class="editBtn" value="编辑" />
			</td>
			<td>
				<a href="index.php?ctl=sentence&act=delete&id=<?php echo $v['id'];?>">
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
		<input type="button" class="button" id="insertBtn" value="添加微言微语" />
	</div>

	<a href="index.php?ctl=sentence&act=log" id="logDiv">
		<input type="button" class="button" id="logBtn" value="生成日志" />
	</a>
</div>

<div style="display:none;" id="insertForm">
	<p>插入</p>
	<form method="post" action="index.php?ctl=sentence&act=insert" onsubmit="return checkInsert()">
		<span>叶语</span>
		<input type="text" id="insertContent" name="content" />
		<br>
		<span>叶源</span>
		<input type="text" id="insertFrom" name="from" />
		<br>
		<input type="button" class="button" id="insertCancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<div style="display:none" id="editForm">
	<p>编辑</p>
	<form method="post" action="index.php?ctl=sentence&act=edit" onsubmit="return checkEdit()"> 
		<span>叶语</span>
		<input type="text" id="editContent" name="sentenceContent" />
		<br>
		<input type="hidden" id="id" name="id" />
		<span>叶源</span>
		<input type="text" id="editFrom" name="sentenceFrom">
		<br>
		<input type="button" class="button" id="editCancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<script type="text/javascript">
	$('.editBtn').click(function(){
		$('#insertForm').hide();
		$('#editContent').val(trim($(this).parents().siblings('.content').text()));
		$('#editFrom').val(trim($(this).parents().siblings('.from').text()));
		$('#id').val($(this).attr('id'));
		$('#editForm').show();
	});
	function checkInsert()
	{
		if(!trim($('#insertContent').val()) || !trim($('#insertFrom').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}
	function checkEdit()
	{
		if(!trim($('#editContent').val()) || !trim($('#editFrom').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}
</script>
<?php include(VIEWDIR.'foot.php'); ?>