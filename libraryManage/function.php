<?php
	//将元素从数组中删掉,完全删掉，区别于unset()
	function array_remove(&$arr, $offset) 
	{ 
		array_splice($arr, $offset, 1); 
	} 

	//删除
	function del($ele,&$arr)
	{
		if(in_array($ele,$arr))
		{
			$i = array_search($ele,$arr);
			array_remove($arr,$i);
		}
	} 

	//计算数组中元素的数目
	function calSum(&$studentArr,&$studentSum)
	{
		for($i = 0;$i < count($studentArr);$i++)
		{
			$studentSum[$i] = count($studentArr[$i]);
		}
	}

	//获取当前时间，用来创建Excel
	function getCurrentTime()
	{
		list($msec,$sec) = explode(" ",microtime());
		return (float)$msec + (float)$sec;
	}

?>