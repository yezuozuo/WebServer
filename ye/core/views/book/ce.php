<?php 
	if($res->get('show') == 1)
	{
?>
<div class="showList" id="show_c_listdiv">
	<span>
		<strong>
			<?php
				echo $res->get('bookname');
			?>
		</strong>
		之评论列表
	</span>
	<br>
	<span class="total_count">
    共 
    <strong><?php echo count($res->get('list')); ?></strong> 
    条记录
  </span>
	<br>
	<input type="button" class="button" value="隐藏" id="c_list_cancel" />
	<div id="show_c_listcontent">
		<table>
			<tr>
				<td width="50px"></td>
				<td width="200px"></td>
			</tr>
			<?php
				$i = 0;
				foreach($res->get('list') as $v)
				{
					echo "<tr>";
					echo "<td>".$i++."</td>";
					echo "<td>".$v['content']."</td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>
</div>
<?php 
	}
?>

<?php
	if($res->get('show') == 2)
	{
?>
<div class="showList" id="show_e_listdiv">
	<span>
		<strong>
			<?php
				echo $res->get('bookname');
			?>
		</strong>
		之摘抄列表
	</span>
	<br>
	<span class="total_count">
    共 
    <strong><?php echo count($res->get('list')); ?></strong> 
    条记录
  </span>
	<br>
	<input type="button" class="button" value="隐藏" id="e_list_cancel" />
	<div id="show_e_listcontent">
		<table>
			<tr>
				<td width="50px"></td>
				<td width="200px"></td>
			</tr>
			<?php 
				$i = 0;
				foreach($res->get('list') as $v)
					{
						echo "<tr>";
						echo "<td>".$i++."</td>";
						echo "<td>".$v['content']."</td>";
						echo "</tr>";
					}
			?>
		</table>
	</div>
</div>
<?php 
	}
?>