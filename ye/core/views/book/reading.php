<?php include(VIEWDIR.'head.php'); ?>

<div class="toptitle">
	叶文之在读
</div>

<div class="topLink">
	<span>当前位置：</span>
	<a href="index.php">叶</a>
	<span>-></span>
	<a href="index.php?ctl=book&act=index">叶文</a>
	<span>-></span>
	<span>叶文之在读</span>
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
			<td></td>
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
			<td>
				<?php echo $v['r_bookname']; ?>
			</td>
			<td>
				<?php echo $v['r_author']; ?>
			</td>
			<td>
				<a href="index.php?ctl=book&act=showList&type=reading_c&id=<?php echo $v['id'];?>">
					<input type="button" class="c_list" value="评论列表" />
				</a>
			</td>
			<td>
				<a href="index.php?ctl=book&act=showList&type=reading_e&id=<?php echo $v['id'];?>">
					<input type="button" class="e_list" value="摘抄列表" />
				</a>
			</td>
			<td>
				<input type="button" id="<?php echo 'n'.$v['id']; ?>" class="notread" value="不读" />
			</td>
			<td>
				<input type="button" id="<?php echo 'h'.$v['id']; ?>" class="haveread" value="读完" />
			</td>
			<td>
				<input type="button" id="<?php echo 'c'.$v['id']; ?>" class="add_c" value="添加评论" />
			</td>
			<td>
				<input type="button" id="<?php echo 'd'.$v['id']; ?>" class="add_e" value="添加摘抄" />
			</td>
		</tr>
		<?php
			}
		?>
	</table>

	<div class="pageset">
		<?php echo $res->get('pageset');?>
	</div>
	<a href="index.php?ctl=book&act=reading_log" id="logDiv">
		<input type="button" class="button" id="logBtn" value="生成日志" />
	</a>
</div>

<div style="display:none;" id="insert_c">
	<form method="post" action="index.php?ctl=book&act=insertCe&type=reading_c" onsubmit="return checkInertComment()">
		<span>
			<strong><?php echo $res->get('bookname');?></strong>
			添加评论
		</span>
		<br>
		<input type="text" id="insertComment" name="content" />
		<input type="hidden" id="c_id" name="c_id" />
		<br>
		<input type="button" class="button" id="c_cancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<div style="display:none;" id="insert_e">
	<form method="post" action="index.php?ctl=book&act=insertCe&type=reading_e" onsubmit="return checkInsertExtract()">
		<span>
			<strong><?php echo $res->get('bookname');?></strong>添加摘抄
		</span>
		<br>
		<input type="text" id="insertExtract" name="content" />
		<input type="hidden" id="e_id" name="e_id" />
		<br>
		<input type="button" class="button" id="e_cancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<div style="display:none;" id="reading_notread">
	<form method="post" action="index.php?ctl=book&act=notread" onsubmit="return checkNotread()">
		<span>不想读了</span>
		<br>
		<span>原因</span>
		<input type="text" id="insertCause" name="cause" />
		<input type="hidden" id="notread_id" name="notread_id" />
		<br>
		<span>看到几页</span>
		<input type="text" id="insertPage" name="page" />
		<br>
		<input type="button" class="button" id="notread_cancel" value="取消" />
		<input type="submit" class="button" id="notread_submit" value="提交" />
	</form>
</div>

<div style="display:none;" id="reading_haveread">
	<form method="post" action="index.php?ctl=book&act=haveread">
		<span>读完啦</span>
		<br>
		<span>评分</span>
		<select id="evaluation_show">
			<option>5</option>
			<option>4</option>
			<option>3</option>
			<option>2</option>
			<option>1</option>
		</select>
		<input type="hidden" id="haveread_id" name="haveread_id" />
		<br>
		<span>分类</span>
		<select id="sort_show">
			<option>技术</option>
			<option>人文</option>
			<option>现代小说</option>
			<option>古典小说</option>
		</select>
		<input type="hidden" name="sort" id="sort_trans" />
		<input type="hidden" name="evaluation" id="evaluation_trans" />
		<br>
		<input type="button" class="button" id="haveread_cancel" value="取消" />
		<input type="submit" class="button" id="haveread_submit" value="提交" />
	</form>
</div>

<script type="text/javascript">
	$('.notread').click(function(){
		$('#reading_notread').show();
		$('#reading_haveread').hide();
		$('#notread_id').val($(this).attr('id'));
	});
	$('#notread_cancel').click(function(){
		$('#reading_notread').hide();
	});
	$('#notread_submit').click(function(e){
		if(confirm('确定不想读了吗？') == 0)
		{
			e.preventDefault();
		}
	});
	$('.haveread').click(function(){
		$('#reading_haveread').show();
		$('#reading_notread').hide();
		$('#haveread_id').val($(this).attr('id'));
	});
	$('#haveread_submit').click(function(e){
		$('#evaluation_trans').val($('#evaluation_show').val());
		$('#sort_trans').val($('#sort_show').val());
		if(confirm('确定读完了吗？') == 0)
		{
			e.preventDefault();
		}
	});
	$('#haveread_cancel').click(function(){
		$('#reading_haveread').hide();
	});
	function checkInsertComment()
	{
		if(!trim($('#insertComment').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}

	function checkInsertExtract()
	{
		if(!trim($('#insertExtract').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}

	function checkNotread()
	{
		if(!trim($('#insertCause').val()) || !trim($('#insertPage').val()))
		{
			alert("输入内容不能为空！");
			return false;
		}
	}
</script>

<?php include(VIEWDIR.'book/ce.php'); ?>
<?php include(VIEWDIR.'foot.php'); ?>