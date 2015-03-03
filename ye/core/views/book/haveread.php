<?php include(VIEWDIR.'head.php'); ?>
<div class="toptitle">
	叶文之完成
</div>

<div class="topLink">
	<span>当前位置：</span>
	<a href="index.php">叶</a>
	<span>-></span>
	<a href="index.php?ctl=book&act=index">叶文</a>
	<span>-></span>
	<span>叶文之完成</span>
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
			<td width="100px">完成时间</td>
			<td width="100px">叶评</td>
			<td width="100px">分类</td>
			<td width="100px">备注</td>
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
				<?php echo $v['h_bookname']; ?>
			</td>
			<td class="bookauthor">
				<?php echo $v['h_author']; ?>
			</td>
			<td>
				<?php echo $v['h_donetime']; ?>
			</td>
			<td class="bookevaluation">
				<?php echo $v['h_evaluation']; ?>
			</td>
			<td class="booksort">
				<?php echo $v['h_sort']; ?>
			</td>
			<td class="bookremark">
				<?php echo $v['h_remark']; ?>
			</td>
			<td>
				<a href="index.php?ctl=book&act=showList&type=haveread_c&id=<?php echo $v['id'];?>">
					<input type="button" class="c_list" value="评论列表" />
				</a>
			</td>
			<td>
				<a href="index.php?ctl=book&act=showList&type=haveread_e&id=<?php echo $v['id'];?>">
					<input type="button" class="e_list" value="摘抄列表" />
				</a>
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
	<a href="index.php?ctl=book&act=haveread_log" id="logDiv">
		<input type="button" class="button" id="logBtn" value="生成日志" />
	</a>

</div>

<div style="display:none;" id="insert_c">
	<form method="post" action="index.php?ctl=book&act=insertCe&type=haveread_c" onsubmit="return checkInsertComment()">
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
	<form method="post" action="index.php?ctl=book&act=insertCe&type=haveread_e" onsubmit="return checkInsertExtract()">
		<span>
			<strong><?php echo $res->get('bookname');?></strong>
				添加摘抄
		</span>
		<br>
		<input type="text" id="insertExtract" name="content" />
		<input type="hidden" id="e_id" name="e_id" />
		<br>
		<input type="button" class="button" id="e_cancel" value="取消" />
		<input type="submit" class="button" value="提交" />
	</form>
</div>

<script type="text/javascript">
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
</script>

<?php include(VIEWDIR.'book/ce.php'); ?>
<?php include(VIEWDIR.'foot.php'); ?>