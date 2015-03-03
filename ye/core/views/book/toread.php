<?php include(VIEWDIR.'head.php'); ?>

<div class="toptitle">
	叶文之要读
</div>

<div class="topLink">
	<span>当前位置：</span>
	<a href="index.php">叶</a>
	<span>-></span>
	<a href="index.php?ctl=book&act=index">叶文</a>
	<span>-></span>
	<span>叶文之要读</span>
	<br>
	<span class="total_count">
    共 
    <strong><?php echo $res->get('total_num');?></strong> 
    条记录
  </span>
</div>

<div>
	<table class="bigTablePosition">
		<tr>
			<td width="50px"></td>
			<td width="100px">叶文</td>
			<td width="100px">作者</td>
			<td width="50px">位置</td>
			<td width="100px">索书号</td>
			<td width="100px">备注</td>
			<td width="100px">创建时间</td>
			<td width="50px"></td>
			<td width="50px"></td>
			<td width="50px"></td>
		</tr>
		<?php
			$i = count($res->get('booklist'));
			foreach($res->get('booklist') as $v)
			{
		?>
		<tr>
			<td>
				<?php echo $i--; ?>
			</td>
			<td class="bookname">
				<?php echo $v['t_bookname']; ?>
			</td>
			<td class="bookauthor">
				<?php echo $v['t_author']; ?>
			</td>
			<td class="booklocate">
				<?php echo $v['t_locate']; ?>
			</td>
			<td class="bookISBN">
				<?php echo $v['t_ISBN']; ?>
			</td>
			<td class="bookremark">
				<?php echo $v['t_remark']; ?>
			</td>
			<td>
				<?php echo $v['t_createtime']; ?>
			</td>
			<td>
				<input type="button" id="<?php echo $v['id']; ?>" class="editBtn" value="编辑" />
			</td>
			<td>
				<a href="index.php?ctl=book&act=delete&type=toread&id=<?php echo $v['id'];?>">
					<input type="button" class="deleteBtn" value="删除" />
				</a>
			</td>
			<td>
				<a href="index.php?ctl=book&act=read&type=toread&id=<?php echo $v['id'];?>">
					<input type="button" class="readBtn" value="去读" />
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
	
	<a href="index.php?ctl=book&act=toread_log" id="logDiv">
		<input type="button" class="button" id="logBtn" value="生成日志" />
	</a>
</div>

<div style="display:none;" id="insertForm">
	<form method="post" action="index.php?ctl=book&act=insertBook&type=toread" onsubmit="return checkInsert()">
		<span>书名</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="insertName" name="bookname" />
		<br>
		<span>作者</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="insertAuthor" name="author" />
		<br>
		<span>评论</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="remark" />
		<br>
		<span>索书号</span>
		<input type="text" name="isbn" />
		<br>
		<div style="margin-left:-2%;">
			<span>位置</span>
			<select style="margin-left:3%;" name="locate" id="locate">
				<option>软院</option>
				<option>本部</option>
				<option>电子书</option>
				<option>都没有</option>
			</select>
		</div>
		<br>
		<input class="button" type="button" id="insertCancel" value="取消" />
		<input class="button" type="submit" value="提交" />
	</form>
</div>

<div style="display:none" id="editForm">
	<form method="post" action="index.php?ctl=book&act=edit&type=toread" onsubmit="return checkEdit()"> 
		<span>叶文</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="editName" name="name" />
		<input type="hidden" id="id" name="id" />
		<br>
		<span>叶源</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="editAuthor" name="author" />
		<br>
		<span>叶评</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="editRemark" name="remark" />
		<br>
		<span>索书号</span>
		<input type="text" id="editISBN" name="ISBN" />
		<br>
		<span>位置</span>
		<select name="locate" id="locate">
			<option>软院</option>
			<option>本部</option>
			<option>都没有</option>
		</select>
		<br>
		<input type="button" class="button" id="editCancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<script type="text/javascript">
	$('.editBtn').click(function(){
		$('#insertForm').hide();
		$('#editName').val(trim($(this).parents().siblings('.bookname').text()));
		$('#editAuthor').val(trim($(this).parents().siblings('.bookauthor').text()));
		$('#editISBN').val(trim($(this).parents().siblings('.bookISBN').text()));
		$('#editLocate').val(trim($(this).parents().siblings('.booklocate').text()));
		$('#editRemark').val(trim($(this).parents().siblings('.bookremark').text()));
		$('#id').val($(this).attr('id'));
		$('#editForm').show();
	});
	function checkInsert()
	{
		if(!trim($('#insertName').val()) || !trim($('#insertAuthor').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}
	function checkEdit()
	{
		if(!trim($('#editName').val()) || !trim($('#editAuthor').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}
</script>
<?php include(VIEWDIR.'foot.php'); ?>