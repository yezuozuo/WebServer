<?php 
class ModelFactory
{
	function ModelFactory()
	{
		$this->output =& get_output();
		$this->db =& db();
	}
}