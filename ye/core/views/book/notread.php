<?php include(VIEWDIR.'head.php'); ?>

<div class="toptitle">
	叶文之未完成
</div>

<div class="topLink">
	<span>当前位置：</span>
	<a href="index.php">叶</a>
	<span>-></span>
	<a href="index.php?ctl=book&act=index">叶文</a>
	<span>-></span>
	<span>叶文之未完成</span>
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
			<td width="100px">书名</td>
			<td width="100px">作者</td>
			<td width="100px">原因</td>
			<td width="50px">几页</td>
			<td width="100px">时间</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
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
				<?php echo $v['n_bookname']; ?>
			</td>
			<td class="bookauthor">
				<?php echo $v['n_author']; ?>
			</td>
			<td class="bookcause">
				<?php echo $v['n_cause']; ?>
			</td>
			<td class="bookpage">
				<?php echo $v['n_page']; ?>
			</td>
			<td>
				<?php echo $v['n_stoptime']; ?>
			</td>
			<td>
				<input type="button" id="<?php echo $v['id']; ?>" class="editBtn" value="编辑" />
			</td>
			<td>
				<a href="index.php?ctl=book&act=delete&type=notread&id=<?php echo $v['id'];?>">
					<input type="button" class="deleteBtn" value="删除" />
				</a>
			</td>
			<td>
				<a href="index.php?ctl=book&act=read&type=notread&id=<?php echo $v['id'];?>">
					<input type="button" class="readBtn" value="去读" />
				</a>
			</td>
			<td>
				<a href="index.php?ctl=book&act=showList&type=notread_c&id=<?php echo $v['id'];?>">
					<input type="button" class="c_list" value="评论列表" />
				</a>
			</td>
			<td>
				<a href="index.php?ctl=book&act=showList&type=notread_e&id=<?php echo $v['id'];?>">
					<input type="button" class="e_list" value="摘抄列表" />
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
	<a href="index.php?ctl=book&act=notread_log" id="logDiv">
		<input type="button" class="button" id="logBtn" value="生成日志" />
	</a>
</div>

<div style="display:none;" id="insertForm">
	<form method="post" action="index.php?ctl=book&act=insertBook&type=notread" onsubmit="return checkInsert()">
		<span>书&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="insertName" name="bookname" />
		<br>
		<span>作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;者</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="insertAuthor" name="author" />
		<br>
		<span>原&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;因</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" name="cause" />
		<br>
		<span>看到几页</span>
		<input type="text" name="page" />
		<br>
		<input class="button" type="button" id="insertCancel" value="取消" />
		<input class="button" type="submit" value="提交" />
	</form>
</div>

<div style="display:none" id="editForm">
	<form method="post" action="index.php?ctl=book&act=edit&type=notread" onsubmit="return checkEdit()"> 
		<span>书&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="editName" name="name" />
		<input type="hidden" id="id" name="id" />
		<br>
		<span>作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;者</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="editAuthor" name="author" />
		<br>
		<span>原&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;因</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="text" id="editCause" name="cause" />
		<br>
		<span>看到几页</span>
		<input type="text" id="editPage" name="page" />
		<br>
		<input type="button" class="button" id="editCancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<script type="text/javascript">
	$('.editBtn').click(function(){
		$('#show_c_listdiv').hide();
		$('#show_e_listdiv').hide();
		$('#insertForm').hide();
		$('#editName').val(trim($(this).parents().siblings('.bookname').text()));
		$('#editAuthor').val(trim($(this).parents().siblings('.bookauthor').text()));
		$('#editCause').val(trim($(this).parents().siblings('.bookcause').text()));
		$('#editPage').val(trim($(this).parents().siblings('.bookpage').text()));
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
<?php include(VIEWDIR.'book/ce.php'); ?>
<?php include(VIEWDIR.'foot.php'); ?>