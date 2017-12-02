<?php
	class DB{
		public static $db;

		public $config = array(
			'dbconfig' => array(
				'dbhost' => 'localhost', 'dbuser'=>'root', 'dbpsw' => 'root' , 'dbname' => 'fume-hood-monitor', 'dbcharset' => 'utf8')
		);

		public static function init($dbtype, $this->config['dbconfig']){
			self::$db = new $dbtype;
			self::$db->connect($this->config); 
		}

		public static function init_db(){
			DB::init('mysql',self::$this->config['dbconfig']);
		}

		public static function query($sql){
			return self::$db->query($sql);
		}

		public static function findAll($sql){
			$query =self::$db->query($sql);
			return self::$db->findAll($query);
		}

		public static function findOne($sql){
			$query =self::$db->query($sql);
			return self::$db->findOne($query);
		}

		public static function findResult($sql,$row = 0,$field = 0){
			$query =self::$db->query($sql);
			return self::$db->findResult($query,$row,$field);
		}

			public static function insert($table,$arr){
			return self::$db->insert($table,$arr);
		}

			public static function update($table,$arr,$where){
			return self::$db->update($table,$arr,$where);
		}

			public static function delete($table,$where){
			return self::$db->delete($table,$where);
		}
	}
?>