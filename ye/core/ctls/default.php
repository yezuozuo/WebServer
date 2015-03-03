<?php
class controller extends frontpage
{
	function controller()
	{
		parent::frontpage();
	}

	function index()
	{
		$this->view->display('default.php');
	}
}
