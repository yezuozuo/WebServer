<?php include('head.php'); ?>

<div id="searchFrame">
	<div id="search-wrap">
	  <div id="search-head">
	    <div class="search-search">
	      <div class="search-box">
	        <form action="index.php?ctl=search&act=search_all" method="post" id="searchForm" onsubmit="return check()">
	          <input type="text" id="searchContent" placeholder="如:从你的全世界路过" name='content' autocomplete="off">
	          <button>搜索</button>
	          <button id="advanceSearch">高级搜索</button>
	          <a class="close"></a>

	          <div id="advanceContent" style="display:none;">
							<button onclick="submit_film()">叶影</button>
							<button onclick="submit_book()">叶文</button>
							<button onclick="submit_sentence()">叶语</button>
							<button onclick="submit_music()">叶音</button>
						</div>

	        </form>
	      </div>
	    </div>

	    <div class="search-nav">
	      <div class="search-user">
	      	<a href="#" class="search">
	      		<b></b>
	      	</a>
	      </div>
	    </div>

	  </div>
	</div>
</div>

<div class="toptitle">叶</div>

<div>
	<a href="index.php?ctl=film&act=index">
		<input type="button" value="叶影" class="circle_button active" />
	</a>
	<a href="index.php?ctl=book&act=index">
		<input type="button" value="叶文" class="circle_button active" />
	</a>
	<a href="index.php?ctl=sentence&act=index">
		<input type="button" value="叶语" class="circle_button active" />
	</a>
	<a href="index.php?ctl=music&act=index">
		<input type="button" value="叶音" class="circle_button active" />
	</a>
</div>

<script type="text/javascript">
	$('#advanceSearch').click(function(){
		if($('#advanceSearch').html()=='高级搜索')
		{
			$('#advanceSearch').html('普通搜索');
			$('#advanceContent').show();
		}
		else
		{
			$('#advanceSearch').html('高级搜索');
			$('#advanceContent').hide();
		}
	});
</script>
<script type="text/javascript">
	function check()
	{
		if(trim($('#searchContent').val()) == '')
		{
			alert('搜索内容不能为空！');
			return false;
		}
	}
</script>
<?php include('foot.php'); ?>
