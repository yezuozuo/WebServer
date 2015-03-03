<?php
class  adapter_mysql
{
	//数据库请求次数
	var $queryNum = 0;
	//数据库连接信息
	var $dbInfo = null;
	//数据库连接句柄
	var $conn = null;
	//最后一次数据库操作的错误信息
	var $lastError = null;
	//最后一次数据库操作的错误代码
	var $lastErrorCode = null;
	//指示事务是否启用了事务
	var $transFlag = false;
	//启用事务处理情况下的错误
	var $transErrors = array();

	//构造函数
	function adapter_mysql($dbInfo)
	{
		if(is_array($dbInfo))
		{
			$this->dbInfo = $dbInfo;
		}
		else
		{
			exit('缺少数据库参数,请检查配置文件!');
		}
	}

	//数据库连接函数
	function connect($dbInfo = false)
	{
		//如果已经存在连接的话
		if($this->conn && $dbInfo == false)
		{
			return true;
		}

		//如果不存在连接但没有传进来参数的话
		if($dbInfo == false)
		{
			$dbInfo = $this->dbInfo;
		}
		else
		{
			$this->dbInfo = $dbInfo;
		}

		//如果有端口号的话，主机名加上端口号
		if(isset($dbInfo['port']) && $dbInfo['port'] != '')
		{
			//var host
			$host = $dbInfo['host'].":".$dbInfo['port'];
		}
		else
		{
			$host = $dbInfo['host'];
		}

		//如果数据库密码没有设置的话，设置密码为空
		if(!isset($dbInfo['dbpass']))
		{
			$dbInfo['dbpass'] = '';
		}

		$this->conn = @mysql_connect($host,$dbInfo['dbuser'],$dbInfo['dbpass']);

		//连接失败的话
		if(!$this->conn)
		{
			exit("连接数据库(".$host.$dbInfo['dbuser'].")失败");
		}

		//连接表
		if($dbInfo['dbname'])
		{
			//连接数据表失败
			if(!@mysql_select_db($dbInfo['dbname'],$this->conn))
			{
				exit("不能使用数据表:".$dbInfo['dbname']);
			}
		}
		else
		{
			exit("请设置数据库名！");
		}

		//读取字符集
		if(isset($dbInfo['charset']) && $dbInfo['charset'] != '')
		{
			//var $charset
			$charset = $dbInfo['charset'];
		}

		//设置字符集
		mysql_set_charset($dbInfo['charset']);

		return true;
	}

	//关闭数据库
	function close()
	{
		if($this->conn)
		{
			mysql_close($this->conn);
		}
		$this->conn = null;
	}

	//直接查询SQL
	function query($sql)
	{
		if(!$this->conn)
		{
			$this->connect();
		}

		//var $query
		$query = @mysql_query($sql,$this->conn);

		//查询次数++
		$this->queryNum++;

		//查询失败的话
		if(!$query)
		{
			$this->lastError = mysql_error($this->conn);
			$this->lastErrorCode = mysql_errno($this->conn);

			//如果开启事务的话
			if($this->transFlag)
			{
				$this->transErrors[]['sql'] = $sql;
				$this->transErrors[]['errorCode'] = $this->lastErrorCode;
				$this->transErrors[]['error'] = $this->lastError;
			}
			else
			{
				exit('SQL:'.$sql.'ERROR_INFO:'.$this->lastErrorCode.','.$this->lastError);
			}

			return false;
		}
		//查询成功的话
		else
		{
			$this->lastError = null;
			$this->lastErrorCode = null;
			return $query;
		}
	}

	//获得所有数据
	//得到的是关联数组
	function getAll($sql)
	{
		if(is_resource($sql))
		{
			//var $res
			//$res = $result
			$res = $sql;
		}
		else
		{
			$res = $this->query($sql);
		}

		//var $data
		//$data 装载数据库的数据
		//$data 为一维数组
		$data = array();

		//var $row
		while($row = @mysql_fetch_assoc($res))
		{
			$data[] = $row;
		}
		@mysql_free_result($res);
		return $data;
	}

	//返回第一条行的第一个字段
	function getOne($sql)
	{
		if(is_resource($sql))
		{
			//var $res
			$res = $sql;
		}
		else
		{
			$res = $this->query($sql);
		}

		//var $row
		$row = @mysql_fetch_row($res);
		@mysql_free_result($res);

		//如果第一个字段存在的话返回第一个字段否则返回空
		return isset($res[0])?$res[0]:null;
	}

	//返回一条记录
	//返回关联数组
	function getRow($sql)
	{
		if(is_resource($sql))
		{
			//var $res
			$res = $sql;
		}
		else
		{
			$res = $this->query($sql);
		}

		//var $row
		$row = @mysql_fetch_assoc($res);
		@mysql_free_result($res);

		return $row;
	}

