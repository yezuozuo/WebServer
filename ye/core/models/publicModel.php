<?php
class publicModel extends modelfactory
{
	//获取所有记录
	function getAll($page = null,$table,$where = '')
	{
		$this->db->select($table,'*',$where,'id desc');
		if($page)
		{
			$records = $this->db->toPage($page,PAGE_SET);
		}
		else
		{
			$records = $this->db->getAll();
		}
		return $records;
	}

	//获取一个记录
	function getOne($tablename,$where)
	{
		$this->db->select($tablename,'*',$where);
		$record = $this->db->getAll();
		return $record;
	}

	//插入一个记录
	function insert($tablename,$arr)
	{
		$this->db->insert($tablename,$arr);
		return $this->db->query();
	}

	//编辑一个记录
	function edit($tablename,$where,$arr)
	{	
		$this->db->update($tablename,$where,$arr);
		return $this->db->query();
	}

	//删除一个记录
	function delete($tablename,$where)
	{
		$this->db->delete($tablename,$where);
		return $this->db->query();
	}

	//读一个记录
	function doRecord($tablename,$where,$inserTabeleName,$insertArr)
	{
		$this->insert($inserTabeleName,$insertArr);
		$this->delete($tablename,$where);
		return $this->db->query();
	}

	//不读一个记录
	function notDoRecord($tablename,$where,$inserTabeleName,$insertArr)
	{
		$this->insert($inserTabeleName,$insertArr);
		$this->delete($tablename,$where);
		return $this->db->query();
	}

	//获取摘抄和评论
	function getCe($tablename,$where)
	{
		$this->db->select($tablename,'*',$where);
		$ce = $this->db->getAll();
		return $ce;
	}

	//删除摘抄和评论
	function delCe($tablename,$where)
	{
		$this->db->delete($tablename,$where);
		return $this->db->query();
	}

	//插入摘抄或评论
	function insertCe($tablename,$arr)
	{
		$this->db->insert($tablename,$arr);
		return $this->db->query();
	}

	//查找
	function doSearch($tablename,$where)
	{	
		$this->db->select($tablename,'*',$where);
		$arr = $this->db->getAll();
		return $arr;
	}

	//日志
	function log($tablename)
	{
		$this->db->select($tablename,'*');
		$arr = $this->db->getAll();
		return $arr;
	}
}