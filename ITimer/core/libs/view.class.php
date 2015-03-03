<?php
class View
{
	//要显示到页面上的view文件夹下的php文件
	//$tplFile = $template file模板文件
	var $tplFile;

	//构造函数
	function View($tplFile = '')
	{
		//如果$tplFile不为空的话
		if(empty($tplFile) == 0)
		{
			$this->tplFile = $tplFile;
		}		
	}

	//返回待输出的view内容
	function fetch($tplFile = '')
	{
		if(empty($tplFile) == 0)
		{
			$this->tplFile = $tplFile;
		}

		//清空缓存
		@ob_clean();
		//开始新的缓存
		ob_start();

		//模板中直接要使用的对象
		//所有在页面显示要显示的能量都存放在$res中
		$res =& get_output();

		if(file_exists(VIEWDIR.$this->tplFile))
		{
			include_once(VIEWDIR.$this->tplFile);
		}
		else
		{
			exit("tplFile doesn't exist");
		}

		//获取缓存内容
		$content = ob_get_clean();
		return str_replace('\xEF\xBB\xBF','',$content);
	}

	//输出到浏览器
	function display($tplFile = '')
	{
		if(empty($tplFile) == false)
		{
			$this->tplFile = $tplFile;
		}
		echo $this->fetch();
	}
}