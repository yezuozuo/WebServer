<?php
class bus extends modelfactory
{
	/*
		获取线路号码
		$table 查询的数据库表名
		$where 查询的约束
	*/
	function getNo($table,$where)
	{
		$return_record = array();
		$this->db->select($table,'no',$where,'no asc');
		$records = $this->db->getAll();
		foreach($records as $key => $value) 
		{	
			$return_record[$key] = $value['no'];
		}
		return $return_record;
	}

	/*
		获取位置信息
		$table 查询的数据库表名
		$where 查询的约束
	*/
	function getPosition($table,$where)
	{
		$return_record = array();
		$this->db->select($table,'*',$where);
		$records = $this->db->getAll();
		return $records;
	}
}