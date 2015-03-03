<?php
class controller extends frontpage
{
	//模型名称
	var $model_name = 'bus';
	//数据库表名
	var $table_name = 'station';
	var $table_name_position = 'runningPoint';

	//构造函数，调用父类的构造函数并且创建模型
	function controller()
	{
		parent::frontpage();
		$this->model = & load_model($this->model_name);
	}

	//显示默认页面
	function index()
	{
		$this->view->display('default.php');
	}

	//处理callout请求
	function callout()
	{
		//获得从前台传来的参数值，即线路号码
		$no = $_POST['running_no'];
		$where = "no=".$no;

		//从model获得从数据库查询来的位置信息，以数组的形式储存
		$position = $this->model->getPosition($this->table_name_position,$where);
		
		//如果查询到结果的话，设定flag和查询到的信息
		if(count($position))
		{
			$this->output->set('pos_flag',1);
			$this->output->set('positionList',$position);
		}

		//否则设定flag为0，页面上不做显示
		else
		{
			$this->output->set('pos_flag',0);
		}

		//显示页面
		$this->view->display('default.php');
	}

	//处理check请求
	function check()
	{
		//获得从前台传来的参数值，即车站信息
		$station = $_POST['station'];

		//采用模糊查询
		$where = "station like '%".$station."%'";

		//从model获得从数据库查询来的线路信息，以数组的形式储存
		$no = $this->model->getNo($this->table_name,$where);

		//如果查询到结果的话，设定flag和查询到的信息并返回车站的信息
		if(count($no))
		{
			$this->output->set('flag',1);
			$this->output->set('station',$station);
			$this->output->set('noList',$no);
		}

		//否则设定flag为0，页面上不做显示
		else
		{
			$this->output->set('station',$station);
			$this->output->set('flag',0);
		}

		//显示页面
		$this->view->display('default.php');	
	}
}	