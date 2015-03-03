<?php

class controller extends frontpage
{
	var $modelName = 'publicModel';
	var $tablename_haveread = 'haveread';
	var $tablename_reading = 'reading';
	var $tablename_toread = 'toread';
	var $tablename_notread = 'notread';
	var $tablename_ce = 'commentandextract';
	var $navType = null;

	function controller()
	{
		parent::frontpage();
		$this->model_book = & load_model($this->modelName);
	}

	//导航
	function index()
	{
		$this->view->display('book/default.php');
	}

//-----------------------------------------------

	//展示
	function show()
	{
		$type = $this->getGet('type');
		switch($type)
		{
			case 'toread_c':
			case 'toread_e':
			case 'haveread_c':
			case 'haveread_e':
			case 'reading_c':
			case 'reading_e':
			case 'notread_c':
			case 'notread_e':
				$type = $this->navType;
				break;
			default:
				break;
		}
		switch($type) 
		{
			case 'toread':
				$tablename = $this->tablename_toread;
				$pageurl = 'index.php?ctl=book&act=toread&page=[#page#]';
				$view = 'book/toread.php';
				break;
			case 'haveread':
				$tablename = $this->tablename_haveread;
				$pageurl = 'index.php?ctl=book&act=haveread&page=[#page#]';
				$view = 'book/haveread.php';
				break;
			case 'reading':
				$tablename = $this->tablename_reading;
				$pageurl = 'index.php?ctl=book&act=reading&page=[#page#]';
				$view = 'book/reading.php';
				break;
			case 'notread':
				$tablename = $this->tablename_notread;
				$pageurl = 'index.php?ctl=book&act=notread&page=[#page#]';
				$view = 'book/notread.php';
				break;
			default:
				echo "ERROR!";
				exit(); 
				break;
		}
		$page = $this->getGet('page',0);
		if(!$page)
		{
			$page = 1;
		}

		$books = $this->model_book->getAll($page,$tablename);
		
		$this->output->set('booklist',$books['ls']);
		$this->output->set('pageset',pageshow($books['total'],$books['start'],$pageurl));
		$this->output->set('total_num',$books['count']);

		$this->view->display($view);
	}

	//插入书
	function insertBook()
	{
		$type = $this->getGet('type');
		switch($type) 
		{
			case 'toread':
				$tablename = $this->tablename_toread;
				$arr = array('t_bookname'=>$_POST['bookname'],
									   't_author'=>$_POST['author'],
									   't_ISBN'=>$_POST['isbn'],
									   't_remark'=>$_POST['remark'],
									   't_locate'=>$_POST['locate'],
									   't_createtime'=>date('Y-m-d H:i:s'));
				break;
			case 'haveread':
				$tablename = $this->tablename_haveread;
				break;
			case 'reading':
				$tablename = $this->tablename_reading;

				break;
			case 'notread':
				$tablename = $this->tablename_notread;
				$arr = array('n_bookname'=>$_POST['bookname'],
										 'n_author'=>$_POST['author'],
										 'n_cause'=>$_POST['cause'],
										 'n_page'=>$_POST['page'],
										 'n_stoptime'=>date('Y-m-d'));
				break;
			default:
				echo "ERROR!";
				exit();
				break;
		}
		$view = 'show';
		$flag = $this->model_book->insert($tablename,$arr);
		redirector_c_t('book',$view,$type);
	}
	//编辑
	function edit()
	{
		$type = $this->getGet('type');
		$id = $_POST['id'];
		$where = 'id='.$id;
		switch($type)
		{
			case 'toread':
				$tablename = $this->tablename_toread;
				$arr = array('t_bookname'=>$_POST['name'],
									   't_author'=>$_POST['author'],
									   't_locate'=>$_POST['locate'],
									   't_ISBN'=>$_POST['ISBN'],
									   't_remark'=>$_POST['remark']);
				break;
			case 'haveread':
				$tablename = $this->tablename_haveread;
				break;
			case 'reading':
				$tablename = $this->tablename_reading;

				break;
			case 'notread':
				$tablename = $this->tablename_notread;
				$arr = array('n_bookname'=>$_POST['name'],
							 			 'n_author'=>$_POST['author'],
							 			 'n_cause'=>$_POST['cause'],
							       'n_page'=>$_POST['page'],
							 			 'n_stoptime'=>date('Y-m-d'));
				break;
			default:
				echo "ERROR!";
				exit();
				break;
		}
		$view = 'show';
		$this->model_book->edit($tablename,$where,$arr);
		redirector_c_t('book',$view,$type);
	}

