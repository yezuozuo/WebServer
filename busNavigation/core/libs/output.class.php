<?php
class output
{
	var $data = array();

	function set($key,$value)
	{
		$this->data[$key] = $value;
	}

	function get($key = '')
	{
		//如果键值为空的话返回原数组
		if(!$key)
		{
			return $this->data;
		}
		else
		{
			return isset($this->data[$key])?$this->data[$key]:'';
		}
	}
} 