<?php
class db
{
	//通过数据库适配器得到的数据库实例
	var $db;
	//表的前缀
	var $pre = '';
	//表名
	var $table;
	//字段
	var $field;
	//排序
	var $order;
	//范围
	var $where;
	//存放更新时要用到的sql语句
	var $arr = array();
	//SQL语句
	var $sql = null;

	//构造语句
	function db($db_config)
	{
		//读取数据库适配器
		if(is_array($db_config) && $db_config['adapter'])
		{
			$adapterName = 'adapter_'.$db_config['adapter'];
		} 
		else
		{
			exit("数据库配置文件错误");
		}

		require_once LIBDIR.'db_adapter/'.$db_config['adapter'].'.php';

		$this->db = new $adapterName($db_config);
	}

	//设置前缀
	function setPre($pre)
	{
		$this->pre = $pre;
	}

	//设置表名
	//'#'的作用是把$table中 的‘#’替换成前缀
	//str
	function setTable($table)
	{
		if(!empty($table))
		{
			$this->table = str_replace('#',$this->pre,$table);
		}
	}

	//设置sql语句
	function setSql($sql)
	{
		if(!empty($sql))
		{
			$this->sql = str_replace('#', $this->pre, $table);
		}
	}

	//返回sql语句
	function getSql()
	{
		return $this->sql;
	}

	//设置排序
	function setOrder($order)
	{
		//如果$order不为空
		if((bool)$order)
		{
			$this->order = ' order by '.$order;
		}
		else
		{
			$this->order = '';
		}
	}

	//设置查询范围语句
	function setWhere($where)
	{
		//如果$where不为空
		if((bool)$where)
		{
			$this->where = $where;
		}
		else
		{
			$this->where = ' 1=1 ';
		}
	}

	//设置字段
	function setField($field)
	{
		$this->field = $field;
	}

	//设置数据存放的数组
	function setArr($arr)
	{
		$this->arr = $arr;
	}

	//数据库查询
	function select($table,$field,$where = '',$order = '')
	{
		$this->setTable($table);
		$this->setField($field);
		$this->setWhere($where);
		$this->setOrder($order);
		$this->_select();
		return $this->sql;
	}	

	function _select()
	{
		$this->sql = 'select '.$this->field.' from '.$this->table.' where '.$this->where.' '.$this->order;
	}

	//数据库删除
	function delete($table,$where)
	{
		$this->setTable($table);
		$this->setWhere($where);
		$this->_delete();
		return $this->sql;
	}

	function _delete()
	{
		$this->sql = 'delete from '.$this->table.' where '.$this->where;
	}

	//数据库更新
	function update($table,$where,$arr)
	{
		$this->setTable($table);
		$this->setWhere($where);
		$this->setArr($arr);
		return $this->_update();
	}

	function _update()
	{
		//var $row
		//var fieldValuePairs
		//var fieldName
		//var value
		$row = $this->arr;
		$fieldValuePairs = array();

		foreach($row as $fieldName => $value)
		{
			//is_a() — 如果对象属于该类或该类是此对象的父类则返回 TRUE
			if(is_a($value,'DB_Expr'))
			{
				$fieldValuePairs[] = $this->db->q_field($fieldName).' = '.$value->getExpr();
			}
			else
			{
				$fieldValuePairs[] = $this->db->q_field($fieldName).' = '.$this->db->q_str($value);
			}
		}

		//implode()用逗号把$fieldValuePairs数组用逗号连接成字符串
		$fieldValuePairs = implode(',',$fieldValuePairs);

		$this->sql = 'update '.$this->table.' set '.$fieldValuePairs.' where '.$this->where;
	}
	
	//数据库插入
	function insert($table,$arr)
	{
		$this->setTable($table);
		$this->setArr($arr);
		return $this->_insert();
	}

	function _insert()
	{
		//var $row
		//var $fields
		//var $values
		//var $fieldName
		//var $value
		$row = $this->arr;
		$fields = array();
		$values = array();
		foreach($row as $fieldName => $value)
		{
			$fields[] = $this->db->q_field($fieldName);
			if(is_a($value,'DB_Expr'))
			{
				$values[] = $value->get();
			}
			else
			{
				$values[] = $this->db->q_str($value);
			}
		}

		$fields = implode(',',$fields);
		$values = implode(',',$values);

		$this->sql = 'insert into '.$this->table.' ('.$fields.') values ('.$values.') '; 
	}



	//获得刚刚插入数据所在行的ID
	function insertId()
	{
		return $this->db->insertId();
	}