	//删除
	function delete()
	{
		$type = $this->getGet('type');
		$id = $this->getGet('id',0);
		$where = 'id='.$id;
		switch($type) 
		{
			case 'toread':
				$tablename = $this->tablename_toread;
				break;
			case 'haveread':
				$tablename = $this->tablename_haveread;
				break;
			case 'reading':
				$tablename = $this->tablename_reading;
				break;
			case 'notread':
				$tablename = $this->tablename_notread;
				break;
			default:
				echo "ERROR!";
				exit();
				break;
		}
		$view = 'show';
		$this->model_book->delete($tablename,$where);
		redirector_c_t('book',$view,$type);
	}

	//显示评论和摘抄列表
	function showList()
	{
		$type = $this->getGet('type');
		$id = $this->getGet('id',0);
		$where_t = 'id='.$id;
		switch($type)
		{
			case 'toread_c':
				$tablename = $this->tablename_toread;
				$where = "flag='t_c".$id."'";
				$field = 't_bookname';
				$flag = 1;
				$type_t = 'toread';
				break;
			case 'toread_e':
				$tablename = $this->tablename_toread;
				$where = "flag='t_d".$id."'";
				$field = 't_bookname';
				$flag = 2;
				$type_t = 'toread';
				break;
			case 'haveread_c':
				$tablename = $this->tablename_haveread;
				$where = "flag='h_c".$id."'";
				$field = 'h_bookname';
				$flag = 1;
				$type_t = 'haveread';
				break;
			case 'haveread_e':
				$tablename = $this->tablename_haveread;
				$where = "flag='h_d".$id."'";
				$field = 'h_bookname';
				$flag = 2;
				$type_t = 'haveread';
				break;
			case 'reading_c':
				$tablename = $this->tablename_reading;
				$where = "flag='r_c".$id."'";
				$field = 'r_bookname';
				$flag = 1;
				$type_t = 'reading';
				break;
			case 'reading_e':
				$tablename = $this->tablename_reading;
				$where = "flag='r_d".$id."'";
				$field = 'r_bookname';
				$flag = 2;
				$type_t = 'reading';
				break;
			case 'notread_c':
				$tablename = $this->tablename_notread;
				$where = "flag='n_c".$id."'";
				$field = 'n_bookname';
				$flag = 1;
				$type_t = 'notread';
				break;
			case 'notread_e':
				$tablename = $this->tablename_notread;
				$where = "flag='n_d".$id."'";
				$field = 'n_bookname';
				$flag = 2;
				$type_t = 'notread';
				break;
			default:
				echo "ERROR!";
				exit();
				break;
		}
		$view = 'show';
		$ce = $this->model_book->getCe($this->tablename_ce,$where);
		$book = $this->model_book->getOne($tablename,$where_t);
		$this->output->set('bookname',$book[0][$field]);
		$this->output->set('list',$ce);
		$this->output->set('show',$flag);
		$this->navType = $type_t;
		$this->show();
	}

	//显示评论和摘抄列表
	function insertCe()
	{
		$type = $this->getGet('type');
		switch($type) 
		{
			case 'toread_c':
				$id = 't_'.$_POST['c_id'];
				$content = $_POST['content'];
				$type_t = 'toread';
				break;
			case 'toread_e':
				$id = 't_'.$_POST['e_id'];
				$extract = $_POST['content'];
				$type_t = 'toread';
				break;
			case 'haveread_c':
				$id = 'h_'.$_POST['c_id'];
				$content = $_POST['content'];
				$type_t = 'haveread';
				break;
			case 'haveread_e':
				$id = 'h_'.$_POST['e_id'];
				$content = $_POST['content'];
				$type_t = 'haveread';
				break;
			case 'reading_c':
				$id = 'r_'.$_POST['c_id'];
				$content = $_POST['content'];
				$type_t = 'reading';
				break;
			case 'reading_e':
				$id = 'r_'.$_POST['e_id'];
				$content = $_POST['content'];
				$type_t = 'reading';
				break;
			case 'notread_c':
				$id = 'n_'.$_POST['c_id'];
				$content = $_POST['content'];
				$type_t = 'notread';
				break;
			case 'notread_e':
				$id = 'n_'.$_POST['e_id'];
				$content = $_POST['content'];
				$type_t = 'notread';
				break;
			default:
				echo "ERROR!";
				exit();
				break;
		}
		$view = 'show';

		$arr = array('flag'=>$id,
								 'content'=>$content);

		$this->model_book->insert($this->tablename_ce,$arr);
		redirector_c_t('book',$view,$type_t);
	}

