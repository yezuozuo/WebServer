//创建Map实例
var map = new BMap.Map("map_display");   

//地图默认显示的中心坐标和地图级别
map.centerAndZoom(new BMap.Point(121.536184,38.888674), 16);

//设定地图可以滚动
map.enableScrollWheelZoom(true);

//左上角，添加比例尺
var top_left_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT});

//左上角，添加导航
var top_left_navigation = new BMap.NavigationControl();  

//右上角，仅包含平移和缩放按钮
var top_right_navigation = new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}); 

//在地图上添加控件和比例尺
map.addControl(top_left_control);        
map.addControl(top_left_navigation);     
map.addControl(top_right_navigation); 

//根据IP地址定位
function myFun(result)
{
	var cityName = result.name;
	map.setCenter(cityName);
	alert("当前定位城市:" + cityName);
}
var myCity = new BMap.LocalCity();
myCity.get(myFun);



//task1:查询公交线路
var busline = new BMap.BusLineSearch(map,{
	renderOptions:{map:map,panel:"map_needline_result"},
		onGetBusListComplete: function(result){
		}
});

function busSearch(){
	var busName = $('#route_input').val();
	busline.getBusList(busName);
}

//点击查询公交线路的查询按钮出发busSearch事件
$("#route_input_btn").click(function(){
	busSearch();
});


//task2：查询乘坐线路：
var routePolicy = [BMAP_TRANSIT_POLICY_LEAST_TIME,BMAP_TRANSIT_POLICY_LEAST_TRANSFER,BMAP_TRANSIT_POLICY_LEAST_WALKING,BMAP_TRANSIT_POLICY_AVOID_SUBWAYS];
var transit = new BMap.TransitRoute(map, {
		renderOptions: {map: map},
		policy: 0
	});
var transit1 = new BMap.TransitRoute(map, {
		renderOptions: {map: map, panel: "map_needline_result"}
	});

//点击查询乘坐线路的搜索按钮出发事件
$("#route_search_btn").click(function()
{
	//获得起始点的值
	var start = $('#suggestId_begin').val();
	
	//获得终点的值
	var end = $('#suggestId_end').val();

	//清除地图图层上的覆盖层
	map.clearOverlays(); 
	var i = $("#driving_way select").val();
	search(start,end,routePolicy[i]); 
	function search(start,end,route)
	{ 
		transit.setPolicy(route);
		transit.search(start,end);
	};
	transit1.search(start,end);

	//产生距离和时间
	var output = "从" + start + "到" + end + "坐公交需要";
	var searchComplete = function(results)
	{
		if(transit2.getStatus() != BMAP_STATUS_SUCCESS)
		{
			return ;
		}
		var plan = results.getPlan(0);

		//获取时间
		output += plan.getDuration(true) + "\n";

		//获取距离  
		output += plan.getDistance(true) + "\n";  
	}
	var transit2 = new BMap.TransitRoute(map, {renderOptions: {map: map},
		onSearchComplete: searchComplete,
		onPolylinesSet: function()
		{        
			setTimeout(function(){
				alert(output)
			},"1000");
		}
	});
	transit2.search(start,end);
});

//自动填充
function G(id)
{
		return document.getElementById(id);
}

//建立一个自动完成的对象
var route_begin = new BMap.Autocomplete(    
	{"input" : "suggestId_begin",
	 "location" : map
});

//建立一个自动完成的对象
var route_end = new BMap.Autocomplete(    
	{"input" : "suggestId_end",
	 "location" : map
});

//鼠标放在下拉列表上的事件
route_begin.addEventListener("onhighlight", function(e){  
	var str = "";
	var _value = e.fromitem.value;
	var value = "";
	if(e.fromitem.index > -1) 
	{
		value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
	}    
	str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
	
	value = "";
	if(e.toitem.index > -1){
		_value = e.toitem.value;
		value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
	}    
	str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
	G("searchResultPanel").innerHTML = str;
});

var myValue;
route_begin.addEventListener("onconfirm", function(e){    //鼠标点击下拉列表后的事件
var _value = e.item.value;
	myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
	G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
	setPlace();
});

//鼠标放在下拉列表上的事件
route_end.addEventListener("onhighlight", function(e){  
	var str = "";
	var _value = e.fromitem.value;
	var value = "";
	if(e.fromitem.index > -1){
		value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
	}    
	str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
	
	value = "";
	if(e.toitem.index > -1){
		_value = e.toitem.value;
		value = _value.province + _value.city +  _value.district +  _value.street +  _value.business;
	}    
	str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
	G("searchResultPanel").innerHTML = str;
});

//鼠标点击下拉列表后的事件
route_end.addEventListener("onconfirm", function(e) {    
	var _value = e.item.value;
	myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
	G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
	setPlace();
});

function setPlace()
{
	//清除地图上所有覆盖物
	map.clearOverlays();    
	function myFun()
	{
		//获取第一个智能搜索的结果
		var pp = local.getResults().getPoi(0).point;    
		map.centerAndZoom(pp, 18);

		//添加标注
		map.addOverlay(new BMap.Marker(pp));    
	}

	//智能搜索
	var local = new BMap.LocalSearch(map, { 
	  onSearchComplete: myFun
	});
	local.search(myValue);
}

//从服务器获取公交经度纬度显示公交的位置
function setPosition(longitude,latitude)
{
	var map = new BMap.Map("map_display");      
	var point = new BMap.Point(longitude,latitude);
	map.enableScrollWheelZoom(true);
	map.centerAndZoom(point, 16);
	
	//创建标注
	var marker = new BMap.Marker(point);  	

	//将标注添加到地图中
	map.addOverlay(marker);            

	//跳动的动画   
	marker.setAnimation(BMAP_ANIMATION_BOUNCE); 

	var geolocation = new BMap.Geolocation();
	geolocation.getCurrentPosition(function(r){
		if(this.getStatus() == BMAP_STATUS_SUCCESS){
			var mk = new BMap.Marker(r.point);
			map.addOverlay(mk);
			map.panTo(r.point);
			setPoint(r.point);
			alert('您的位置：'+r.point.lng+','+r.point.lat);
		}
		else {
			alert('failed'+this.getStatus());
		}        
	});

	function setPoint(mypoint) 
	{
		//起点
		var myP1 = mypoint;    
		alert(mypoint.lng);
		var point = new BMap.Point(longitude,latitude);

		//终点
		var myP2 = point;    		
		alert(point.lng);
		var myIcon = new BMap.Icon("img/head.png",new BMap.Size(64,64),{
			
			//图片的偏移量。为了是图片底部中心对准坐标点。
			imageOffset: new BMap.Size(0, 0)    
		  });

		//驾车实例
		var driving2 = new BMap.DrivingRoute(map, {renderOptions:{map: map, autoViewport: true}});    
		
		//显示一条公交线路
		driving2.search(myP1, myP2);    

		//驾车实例
		var driving = new BMap.DrivingRoute(map);    
		driving.search(myP1, myP2);
		driving.setSearchCompleteCallback(function(){

			//通过驾车实例，获得一系列点的数组
			var pts = driving.getResults().getPlan(0).getRoute(0).getPath();

			//获得有几个点    
			var paths = pts.length;    

			var carMk = new BMap.Marker(pts[0],{icon:myIcon});
			map.addOverlay(carMk);
			i = 0;
			function resetMkPoint(i)
			{
				carMk.setPosition(pts[i]);
				if(i < paths)
				{
					setTimeout(function(){
						i++;
						resetMkPoint(i);
					},100);
				}
			}
			setTimeout(function(){
				resetMkPoint(5);
			},100)
		});
	}
}


	