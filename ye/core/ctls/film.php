<?php
class controller extends frontpage
{
	var $modelname = 'publicModel';
	var $tablename_towatch = 'towatch';
	var $tablename_havewatch = 'havewatch';
	var $type_towatch = 'towatch';
	var $type_havewatch = 'havewatch';

	function controller()
	{
		parent::frontpage();
		$this->model_film = & load_model($this->modelname);
	}

	//导航页
	function index()
	{
		$this->view->display('film/default.php');
	}

	//展示
	function show()
	{
		$type = $this->getGet('type');

		if($type == 'towatch')
		{
			$tablename = $this->tablename_towatch;
			$pageurl = 'index.php?ctl=film&act=show&type=towatch&page=[#page#]';
			$view = 'film/towatch.php';
		}
		else if($type == 'havewatch')
		{
			$tablename = $this->tablename_havewatch;
			$pageurl = 'index.php?ctl=film&act=show&type=havewatch&page=[#page#]';
			$view = 'film/havewatch.php';
		}
		else
		{
			echo "ERROR!";
			exit();
		}
		$page = $this->getGet('page',0);
		if(!$page)
		{
			$page = 1;
		}

		$films = $this->model_film->getAll($page,$tablename);
		
		$pageurl = 'index.php?ctl=film&act=show&type=towatch&page=[#page#]';
		$this->output->set('filmlist',$films['ls']);
		$this->output->set('pageset',pageshow($films['total'],$films['start'],$pageurl));
		$this->output->set('total_num',$films['count']);

		$this->view->display($view);
	}

	//插入
	function insert()
	{
		$type = $this->getGet('type');
		if($type == 'towatch')
		{
			$tablename = $this->tablename_towatch;
			$arr = array('t_filmname'=>$_POST['filmname'],
					 			   't_time'=>date('Y-m-d h:m:s'));
		}
		else if($type == 'havewatch')
		{
			$tablename = $this->tablename_havewatch;
			$arr = array('h_filmname'=>$_POST['filmname'],
								   'h_comment' =>$_POST['comment'],
					 			   'h_time'		 =>date('Y-m-d h:m:s'));
		}
		else
		{
			echo "ERROR!";
			exit();
		}
		$view = 'show';
		$flag = $this->model_film->insert($tablename,$arr);
		redirector_c_t('film',$view,$type);
	}

	//编辑
	function edit()
	{
		$type = $this->getGet('type');
		$id = $_POST['id'];
		$filmname = $_POST['filmname'];
		$where = 'id='.$id;
		if($type == 'towatch')
		{
			$tablename = $this->tablename_towatch;
			$arr = array('t_filmname'=>$filmname);
		}
		else if($type == 'havewatch')
		{
			$comment   = $_POST['comment'];
			$tablename = $this->tablename_havewatch;
			$arr 			 = array('h_filmname'=>$filmname,
					 						 	 'h_comment' =>$comment);
		}
		else
		{
			echo "ERROR!";
			exit();
		}
		$view = 'show';
		$this->model_film->edit($tablename,$where,$arr);
		redirector_c_t('film',$view,$type);
	}

	//删除
	function delete()
	{
		$id = $this->getGet('id',0);
		$where = 'id='.$id;
		$this->model_film->delete($this->tablename_towatch,$where);
		$this->navType = 'towatch';
		redirector_c_t('film','show','towatch');
	}

	//观看
	function watch()
	{
		$arr = array();
		$id = $this->getGet('id',0);
		$where = 'id='.$id;
		$arr = $this->model_film->getOne($this->tablename_towatch,$where);
		$insertArr = array('h_filmname'=>$arr[0]['t_filmname'],
					 				 	   'h_time'=>date('Y-m-d h:m:s'));
		$this->model_film->doRecord($this->tablename_towatch,$where,$this->tablename_havewatch,$insertArr);
		redirector_c_t('film','show','havewatch');
	}

	function towatch_log()
	{
		chmod(LOGDIR.'towatch.txt',0744);
		$filename = LOGDIR.'towatch.txt';
		$content = $this->model_film->log($this->tablename_towatch);
		if(is_writable($filename))
		{
			//追加模式
	    if(!$handle = fopen($filename,'w')) 
	    {
	      echo "不能打开文件 $filename";
	      exit;
	    }
	    $log = '序号'.'----'.'电影名'.'----'.'看完时间'.'----'.'评论'."\n";
	    if(fwrite($handle,$log) === FALSE) 
	    {
	      echo "不能写入到文件 $filename";
	      exit;
	    }

	    foreach($content as $key => $value) 
	    {
	    	//将$content写入到我们打开的文件中。	    	
	    	$log = $key.'----'.$value['t_filmname'].'----'.$value['t_time']."\n";
		    if(fwrite($handle,$log) === FALSE) 
		    {
		      echo "不能写入到文件 $filename";
		      exit;
		    }
	    }
	    echo "成功地将 $log 写入到文件$filename";
	    fclose($handle);
		} 
		else 
		{
		  echo "文件 $filename 不可写";
		}
		$this->view->display('log.php');
	}

	function havewatch_log()
	{
		chmod(LOGDIR.'havewatch.txt',0744);
		$filename = LOGDIR.'havewatch.txt';
		$content = $this->model_film->log($this->tablename_havewatch);
		if(is_writable($filename))
		{
			//追加模式
	    if(!$handle = fopen($filename,'w')) 
	    {
	      echo "不能打开文件 $filename";
	      exit;
	    }
	    $log = '序号'.'----'.'电影名'.'----'.'创建时间'."\n";
	    if(fwrite($handle,$log) === FALSE) 
	    {
	      echo "不能写入到文件 $filename";
	      exit;
	    }

	    foreach($content as $key => $value) 
	    {
	    	//将$content写入到我们打开的文件中。	
	    	if($value['h_comment'] == null)
	    	{
	    		$value['h_comment'] = '无';
	    	}

	    	$log = $key.'----'.$value['h_filmname'].'----'.$value['h_time'].'----'.$value['h_comment']."\n";
		    if(fwrite($handle,$log) === FALSE) 
		    {
		      echo "不能写入到文件 $filename";
		      exit;
		    }
	    }
	    echo "成功地将 $log 写入到文件$filename";
	    fclose($handle);
		} 
		else 
		{
		  echo "文件 $filename 不可写";
		}
		$this->view->display('log.php');
	}
}