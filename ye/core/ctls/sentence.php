<?php
class controller extends frontpage
{
	var $modelname = 'publicModel';
	var $tablename_sentence = 'sentence';

	function controller()
	{
		parent::frontpage();
		$this->model_sentence = & load_model($this->modelname);
	}

	//展示页面
	function index()
	{
		$page = $this->getGet('page',0);
		if(!$page)
		{
			$page = 1;
		}

		$sentences = $this->model_sentence->getAll($page,$this->tablename_sentence);
		
		$pageurl = 'index.php?ctl=sentence&act=index&page=[#page#]';

		$this->output->set('sentencelist',$sentences['ls']);
		$this->output->set('pageset',pageshow($sentences['total'],$sentences['start'],$pageurl));
		$this->output->set('total_num',$sentences['count']);

		$this->view->display('sentence/default.php');
	}

	//插入一条
	function insert()
	{
		$arr = array('s_content'=>$_POST['content'],
							   's_from'=>$_POST['from'],
							   's_time'=>date('Y-m-d h:m:s'));
		$flag = $this->model_sentence->insert($this->tablename_sentence,$arr);
		redirector_c('sentence','index');
	}

	//删除一条
	function delete()
	{
		$id = $this->getGet('id',0);
		$where = 'id='.$id;
		$this->model_sentence->delete($this->tablename_sentence,$where);
		redirector_c('sentence','index');
	}

	//编辑一条
	function edit()
	{
		$id = $_POST['id'];
		$sentenceContent = $_POST['sentenceContent'];
		$sentenceFrom = $_POST['sentenceFrom'];
		$where = 'id='.$id;
		$arr = array('s_content'=>$sentenceContent,
					 			 's_from'=>$sentenceFrom);
		
		$this->model_sentence->edit($this->tablename_sentence,$where,$arr);
		redirector_c('sentence','index');
	}

	function log()
	{
		chmod(LOGDIR.'sentence.txt',0744);
		$filename = LOGDIR.'sentence.txt';
		$content = $this->model_sentence->log($this->tablename_sentence);
		$log = '序号'.'----'.'来源'.'----'.'内容'.'----'.'创建时间'."\n";
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
	    	$log = $key.'----'.$value['s_from'].'----'.$value['s_content'].'----'.$value['s_time']."\n";
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