	//去读
	function read()
	{
		$type = $this->getGet('type');
		$id = $this->getGet('id',0);
		$where = 'id='.$id;
		switch($type)
		{
			case 'toread':
				$tablename = $this->tablename_toread;
				$arr = $this->model_book->getOne($this->tablename_toread,$where);
				$insertArr = array('r_bookname'=>$arr[0]['t_bookname'],
													 'r_author'=>$arr[0]['t_author'],
													 'r_remark'=>$arr[0]['t_remark']);
				break;
			case 'haveread':
				break;
			case 'reading':
				break;
			case 'notread':
				$tablename = $this->tablename_notread;
				$arr = $this->model_book->getOne($this->tablename_notread,$where);
				$insertArr = array('r_bookname'=>$arr[0]['n_bookname'],
													 'r_author'=>$arr[0]['n_author'],
													 'r_remark'=>null);
				break;
			default:
				echo "ERROR!";
				exit();
				break;
		}
		$view = 'show';

		$this->model_book->doRecord($tablename,$where,$this->tablename_reading,$insertArr);
		redirector_c_t('book',$view,'reading');
	}

	function notread()
	{
		$arr = array();
		$id = $_POST['notread_id'];
		$id = explode('n',$id);
		$where = "id=".$id[1];
		$arr = $this->model_book->getOne($this->tablename_reading,$where);
		$insertArr = array('n_bookname'=>$arr[0]['r_bookname'],
											 'n_author'=>$arr[0]['r_author'],
											 'n_cause'=>$_POST['cause'],
											 'n_page'=>$_POST['page'],
											 'n_stoptime'=>date('Y-m-d'));

		$ce_where = "flag='r_c".$id[1]."' or flag='r_d".$id[1]."'";
		$ce_arr = $this->model_book->getCe($this->tablename_ce,$ce_where);
		$this->model_book->delCe($this->tablename_ce,$ce_where);

		$this->model_book->doRecord($this->tablename_reading,$where,$this->tablename_notread,$insertArr);

		$this->trans_notread($ce_arr);
		
		redirector_c_t('book','show','notread');
	}

	function trans_notread($ce_arr)
	{
		$where = 'id=(select max(id) from '.$this->tablename_notread.')';
		$arr = $this->model_book->getOne($this->tablename_notread,$where);
		$id = $arr[0]['id'];

		foreach($ce_arr as $v)
		{
			if(strpos($v['flag'],'c') != null)
			{
				$arr = array('flag'=>'n_c'.$id,
									   'content'=>$v['content']);
				$this->model_book->insertCe($this->tablename_ce,$arr);
			}
			if(strpos($v['flag'],'d') != null)
			{
				$arr = array('flag'=>'n_d'.$id,
									   'content'=>$v['content']);
				$this->model_book->insertCe($this->tablename_ce,$arr);
			}
		}
	}

	function haveread()
	{
		$arr = array();
		$id = $_POST['haveread_id'];
		$id = explode('h',$id);
		$where = 'id='.$id[1];

		$arr = $this->model_book->getOne($this->tablename_reading,$where);
		$insertArr = array('h_bookname'=>$arr[0]['r_bookname'],
											 'h_author'=>$arr[0]['r_author'],
											 'h_remark'=>$arr[0]['r_remark'],
											 'h_donetime'=>date('Y-m-d'),
											 'h_evaluation'=>$_POST['evaluation'],
											 'h_sort'=>$_POST['sort']);

		$ce_where = "flag='r_c".$id[1]."' or flag='r_d".$id[1]."'";
		$ce_arr = $this->model_book->getCe($this->tablename_ce,$ce_where);
		$this->model_book->delCe($this->tablename_ce,$ce_where);
		$this->model_book->doRecord($this->tablename_reading,$where,$this->tablename_haveread,$insertArr);
		
		$this->trans_haveread($ce_arr);

		redirector_c_t('book','show','haveread');
	}

	function trans_haveread($ce_arr)
	{
		$where = 'id=(select max(id) from '.$this->tablename_haveread.')';
		$arr = $this->model_book->getOne($this->tablename_haveread,$where);
		$id = $arr[0]['id'];

		foreach($ce_arr as $v)
		{
			if(strpos($v['flag'],'c') != null)
			{
				$arr = array('flag'=>'h_c'.$id,
									 'content'=>$v['content']);
				$this->model_book->insertCe($this->tablename_ce,$arr);
			}
			if(strpos($v['flag'],'d') != null)
			{
				$arr = array('flag'=>'h_d'.$id,
									 'content'=>$v['content']);
				$this->model_book->insertCe($this->tablename_ce,$arr);
			}
		}
	}

