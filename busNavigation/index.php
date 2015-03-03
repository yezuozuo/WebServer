<?php
	//error_reporting(E_ERROR);
	if (PHP_VERSION >= "5.1.0") 
	{
		date_default_timezone_set ('PRC');
	}
	
	if(!file_exists('config/config.php'))
	{
    	exit('找不到当前配置文件！');
	}

	header("Content-type: text/html; charset=utf-8");

	define('Version','1.1');

	//__FILE__显示当前文件的路径 
	define('FCPATH',__FILE__);

	//dirname() 函数返回路径中的目录部分。
	//ROOTDIR根目录
	define('ROOTDIR',dirname(FCPATH).'/');

	require_once('config/config.php');
	define('COREDIR',ROOTDIR.'core/');
	define('LIBDIR',COREDIR.'libs/');
	define('INCDIR',COREDIR.'include/');
	define('CTLDIR',COREDIR.'ctls/');
	define('VIEWDIR',COREDIR.'views/');
	define('MODELDIR',COREDIR.'models/');

	require_once(INCDIR.'base.php');
	require_once(INCDIR.'func.php');
	run();