	//加入边界的数据库查询语句
	//从$offset 到 $offset + $length
	function selectLimit($sql = null,$length = null,$offset = null)
	{
		if($sql != null)
		{
			$this->sql = $sql;
		}
		$this->sql = $this->db->selectLimit($this->sql,$length,$offset);
	}

	//调试时候 用此函数可以输出 sql 语句是否ok
	function echoSql()
	{
		echo $this->sql;
		exit();
	}

	//执行sql
	function query($sql = null)
	{
		if($sql != null)
		{
			$this->setSql($sql);
		}
		return $this->db->query($this->sql);
	}

	//获得所有记录
	function getAll($sql = null)
	{
		if($sql != null)
		{
			$this->setSql($sql);
		}
		return $this->db->getAll($this->sql);
	}

	//获得第一条记录的第一个字段
	function getOne($sql = null)
	{
		if($sql != null)
		{
			$this->setSql($sql);
		}
		return $this->db->getOne($this->sql);
	}

	//获得符合sql语句的一条记录
	function getRow($sql = null)
	{
		if($sql != null)
		{
			$this->setSql($sql);
		}
		return $this->db->getRow($this->sql);
	}

	//获得结果集的指定列
	//$col 为指定列
	function getCol($sql = null,$col = 0)
	{
		if($sql != null)
		{
			$this->setSql($sql);
		}
		return $this->db->getCol($this->sql,$col);
	}		

	//获得由每条记录的第一个字段和第二个字段组成的关联数组
	function getAssoc($sql = null)
	{
		if($sql != null)
		{
			$this->setSql($sql);
		}
		return $this->db->getAssoc($this->sql,$col);
	}

	//获取一条关联数组和数字数组的结合体
	function fetchArray($sql = null)
	{
		if($sql != null)
		{
			$this->setSql($sql);
		}
		return $this->db->fetchArray($this->sql,$col);
	}

	//取得结果集中行的数目
	function numRows($sql)
	{
		return $this->db->numRows($sql);
	}

	//影响的行数
	function affectedRows()
	{
		return $this->db->affectedRows();
	}

	//关闭数据库
	function close()
	{
		$this->db->close();
	}

	//返回字符串'RAND()'
	function strRandom()
	{
		return $this->db->strRandom();
	}

	//事务启动
	function startTrans()
	{
		$this->db->startTrans();
	}

	//事务提交
	function commit()
	{
		$this->db->commit();
	}

	//事务回滚
	function rollback()
	{
		$this->db->rollback;
	}

	//打印事务中的错误
	function transErrors()
	{
		$this->db->transErrors();
	}

	//返回数据库请求次数
	function getQueryNum()
	{
		return $this->db->getQueryNum();
	}

	//返回数据库可以接受的日期格式
	function DBTime($time = '')
	{
		if($time == '')
		{
			$time = time();
		}
		return $this->db->dbTimeStamp($time);
	}

	/**
     * 分页函数
     *
     * @param 当前页 		$no_p
     * @param 每页记录数 	$title_rows
     * @param 定义分页SQL 	$sqlcount
     * @param 定义SQL 		$sql
     * @return array
     */
	function toPage($no_p,$title_rows,$sqlcount = null,$sql = null)
	{
		if(!$sql)
		{
			$sql = $this->sql;
		}

		//$total 为 总条目数
		if(!$sqlcount)
		{
			$total = $this->numRows($sql);
		}
		else
		{
			$total = $this->getOne($sqlCount);
		}

		//页数
		$totalpage = ceil($total / $title_rows);

		if($no_p < 1)
		{
			$no_p = 1;
		}

		if($no_p > $totalpage)
		{
			$no_p = $totalpage;
		}

		//获取当前页的记录的内容
		//从($no_p - 1) * $title_rows 到$title_rows + ($no_p - 1) * $title_rows
		if($total > 0)
		{
			$sql = $this->selectLimit($sql,$title_rows,($no_p - 1) * $title_rows);
			$content = $this->getAll($sql);
		}
		else
		{
			$content = null;
		}

		$arr['ls'] = $content;		//记录内容,当前页的所有记录的内容
		$arr['total'] = $totalpage; //总数页数
		$arr['start'] = $no_p;		//开始页
		$arr['count'] = $total;		//总记录数

		return $arr;
	}
}

//放置数据库表达式的类
class DB_Expr
{
	//表达式
	var $_expr;

	//构造函数
	function DB_Expr($_expr)
	{
		$this->_expr = (string)$expr;
	}

	function getExpr()
	{
		return $this->_expr;
	}
}