	function notread_log()
	{
		chmod(LOGDIR.'notread.txt',0744);
		$filename = LOGDIR.'notread.txt';
		$content = $this->model_book->log($this->tablename_notread);
		if(is_writable($filename))
		{
			//追加模式
	    if(!$handle = fopen($filename,'w')) 
	    {
	      echo "不能打开文件 $filename";
	      exit;
	    }

	    $log = '序号'.'----'.'书名'.'----'.'作者'.'----'.'看到的页数'."\n";
	    if(fwrite($handle,$log) === FALSE) 
	    {
	      echo "不能写入到文件 $filename";
	      exit;
	    }

	    foreach($content as $key => $value) 
	    {
	    	//将$content写入到我们打开的文件中。
	    	if($value['n_author'] == null)
	    	{
	    		$value['n_author'] = '无';
	    	}

	    	if($value['n_page'] == null)
	    	{
	    		$value['n_page'] = 0;
	    	}
	    	
	    	$log = $key.'----'.$value['n_bookname'].'----'.$value['n_author'].'----'.$value['n_page']."\n";
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

	function haveread_log()
	{
		chmod(LOGDIR.'haveread.txt',0744);
		$filename = LOGDIR.'haveread.txt';
		$content = $this->model_book->log($this->tablename_haveread);

		if(is_writable($filename))
		{
			//追加模式
	    if(!$handle = fopen($filename,'w')) 
	    {
	      echo "不能打开文件 $filename";
	      exit;
	    }
	    
	    $log = '序号'.'----'.'书名'.'----'.'作者'.'----'.'评论'.'----'.'完成时间'.'----'.'摘抄'.'----'.'分类'."\n";
	    if(fwrite($handle,$log) === FALSE) 
	    {
	      echo "不能写入到文件 $filename";
	      exit;
	    }

	    foreach($content as $key => $value) 
	    {
	    	//将$content写入到我们打开的文件中。
	    	if($value['h_author'] == null)
	    	{
	    		$value['h_author'] = '无';
	    	}

	    	if($value['h_donetime'] == null)
	    	{
	    		$value['h_donetime'] = 0;
	    	}

	    	if($value['h_remark'] == null)
	    	{
	    		$value['h_remark'] = '无';
	    	}

	    	if($value['h_evaluation'] == null)
	    	{
	    		$value['h_evaluation'] = '无';
	    	}

	    	if($value['h_sort'] == null)
	    	{
	    		$value['h_sort'] = '未分类';
	    	}
	    	
	    	$log = $key.'----'.$value['h_bookname'].'----'.$value['h_author'].'----'.$value['h_remark'].'----'.$value['h_donetime'].'----'.$value['h_evaluation'].'----'.$value['h_sort']."\n";
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

	function toread_log()
	{
		chmod(LOGDIR.'toread.txt',0744);
		$filename = LOGDIR.'toread.txt';
		$content = $this->model_book->log($this->tablename_toread);
		if(is_writable($filename))
		{
			//追加模式
	    if(!$handle = fopen($filename,'w')) 
	    {
	      echo "不能打开文件 $filename";
	      exit;
	    }
	    
	    $log = '序号'.'----'.'书名'.'----'.'作者'.'----'.'评论'.'----'.'ISBN'.'----'.'位置'.'----'.'创建时间'."\n";
	    if(fwrite($handle,$log) === FALSE) 
	    {
	      echo "不能写入到文件 $filename";
	      exit;
	    }

	    foreach($content as $key => $value) 
	    {
	    	//将$content写入到我们打开的文件中。
	    	if($value['t_author'] == null)
	    	{
	    		$value['t_author'] = '无';
	    	}

	    	if($value['t_remark'] == null)
	    	{
	    		$value['t_remark'] = '无';
	    	}

	    	if($value['t_ISBN'] == null)
	    	{
	    		$value['t_ISBN'] = '无';
	    	}

	    	if($value['t_locate'] == null)
	    	{
	    		$value['t_locate'] = '都没有';
	    	}
	    	
	    	$log = $key.'----'.$value['t_bookname'].'----'.$value['t_author'].'----'.$value['t_remark'].'----'.$value['t_ISBN'].'----'.$value['t_locate'].'----'.$value['t_createtime']."\n";
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

	function reading_log()
	{
		chmod(LOGDIR.'reading.txt',0744);
		$filename = LOGDIR.'reading.txt';
		$content = $this->model_book->log($this->tablename_reading);
		if(is_writable($filename))
		{
			//追加模式
	    if(!$handle = fopen($filename,'w')) 
	    {
	      echo "不能打开文件 $filename";
	      exit;
	    }
	    
	    $log = '序号'.'----'.'书名'.'----'.'作者'.'----'.'评论'."\n";
	    if(fwrite($handle,$log) === FALSE) 
	    {
	      echo "不能写入到文件 $filename";
	      exit;
	    }

	    foreach($content as $key => $value) 
	    {
	    	//将$content写入到我们打开的文件中。
	    	if($value['r_author'] == null)
	    	{
	    		$value['r_author'] = '无';
	    	}

	    	if($value['r_remark'] == null)
	    	{
	    		$value['r_remark'] = '无';
	    	}
	    	
	    	$log = $key.'----'.$value['r_bookname'].'----'.$value['r_author'].'----'.$value['r_remark']."\n";
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