<?php
class Database{

	private $pdo;
	private $debug = false;

	/**
	 * @param $username
	 * @param $password
	 * @param $database
	 * @param string $host
	 * @param string $port
	 * @param string $driver
	 */
	public function __construct($username, $password, $database, $host = 'localhost', $port = '3306', $driver = 'mysql'){
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		try{
			$this->pdo = new PDO($driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $database, $username, $password, $options);
		} catch(Exception $e){
			die('Impossible de se connecter &agrave; la base de donn&eacute;e !');
		}
	}


	/**
	 * @param $debug
	 */
	public function setDebug($debug){
		$this->debug = $debug;
	}

	/**
	 * @param $query
	 * @return bool
	 */
	public function queryFirst($query){
		$query .= " LIMIT 1";
		$results = $this->query($query);
		return $results[0];
	}

	/**
	 * @param $query
	 * @param $params
	 * @param $type
	 * @return bool
	 */
	public function query($query, $params = array(), $type = 'find'){
		try{
			$sql = $this->pdo->prepare($query);
			$sql->execute($params);
			$results = $sql->fetchAll(PDO::FETCH_OBJ);
			$sql->closeCursor();
		} catch (Exception $e){
			if($this->debug){
				die($e->getMessage());
			} else {
				die('Impossible de se connecter &agrave; la base de donn&eacute;e !');
			}
		}
		if($type === 'find') {
			return $results;
		} else {
			return true;
		}
	}

	public function find($table = '', $type = 'all', $options = array()){
		if(!isset($options['fields'])){
			$fields = '*';
		} else {
			$fields = $options['fields'];
		}
		$query = 'SELECT ' . $fields . ' FROM ' . $table;
	}


	/**
	 * @param $table
	 * @param $fields - Like array('fieldname' => 'value')
	 */
	public function insert($table, $fields = array()){

		// Manipulating fields / values
		foreach ($fields as $field => $value) {
			$set[] = $field;
			$values[] = ':' . $field;
		}
		$set = implode(', ', $set);
		$values = implode(', ', $values);

		// Query Creation
		$query = 'INSERT INTO ' . $table . ' (' . $set . ') VALUES (' . $values . ')';

		// No return. (return SQLStatement)
		$this->query($query, $fields, 'insert');
	}

	/**
	 * @param $table
	 * @param array $fields - Like array('fieldname' => 'new value')
	 * @param $where - Can be Line Id or array('fieldname' => 'value', 'fieldname2' => 'value')
	 */
	public function update($table, $fields = array(), $where = 'id'){
		// Manipulating Fields
		foreach($fields as $field => $value){
			$set[] = $field . ' = :' . $field;
		}
		if(is_array($where)){
			foreach ($where as $field => $value) {
				$tmp[] = $field . ' = \'' . $value . '\'';
			}
			if(($count = count($tmp))){
				for($i = 0; $i < $count; $i++){
					if($i === 0){
						$where = $tmp[$i];
					} else {
						$where .= ' AND ' . $tmp[$i];
					}
				}
			}
		} else {
			$where = 'id = ' . $where;
		}
		$set = implode(', ', $set);

		// Query Creation
		$query = 'UPDATE ' . $table . ' SET ' . $set . ' WHERE ' . $where;
		// No return. (return SQLStatement)
		$this->query($query, $fields, 'update');
	}


} ?>