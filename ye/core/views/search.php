<?php include('head.php'); ?>

<div class="toptitle">
	叶的搜索结果
</div>

<div class="topLink_t">
	<a href="index.php">叶</a>
	<span>-></span>
	<span>叶的搜索结果</span>
	<span id="searchResultSum">
		共得到
		<?php echo $res->get('total_record'); ?>
		个搜索结果：
	</span>
</div>

<div id="searchResult">
	<div>
		<?php
			if($res->get('name_towatch') 
				|| $res->get('name_havewatch'))
			{
		?>
		<div id="film">
			<span class="title_1">叶影</span>
			<?php
				if($res->get('name_towatch'))
				{
			?>
			<div>
				<div id="towatch">
					<table>
						<tr>
							<td></td>
							<td>叶影</td>
							<td>创建时间</td>
						</tr>
						<span class="title_2">要观看的</span>
						<span>-></span>
						<span class="title_3">通过叶影的搜索结果</span>
						<?php
							$i = count($res->get('name_towatch'));
							if($i)
							{
								foreach($res->get('name_towatch') as $v)
								{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['t_filmname'] ?>
							</td>
							<td>
								<?php echo $v['t_time'] ?>
							</td>
						</tr>
						<?php
								}
							}
						?>
					</table>
				</div>
				<?php
					}
				?>


				<?php
					if($res->get('name_havewatch'))
					{
				?>
				<div id="havewatch">
					<table>
						<tr>
							<td></td>
							<td>叶影</td>
							<td>创建时间</td>
						</tr>
						<span class="title_2">已经观看的</span>
						<span>-></span>
						<span class="title_3">通过叶影的搜索结果</span>
						<?php
							$i = count($res->get('name_havewatch'));
							if($i)
							{
								foreach($res->get('name_havewatch') as $v)
								{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['h_filmname'] ?>
							</td>
							<td>
								<?php echo $v['h_time'] ?>
							</td>
						</tr>
						<?php
								}
							}
						?>
					</table>
				</div>
				<?php
					}
				?>

			</div>
		</div>
		<?php
			}
		?>

		<?php
			if($res->get('name_toread')
				|| $res->get('author_toread')
				|| $res->get('name_haveread') 
				|| $res->get('author_haveread')
				|| $res->get('name_reading')
				|| $res->get('author_reading')
				|| $res->get('name_notread')
				|| $res->get('author_notread'))
			{
		?>
		<div id="book">
			<span>叶文</span>
			<div>
				<?php
					if($res->get('name_toread')
						|| $res->get('author_toread'))
					{
				?>
				<div id="toread">
					<span>要看的书</span>
					<?php
						if($res->get('name_toread'))
						{
					?>
					<p>通过叶文的搜索结果</p>
					<table>
						<tr>
							<td></td>
							<td>叶文</td>
							<td>作者</td>
							<td>所在图书馆</td>
							<td>索书号</td>
							<td>备注</td>
							<td>创建时间</td>
						</tr>
						<?php
							$i = count($res->get('name_toread'));
							foreach($res->get('name_toread') as $v)
							{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['t_bookname'] ?>
							</td>
							<td>
								<?php echo $v['t_author'] ?>
							</td>
							<td>
								<?php echo $v['t_locate'] ?>
							</td>
							<td>
								<?php echo $v['t_ISBN'] ?>
							</td>
							<td>
								<?php echo $v['t_remark'] ?>
							</td>
							<td>
								<?php echo $v['t_createtime'] ?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
					?>

					<?php
						if($res->get('author_toread'))
						{
					?>
					<p>通过作者的搜索结果</p>
					<table>
						<tr>
							<td></td>
							<td>叶文</td>
							<td>作者</td>
							<td>所在图书馆</td>
							<td>索书号</td>
							<td>备注</td>
							<td>创建时间</td>
						</tr>
						
						<?php
							$i = count($res->get('author_toread'));
							foreach($res->get('author_toread') as $v)
							{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['t_bookname'] ?>
							</td>
							<td>
								<?php echo $v['t_author'] ?>
							</td>
							<td>
								<?php echo $v['t_locate'] ?>
							</td>
							<td>
								<?php echo $v['t_ISBN'] ?>
							</td>
							<td>
								<?php echo $v['t_remark'] ?>
							</td>
							<td>
								<?php echo $v['t_createtime'] ?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
					?>
				</div>
				<?php
					}
				?>

				<?php
					if($res->get('name_haveread')
						|| $res->get('author_haveread'))
					{
				?>
				<div id="haveread">
					<span>读过的书</span>
					<?php
						if($res->get('name_haveread'))
						{
					?>
					<p>通过叶文的搜索结果</p>
					<table>
						<tr>
							<td></td>
							<td>叶文</td>
							<td>作者</td>
							<td>完成时间</td>
							<td>叶评</td>
							<td>分类</td>
							<td>备注</td>
						</tr>
						
						<?php
							$i = $res->get('name_haveread');
							foreach($res->get('name_haveread') as $v)
							{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['h_bookname'] ?>
							</td>
							<td>
								<?php echo $v['h_author'] ?>
							</td>
							<td>
								<?php echo $v['h_donetime'] ?>
							</td>
							<td>
								<?php echo $v['h_evaluation'] ?>
							</td>
							<td>
								<?php echo $v['h_sort'] ?>
							</td>
							<td>
								<?php echo $v['h_remark'] ?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
					?>

					<?php
						if($res->get('author_haveread'))
						{
					?>
					<p>通过作者的搜索结果</p>
					<table>
						<tr>
							<td></td>
							<td>叶文</td>
							<td>作者</td>
							<td>完成时间</td>
							<td>叶评</td>
							<td>分类</td>
							<td>备注</td>
						</tr>
						<?php
							$i = count($res->get('author_haveread'));
							foreach($res->get('author_haveread') as $v)
							{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['h_bookname'] ?>
							</td>
							<td>
								<?php echo $v['h_author'] ?>
							</td>
							<td>
								<?php echo $v['h_donetime'] ?>
							</td>
							<td>
								<?php echo $v['h_evaluation'] ?>
							</td>
							<td>
								<?php echo $v['h_sort'] ?>
							</td>
							<td>
								<?php echo $v['h_remark'] ?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
					?>
				</div>
				<?php
					}
				?>

				<?php
					if($res->get('name_reading') 
						|| $res->get('author_reading'))
					{
				?>
				<div id="reading">
					<span>正在读的书</span>
					<?php
						if($res->get('name_reading'))
						{
					?>
					<p>通过叶文的搜索结果</p>
					<table>
						<tr>
							<td></td>
							<td>叶文</td>
							<td>作者</td>
						</tr>
						<?php
							$i = count($res->get('name_reading'));
							foreach($res->get('name_reading') as $v)
							{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['r_bookname'] ?>
							</td>
							<td>
								<?php echo $v['r_author'] ?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
					?>

					<?php
						if($res->get('author_reading'))
						{
					?>
					<p>通过作者的搜索结果</p>
					<table>
						<tr>
							<td></td>
							<td>叶文</td>
							<td>作者</td>
						</tr>
						<?php
							$i = count($res->get('author_reading'));
							foreach($res->get('author_reading') as $v)
							{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['r_bookname'] ?>
							</td>
							<td>
								<?php echo $v['r_author'] ?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
					?>
				</div>
				<?php
					}
				?>

				<?php
					if($res->get('name_notread')
						|| $res->get('author_notread'))
					{
				?>
				<div id="notread">
					<span>没读的书</span>
					<?php
						if($res->get('name_notread'))
						{
					?>
					<p>通过叶文的搜索结果</p>
					<table>
						<tr>
							<td></td>
							<td>叶文</td>
							<td>作者</td>
							<td>原因</td>
							<td>看到几页</td>
							<td>终止时间</td>
						</tr>
						
						<?php
							$i = count($res->get('name_notread'));
							foreach($res->get('name_notread') as $v)
							{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['n_bookname'] ?>
							</td>
							<td>
								<?php echo $v['n_author'] ?>
							</td>
							<td>
								<?php echo $v['n_cause'] ?>
							</td>
							<td>
								<?php echo $v['n_page'] ?>
							</td>
							<td>
								<?php echo $v['n_stoptime'] ?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
					?>

					<?php
						if($res->get('author_notread'))
						{
					?>
					<p>通过作者的搜索结果</p>
					<table>
						<tr>
							<td></td>
							<td>叶文</td>
							<td>作者</td>
							<td>原因</td>
							<td>看到几页</td>
							<td>终止时间</td>
						</tr>
						<?php
							$i = count($res->get('author_notread'));
							foreach($res->get('author_notread') as $v)
							{
						?>
						<tr>
							<td>
								<?php echo $i--; ?>
							</td>
							<td>
								<?php echo $v['n_bookname'] ?>
							</td>
							<td>
								<?php echo $v['n_author'] ?>
							</td>
							<td>
								<?php echo $v['n_cause'] ?>
							</td>
							<td>
								<?php echo $v['n_page'] ?>
							</td>
							<td>
								<?php echo $v['n_stoptime'] ?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
					?>
				</div>
				<?php
					}
				?>

			</div>
		</div>
		<?php
			}
		?>

		<?php
			if($res->get('from_sentence')
				|| $res->get('content_sentence'))
			{
		?>
		<div id="sentence">
			<span>叶语</span>
			<?php
				if($res->get('content_sentence'))
				{
			?>
			<p>通过叶语的搜索结果</p>
			<table>
				<tr>
					<td></td>
					<td>叶语</td>
					<td>叶源</td>
					<td>创建时间</td>
				</tr>
				
				<?php
					$i = count($res->get('content_sentence'));
					foreach($res->get('content_sentence') as $v)
					{
				?>
				<tr>
					<td>
						<?php echo $i--; ?>
					</td>
					<td>
						<?php echo $v['s_content'] ?>
					</td>
					<td>
						<?php echo $v['s_from'] ?>
					</td>
					<td>
						<?php echo $v['s_time'] ?>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			<?php
				}
			?>

			<?php
				if($res->get('from_sentence'))
				{
			?>
			<p>通过叶源的搜索结果</p>
			<table>
				<tr>
					<td></td>
					<td>叶语</td>
					<td>叶源</td>
					<td>创建时间</td>
				</tr>
				<?php
					$i = count($res->get('from_sentence'));
					foreach($res->get('from_sentence') as $v)
					{
				?>
				<tr>
					<td>
						<?php echo $i--; ?>
					</td>
					<td>
						<?php echo $v['s_content'] ?>
					</td>
					<td>
						<?php echo $v['s_from'] ?>
					</td>
					<td>
						<?php echo $v['s_time'] ?>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			<?php
				}
			?>
		</div>
		<?php
			}
		?>

		<?php
			if($res->get('name_music')
				|| $res->get('author_music'))
			{
		?>
		<div id="music">
			<span>叶音</span>
			<?php
				if($res->get('name_music'))
				{
			?>
			<p>通过音乐名的搜索结果</p>
			<table>
				<tr>
					<td></td>
					<td>音乐名</td>
					<td>演唱者</td>
					<td>创建时间</td>
				</tr>
				
				<?php
					$i = count($res->get('name_music'));
					foreach($res->get('name_music') as $v)
					{
				?>
				<tr>
					<td>
						<?php echo $i--; ?>
					</td>
					<td>
						<?php echo $v['m_musicname'] ?>
					</td>
					<td>
						<?php echo $v['m_singer'] ?>
					</td>
					<td>
						<?php echo $v['m_time'] ?>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			<?php
				}
			?>

			<?php
				if($res->get('author_music'))
				{
			?>
			<p>通过演唱者的搜索结果</p>
			<table>
				<tr>
					<td></td>
					<td>音乐名</td>
					<td>演唱者</td>
					<td>创建时间</td>
				</tr>
				<?php
					$i = count($res->get('author_music'));
					foreach($res->get('author_music') as $v)
					{
				?>
				<tr>
					<td>
						<?php echo $i--; ?>
					</td>
					<td>
						<?php echo $v['m_musicname'] ?>
					</td>
					<td>
						<?php echo $v['m_singer'] ?>
					</td>
					<td>
						<?php echo $v['m_time'] ?>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
			<?php
				}
			?>
		</div>
		<?php
			}
		?>

	</div>
</div>
<?php include('foot.php'); ?>