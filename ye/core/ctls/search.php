<?php
class controller extends frontpage
{
	var $modelName = 'publicModel';
	var $content;
	var $i;
	var $flag;
	var $flagArr;

	function controller()
	{
		parent::frontpage();
		$this->model_search = & load_model($this->modelName); 
		$this->content = $_POST['content'];
		$this->i = 0;
		$this->flag = false;
		//$this->flagArr = array('')
	}
	
	function search_all()
	{
		$this->flag = true;
		$this->search_all_book();
		$this->search_all_film();
		$this->search_music();
		$this->search_sentence();
		$this->total_record();
		$this->view->display('search.php');
	}

	function search_all_book()
	{
		$this->search_toread_book();
		$this->search_haveread_book();
		$this->search_reading_book();
		$this->search_notread_book();
		if(!$this->flag)
		{
			$this->total_record();
			$this->view->display('search.php');
		}
	}

	function search_toread_book()
	{
		$this->search_name_toread_book();
		$this->search_author_toread_book();
	}

	function search_name_toread_book()
	{	
		$tablename = 'toread';
		$where = 't_bookname='."'$this->content'";

		$name_toread = $this->model_search->doSearch($tablename,$where);

		$this->i += count($name_toread);

		$this->output->set('name_toread',$name_toread);
	}

	function search_author_toread_book()
	{
		$tablename = 'toread';
		$where = 't_author='."'$this->content'";

		$author_toread = $this->model_search->doSearch($tablename,$where);

		$this->i += count($author_toread);

		$this->output->set('author_toread',$author_toread);
	}

	function search_haveread_book()
	{
		$this->search_name_haveread_book();
		$this->search_author_haveread_book();
	}

	function search_name_haveread_book()
	{
		$tablename = 'haveread';
		$where = 'h_bookname='."'$this->content'";

		$name_haveread = $this->model_search->doSearch($tablename,$where);

		$this->i += count($name_haveread);

		$this->output->set('name_haveread',$name_haveread);
	}

	function search_author_haveread_book()
	{
		$tablename = 'haveread';
		$where = 'h_author='."'$this->content'";

		$author_haveread = $this->model_search->doSearch($tablename,$where);

		$this->i += count($author_haveread);

		$this->output->set('author_haveread',$author_haveread);
	}

	function search_reading_book()
	{
		$this->search_name_reading_book();
		$this->search_author_reading_book();
	}

	function search_name_reading_book()
	{
		$tablename = 'reading';
		$where = 'r_bookname='."'$this->content'";

		$name_reading = $this->model_search->doSearch($tablename,$where);

		$this->i += count($name_reading);

		$this->output->set('name_reading',$name_reading);
	}

	function search_author_reading_book()
	{
		$tablename = 'reading';
		$where = 'r_author='."'$this->content'";

		$author_reading = $this->model_search->doSearch($tablename,$where);

		$this->i += count($author_reading);

		$this->output->set('author_reading',$author_reading);
	}

	function search_notread_book()
	{
		$this->search_name_notread_book();
		$this->search_author_notread_book();
	}

	function search_name_notread_book()
	{
		$tablename = 'notread';
		$where = 'n_bookname='."'$this->content'";

		$name_notread = $this->model_search->doSearch($tablename,$where);

		$this->i += count($name_notread);

		$this->output->set('name_notread',$name_notread);
	}

	function search_author_notread_book()
	{
		$tablename = 'notread';
		$where = 'n_author='."'$this->content'";

		$author_notread = $this->model_search->doSearch($tablename,$where);

		$this->i += count($author_notread);

		$this->output->set('author_notread',$author_notread);
	}

	function search_all_film()
	{
		$this->search_towatch_film();
		$this->search_havewatch_film();
		if(!$this->flag)
		{
			$this->total_record();
			$this->view->display('search.php');

		}
	}

	function search_towatch_film()
	{
		$tablename = 'towatch';
		$where = 't_filmname='."'$this->content'";

		$name_towatch = $this->model_search->doSearch($tablename,$where);

		$this->i += count($name_towatch);
		
		$this->output->set('name_towatch',$name_towatch);
	}

	function search_havewatch_film()
	{
		$tablename = 'havewatch';
		$where = 'h_filmname='."'$this->content'";

		$name_havewatch = $this->model_search->doSearch($tablename,$where);

		$this->i += count($name_havewatch);

		$this->output->set('name_havewatch',$name_havewatch);
	}

	function search_music()
	{
		$this->search_name_music();
		$this->search_author_music();
		if(!$this->flag)
		{
			$this->total_record();
			$this->view->display('search.php');
		}
	}

	function search_name_music()
	{
		$tablename = 'music';
		$where = 'm_musicname='."'$this->content'";

		$name_music = $this->model_search->doSearch($tablename,$where);

		$this->i += count($name_music);

		$this->output->set('name_music',$name_music);
	}

	function search_author_music()
	{
		$tablename = 'music';
		$where = 'm_singer='."'$this->content'";

		$author_music = $this->model_search->doSearch($tablename,$where);

		$this->i += count($author_music);

		$this->output->set('author_music',$author_music);
	}

	function search_sentence()
	{
		$this->search_from_sentence();
		$this->search_content_sentence();
		if(!$this->flag)
		{
			$this->total_record();
			$this->view->display('search.php');
		}
	}

	function search_from_sentence()
	{
		$tablename = 'sentence';
		$where = 's_from='."'$this->content'";

		$from_sentence = $this->model_search->doSearch($tablename,$where);

		$this->i += count($from_sentence);

		$this->output->set('from_sentence',$from_sentence);
	}

	function search_content_sentence()
	{
		$tablename = 'sentence';
		$where = 's_content='."'$this->content'";

		$content_sentence = $this->model_search->doSearch($tablename,$where);

		$this->i += count($content_sentence);
		
		$this->output->set('content_sentence',$content_sentence);
	}

	function total_record()
	{
		$this->output->set('total_record',$this->i);
	}

	function init()
	{
		$this->output->set('name_towatch',null);
		$this->output->set('name_havewatch',null);
		$this->output->set('from_sentence',null);
		$this->output->set('content_sentence',null);
		$this->output->set('name_music',null);
		$this->output->set('author_music',null);
	}
}
?>