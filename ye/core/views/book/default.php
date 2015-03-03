<?php include(VIEWDIR.'head.php'); ?>

<div class="toptitle">
	叶文
</div>

<div class="topLink_t">
	<span>当前位置：</span>
	<a href="index.php">叶</a>
	<span>->叶文</span>
</div>

<div>
	<a href="index.php?ctl=book&act=show&type=toread">
		<input class="button" type="button" value="要读的书" />
	</a>
	<a href="index.php?ctl=book&act=show&type=haveread">
		<input class="button" type="button" value="读过的书" />
	</a>
	<br>
	<a href="index.php?ctl=book&act=show&type=reading">
		<input class="button" type="button" value="正在读的书" />
	</a>
	<a href="index.php?ctl=book&act=show&type=notread">
		<input class="button" type="button" value="未读完的书" />
	</a> 
</div>
<?php include(VIEWDIR.'foot.php'); ?>