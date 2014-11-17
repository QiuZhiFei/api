<?php

/**
* 
*/
class Db
{

	// 单例模式
	// 
	// 1 构造函数，要为 非public 让外部不能使用 new 来初始化类
	// 2 有用一个保存类的实例的静态成员变量 $_instance
	// 3 拥有一个访问这个实例的公共的静态方法
	
	static private $_instance;

	static private $_connectSource;

	private $_dbConfig = array(
	'host' => '127.0.0.1',
	'user' => 'root',
	'password' => '',
	'database' => 'vedio');


	static public function shareInstance()
	{
		$get_instance = self::$_instance;
		if (!$get_instance) {

			$get_instance = new self();
		}	

		return $get_instance;
	}

	private function __construct()
	{

	}

	// 链接数据库
	
	public function connect()
	{
		// 判断是否存在
		$conn = self::$_connectSource;

		if ($conn) {
			
			return $conn;
		}

		// 链接数据库
		self::$_connectSource = new mysqli($this -> _dbConfig['host'],
			$this -> _dbConfig['user'],
			$this -> _dbConfig['password']);

		$conn = self::$_connectSource;

		if (!$conn) {

			// die('mysql connect error');
			
			throw new Exception("mysql connect error");
		}

		// 创建数据库

		$create_database_sql_str = "create database if not exists " . $this -> _dbConfig['database'];

		if ($conn -> query($create_database_sql_str)) {

			if ($conn -> change_user($this -> _dbConfig['user'],
				$this -> _dbConfig['password'],
				$this -> _dbConfig['database']
				)) {

				// echo "connect success";
			} else {

				// die("change connect user error");
				throw new Exception("mysql connect error");
			}
		} else {

			// die("create database error");
			throw new Exception("create database error");
		}

		return self::$_connectSource;
	}


}

?>