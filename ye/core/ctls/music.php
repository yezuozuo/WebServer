<?php
class controller extends frontpage
{
	var $modelname = 'publicModel';
	var $tablename_music = 'music';

	function controller()
	{
		parent::frontpage();
		$this->model_music = & load_model($this->modelname);
	}

	//展示页面
	function index()
	{
		$page = $this->getGet('page',0);
		if(!$page)
		{
			$page = 1;
		}

		$musics = $this->model_music->getAll($page,$this->tablename_music);
		
		$pageurl = 'index.php?ctl=music&act=index&page=[#page#]';

		$this->output->set('musiclist',$musics['ls']);
		$this->output->set('pageset',pageshow($musics['total'],$musics['start'],$pageurl));
		$this->output->set('total_num',$musics['count']);

		$this->view->display('music/default.php');
	}

	//插入一条
	function insert()
	{
		$arr = array('m_musicname'=>$_POST['musicname'],
					 			 'm_singer'=>$_POST['singer'],
					 			 'm_time'=>date('Y-m-d h:m:s'));
		$flag = $this->model_music->insert($this->tablename_music,$arr);
		redirector_c('music','index');
	}

	//删除一条
	function delete()
	{
		$id = $this->getGet('id',0);
		$where = 'id='.$id;
		$this->model_music->delete($this->tablename_music,$where);
		redirector_c('music','index');
	}

	//编辑一条
	function edit()
	{
		$id = $_POST['id'];
		$musicname = $_POST['musicname'];
		$musicsinger = $_POST['musicsinger'];
		$where = 'id='.$id;
		$arr = array('m_musicname'=>$musicname,
					 			 'm_singer'=>$musicsinger);
		
		$this->model_music->edit($this->tablename_music,$where,$arr);
		redirector_c('music','index');
	}

	function log()
	{
		chmod(LOGDIR.'music.txt',0744);
		$filename = LOGDIR.'music.txt';
		$content = $this->model_music->log($this->tablename_music);
		$log = '序号'.'----'.'音乐名'.'----'.'演唱者'.'----'.'创建时间'."\n";
		if(is_writable($filename))
		{
			//追加模式
	    if(!$handle = fopen($filename,'w')) 
	    {
	      echo "不能打开文件 $filename";
	      exit;
	    }

	    if(fwrite($handle,$log) === FALSE) 
	    {
	      echo "不能写入到文件 $filename";
	      exit;
	    }

	    foreach($content as $key => $value) 
	    {
	    	//将$content写入到我们打开的文件中。
	    	$log = $key.'----'.$value['m_musicname'].'----'.$value['m_singer'].'----'.$value['m_time']."\n";
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