	//返回指定的列组成的数组
	//$col为行数
	function getCol($sql,$col = 0)
	{
		if(is_resource($sql))
		{
			//var $res
			$res = $sql; 
		}
		else
		{
			$res = $this->query($sql);
		}

		//var $data
		$data = array();

		//var $row
		while($row = @mysql_fetch_row($res))
		{
			$data[] = $row[$col];
		}
		@mysql_free_result($res);

		return $data;
	}

	//获取记录的关联数组
	//该关联数组是每条记录的第一个字段和第二个字段所组成的关联数组
	function getAssoc($sql)
	{
		if(is_resource($sql))
		{
			//var $res
			$res = $sql;
		}
		else
		{
			$res = mysql_query($sql);
		}

		//var $data
		$data = array();

		//var $row
		while($row = mysql_fetch_row($res))
		{
			$data[$row[0]] = $row[1];
		}
		@mysql_free_result($res);
		return $data;
	}

	//加入边界的查询语句
	//$length记录长度
	//$offset偏移量
	//查询从$offset开始向后$length条记录
	function selectLimit($sql,$length = null,$offset = null)
	{
		if($offset != null)
		{
			$sql .= " LIMIT ".(int)$offset;
			if($length != null)
			{
				$sql .= ", ".(int)$length;
			}
			else
			{
				$sql .= ", 4294967294";
			}
		}
		else if($length != null)
		{
			$sql .= " LIMIT ".(int)$length;
		}

		return $sql;
	}

	//从结果集中取得一行作为关联数组，或数字数组，或二者兼有
	//return array
	function fetchArray($query)
	{
		return @mysql_fetch_array($query);
	}

	//返回最近一次数据库操作受到影响的记录数
	//return int
	function affectedRows()
	{
		return mysql_affected_rows();
	}

	//返回一行记录
	//return array
	function fetchRow($query)
	{
		return @mysql_fetch_row($query);
	}

	//获取记录的条数
	//return int
	function numRows($query)
	{
		//var $rowNumber
		if(is_resource($query))
		{
			$rowNumber = @mysql_num_rows($query);
		}	
		else
		{
			$rowNumber = @mysql_num_rows($this->query($query));
		}

		return $rowNumber;
	}

	//获取MySQL版本号
	//return string
	function version()
	{
		return mysql_get_server_info();
	}

	//获取刚查入行的ID
	//return int
	function insertId($sql)
	{
		return mysql_insert_id($this->conn);
	}

	//返回数据库可以接受的日期格式
	//data()函数
	function dbTimeStamp($timeStamp)
	{
		return date("Y-m-d H:m:s",$timeStamp);
	}

	//获得查询数据库的次数
	function getQueryTime()
	{
		return $this->queryNum;
	}

	//返回随机数RAND()的字符串
	//并不返回数字
	function strRandom()
	{
		return 'RAND()';
	}

	//数据库开启事务
	function startTrans()
	{
		//var $rs
		$rs = $this->query('START TRANSACTION');
		$this->transFlag = true;
		$this->transErrors = array();
		return $rs;
	}

	//事务提交
	function commit()
	{
		$rs = $this->query('COMMIT');
		$this->transFlag = false;
		return $rs;
	}

	//事务回滚
	function rollback()
	{
		$rs = $this->query('ROLLBACK');
		$this->transFlag = false;
		return $rs;
	}

	//打印事务中的错误
	function transErrors()
	{
		//var $errors
		$errors = $this->transErrors;
		if(is_array($errors))
		{
			//var $error
			foreach($errors as $error)
			{
				echo "SQL:".$error['sql']."ERROR_INFO:".$error['errorCode'].",".$error['error'];
			}
		}
	}

	//规范化表名
	function q_field($tableName)
	{
		if(substr($tableName,0,1) == '`')
		{
			return $tableName;
		}
		return '`'.$tableName.'`';
	}

	//对SQL语句进行规范化，防止数据库被攻击
	function q_str($value)
	{
		if(!$this->conn)
		{
			$this->connect();
		}

		if(is_bool($value))
		{
			return $value?1:0;
		}

		if(is_null($value))
		{
			return 'NULL';
		}

		//如果字符串被转义了的话
		if(get_magic_quotes_gpc())
		{
			//取消转义
			$value = stripcslashes($value);
		}

		if(phpversion() >= '4.3.0')
		{
			////转义SQL语句中使用的字符串中的特殊字符,防止数据库被攻击
			return "'".mysql_real_escape_string($value,$this->conn)."'";
		}
		else if(phpversion() >= '4.0.3')
		{
			return "'".mysql_escape_string($value)."'";
		}
		else
		{
			return $value;
		}
	}
}