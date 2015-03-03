<?php
require_once(LIBDIR.'view.class.php');
require_once(INCDIR.'pagecore.php');
class frontpage extends pagecore
{
	function frontpage()
	{
		$this->output =& get_output();
		$this->view = new View();
		$this->db =& db();
	}
}