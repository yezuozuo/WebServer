<?php
	//处理数据的方法
	function &db($name = 'default',$config = '')
	{
		global $db_config;
		static $database = array();

		if(!isset($database[$name]))
		{	
			if($name == 'default')
			{
				$config = $db_config;
			}

			require_once(LIBDIR.'db.class.php');
			$database[$name] =& new db($config);
		}
		return $database[$name];
	}

	//设置数据模型
	function &load_model($model)
	{
		static $models = array();
		if(!isset($models[$model]))
		{
			$modelpath = MODELDIR.$model.'.php';
			if(file_exists($modelpath))
			{
				require_once(INCDIR.'modelfactory.php');
				require_once($modelpath);
			}
			else
			{
				exit('加载'.$model.'模型出错！');
			}

			$models[$model] =& new $model;
		}
		return $models[$model];
	}

	//获取输出量
	function &get_output()
	{
		static $output = array();

		if(!isset($output[0]))
		{
			require_once(LIBDIR.'output.class.php');
			$output[0] =& new output();
		}

		return $output[0];
	}

	//运行普通用户模式
	function run()
	{
		//get controller
		$ctl = isset($_GET['ctl'])?$_GET['ctl']:'default';
		//get action 
		$act = isset($_GET['act'])?$_GET['act']:'index';

		if(file_exists(CTLDIR.$ctl.'.php'))
		{
			echo $ctl;
			require_once(INCDIR.'frontpage.php');
			require_once(CTLDIR.$ctl.'.php');

			$controller = new controller();

			//is_callable某一个方法是否属于某一个类
			//判断$act是否属于$controller对象(类)
			if(is_callable(array(&$controller,$act)))
			{
				//如果存在的话那么调用$controller类中的$act方法
				call_user_func(array(&$controller,$act));
			}
			else
			{
				showInfo('404 not found!',false);
			}
		}
		else
		{
			showInfo('404 not found!',false);
		}
	}