<?php
class recorder extends modelfactory
{
	function get_all_record($table,$where = '')
	{
		$this->db->select($table,'*',$where,'time asc');
		$records = $this->db->getAll();
		return $records;
	}

	function get_oneday_record($table,$where)
	{
		$this->db->select($table,'*',$where,'time asc');
		$records = $this->db->getAll();
		return $records;
	}

	function insert($tablename,$arr)
	{
		$this->db->insert($tablename,$arr);
		return $this->db->query();
	}
}