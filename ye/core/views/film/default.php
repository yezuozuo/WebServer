<?php include(VIEWDIR.'head.php'); ?>

<div class="toptitle">
	叶影
</div>

<div class="topLink_t">
	<span>当前位置：</span>
	<a href="index.php">叶</a>
	<span>->叶影</span>
</div>

<div>
	<a href="index.php?ctl=film&act=show&type=towatch">
		<input class="button" type="button" value="To" />
	</a>
	<a href="index.php?ctl=film&act=show&type=havewatch">
		<input class="button" type="button" value="Done" />
	</a>
</div>
<?php include(VIEWDIR.'foot.php'); ?>