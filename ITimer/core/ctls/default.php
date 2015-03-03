<?php
class controller extends frontpage
{
	var $model_recorder_name = 'recorder';
	var $model_thinker_name  = 'thinker';

	var $table_recorder = 'record';
	var $table_think    = 'think';

	function controller()
	{
		parent::frontpage();
		$this->model_recorder = & load_model($this->model_recorder_name);
		$this->model_thinker  = & load_model($this->model_thinker_name);
	}

	function index()
	{
		$this->record_show();
		$this->think_show();
		$this->view->display('default.php');
	}

	function record_show()
	{
		$date = date('Ymd');
		$where = 'time like "'.$date.'%"';
		$records = $this->model_recorder->get_all_record($this->table_recorder,$where);

		$this->output->set('recordList',$records);
		$this->output->set('record_total_num',count($records));
	}

	function think_show()
	{
		$thinks = $this->model_thinker->get_all_think($this->table_think);

		$this->output->set('thinkList',$thinks);
		$this->output->set('think_total_num',count($thinks));
	}

	function record_summit()
	{
		$time = $_POST['time'];
		$record = $_POST['record'];
		$think = $_POST['think'];

		$arr = array('time'=>$time,'thing'=>$record,'think'=>$think);

		$this->model_recorder->insert($this->table_recorder,$arr);

		$this->index();
	} 

	function think_summit()
	{
		$time = date('Ymdhi',time());
		$think = $_POST['think'];

		$arr = array('time'=>$time,'think'=>$think);

		$this->model_recorder->insert($this->table_think,$arr);

		$this->index();
	} 

	function think_delete()
	{
		$time = $_GET['id'];
		$this->model_thinker->delete($this->table_think,$where);
		$this->index();
	}

	function review()
	{
		$date = $_POST['reviewDate'];
		$where = 'time like "'.$date.'%"';
		$records = $this->model_recorder->get_all_record($this->table_recorder,$where);

		$this->output->set('flag',1);
		$this->output->set('recordList',$records);
		$this->output->set('record_total_num',count($records));
		$this->think_show();
		$this->view->display('default.php');
	}
}	