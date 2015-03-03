<?php
class pagecore
{
	//判断传递参数的方法是不是post
	function isPost()
	{
		if(strtolower($_SERVER['REQUEST_METHOD']) =='post')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//返回GET方法经过转义处理后的参数
	//处理get方法中参数名为$key的参数，不存在则返回$default
	function getGet($key,$default = '')
	{
		if(isset($_GET[$key]))
		{
			//如果没有增加转义字符的话
			if(!get_magic_quotes_gpc())
			{
				//如果$_GET[$key]是数组的话，调用array_map()函数来对数组进行addslashes操作
                //否则直接对$_GET[$key]进行addslashes操作
                if(is_array($_GET[$key]))
                {
                	return array_map('addslashes',$_GET[$key]);
                }
                else
                {
                	return addslashes($_GET[$key]);
                }
			}

			//如果增加转义字符的话
			return $_GET[$key]; 
		}
		return $default;
	}

	//返回POST方法经过转义处理后的参数
	function getPost($key,$default = '')
	{
		if(isset($_POST[$key]))
		{
			if(!get_magic_quotes_gpc())
			{
				if(is_array($_POST[$key]))
				{
					return array_map('addslashes',$_POST[$key]);
				}
				else
				{
					return addslashes($_POST[$key]);
				}
			}
			return $_POST[$key];
		}
		return $default;
	}

	////返回POST方法或GET方法经过转义处理后的参数
	function getRequest($key,$default = '')
	{
		if(isset($_REQUEST[$key]))
		{
			if(!get_magic_quotes_gpc())
			{
				if(is_array($_REQUEST[$key]))
				{
					return array_map('addslashes',$_REQUEST[$key]);
				}
				else
				{
					return addslashes($_REQUEST[$key]);
				}
			}
			return $_REQUEST[$key];
		}
		return $default;
	}
}