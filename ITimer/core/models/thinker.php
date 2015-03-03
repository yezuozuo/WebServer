<?php
class thinker extends modelfactory
{
	function get_all_think($table,$where = '')
	{
		$this->db->select($table,'*',$where,'time asc');
		$thinks = $this->db->getAll();
		return $thinks;
	}

	function insert($tablename,$arr)
	{
		$this->db->insert($tablename,$arr);
		return $this->db->query();
	}
	
	function delete($tablename,$where)
	{
		$this->db->delete($tablename,$where);
		return $this->db->query();
	}
}