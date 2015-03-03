search = {
	init : function(){
		var headBox = $("#search-head"),
		navBox = headBox.find(".search-nav"),
		searchBox = headBox.find(".search-search"),
		searchInput = searchBox.find("input"),
		searchBtn = navBox.find(".search-user a.search"),		
		closeSearchBtn = searchBox.find("a.close"),
		advanceBtn = searchBox.find("#advanceSearch"),
		advanceContent = searchBox.find('#advanceContent'),

		isSearchClose = true,
		isMenuEnter = isCommEnter = false;
		isAdvance = false;

		closeSearchBtn.css({opacity:0});
		searchBox.on({
			mouseenter : function(){
				closeSearchBtn.animate({opacity:1},300);
			},
			mouseleave : function(){
				closeSearchBtn.animate({opacity:0},300);
			}
		});

		advanceBtn.on("click",function(e){
			if(isAdvance)
			{
				advanceContent.stop().animate({height:0},300,function(){
					$(this).css({display:"none"});
					isAdvance = false;					
				});
			}
			else
			{
				advanceContent.children().css({opacity:0});
				advanceContent.css({display:"block",height:0}).stop().animate({height:80},300);
				advanceContent.children().stop().delay(300).animate({opacity:1},500);
				isAdvance = true;
			}
			e.preventDefault();
		});

		searchBtn.on("click",function(){
			if(isSearchClose)
			{
				searchBox.children().css({opacity:0});
				searchBox.css({display:"block",height:0}).stop().animate({height:80},300);
				searchBox.children().stop().delay(300).animate({opacity:1},500);
				searchInput.focus().val("");
				$(this).addClass("current");
				isSearchClose = false;
			}
			else
			{
				searchBox.stop().animate({height:0},300,function(){
					$(this).css({display:"none"});
					isSearchClose = true;
					isAdvance = false;
				});
				$(this).removeClass("current");
			}
			return false;
		});

		closeSearchBtn.on("click",function(){
			searchBtn.click();
			return false;
		});
	}
};

$(document).ready(function(){
	search.init();
});

function submit_film()
{
	var form =$('#searchForm');
	form.attr("action","index.php?ctl=search&act=search_all_film");
	form.submit();
}

function submit_book()
{
	var form =$('#searchForm');
	form.attr("action","index.php?ctl=search&act=search_all_book");
	form.submit();
}

function submit_sentence()
{
	var form =$('#searchForm');
	form.attr("action","index.php?ctl=search&act=search_sentence");
	form.submit();
}

function submit_music()
{
	var form =$('#searchForm');
	form.attr("action","index.php?ctl=search&act=search_music");
	form.submit();
}

