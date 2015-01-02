<?php

class Database
{

	// TODO : Comment all the class

	// pdo object.
	private $pdo;

	public function __construct()
	{
		require('./init/config.php');
		$username = $config['username'];
		$password = $config['password'];
		$dbname = $config['dbname'];
		$host = $config['host'];
		$port = $config['port'];
		$driver = $config['driver'];

		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		);

		try {
			$this->pdo = new PDO($driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $dbname, $username, $password, $options);
		} catch (Exception $e) {
			die('Impossible de se connecter &agrave; la base de donn&eacute;e !');
		}
	}

	/**
	 * @param $query
	 * @return Object
	 */
	protected function queryFirst($query)
	{
		$query .= " LIMIT 1";
		$result = $this->query($query);
		return !empty($result) ? $result[0] : '';
	}

	/**
	 * @param $query
	 * @param $params
	 * @param $type
	 * @return Object
	 */
	protected function query($query, $params = array(), $type = 'find')
	{
		$result = null;
		try {
			foreach ($params as $key => $value) {
				$params[$key] = htmlentities($value, ENT_QUOTES, "UTF-8");
			}
			$sql = $this->pdo->prepare($query);
			$sql->execute($params);
			$type === 'find' ? $result = $sql->fetchAll(): null;
			$sql->closeCursor();
		} catch (Exception $e) {
			die('Impossible de se connecter &agrave; la base de donn&eacute;e !');
		}
		return $result;
	}

	/*
	 * @param $table
	 * @param string $type
	 * @param array $options
	 * @return bool
	 * Need to Comments
	 */
	public function select($table, $type = 'all', $options = array()){
		return $this->find($table, $type, $options);
	}

	public function find($table, $type = 'all', $options = array())
	{
		$where = $join = $limit = '';

		$fields = isset($options['fields']) ? implode(', ', $options['fields']) : '*';
		$order = isset($options['order']) ? ' ORDER BY ' . implode(', ', $options['order']) : '';

		if (isset($options['conditions'])) {
			$where = ' WHERE ';
			$tmp = array();
			foreach ($options['conditions'] as $field => $value) {
				$cond = explode(' ', $field);
				// Making default array with field and value
				$tmp[] = isset($cond[1]) ? $cond[0] . ' ' . $cond[1] . '\'' . $value . '\'' : $field . ' = \'' . $value . '\'';
			}
			// Making the where clause
			$where .= implode(' AND ', $tmp);
		}

		if (isset($options['conditionIn'])) {
			$where = ' WHERE ';
			foreach ($options['conditionIn'] as $key => $value) {
				$where .= empty($value) ? 'id = 0' : $key . ' IN (' . $value . ')';
			}
		}

		if (isset($options['join'])) {
			foreach ($options['join'] as $joinTable => $onJoin) {
				$join .= ' LEFT JOIN ' . $joinTable . ' AS ' . strtoupper($joinTable) . ' ON ' . $onJoin;
			}
		}

		if (isset($options['limit'])) {
			$limit = ' LIMIT ';
			$limit .= count($options['limit']) > 1 ? implode(', ', $options['limit']) : $options['limit'];
		}

		if ($type === 'count') {
			$query = 'SELECT COUNT(*) AS count FROM ' . $table . ' AS ' . strtoupper($table) . $join . $where . $order . $limit;
		} else {
			$query = 'SELECT ' . $fields . ' FROM ' . $table . ' AS ' . strtoupper($table) . $join . $where . $order . $limit;
		}
		if ($type == 'first') {
			return $this->queryFirst($query);
		}
		if ($type == 'count') {
			return $this->queryFirst($query)->count;
		}
		return $this->query($query);
	}


	/**
	 * @param $table
	 * @param $fields - Like array('fieldname' => 'value')
	 */
	public function insert($table, $fields)
	{

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
	public function update($table, $fields, $where = 'id')
	{
		// Manipulating Fields
		foreach ($fields as $field => $value) {
			$set[] = $field . ' = :' . $field;
		}
		$set = implode(', ', $set);

		// Verifying if $where is an array
		if (is_array($where)) {
			foreach ($where as $field => $value) {
				// Making default array with field and value
				$tmp[] = isset($cond[1]) ? $cond[0] . ' ' . $cond[1] . '\'' . $value . '\'' : $field . ' = \'' . $value . '\'';
			}
			// Making the where clause
			$where .= implode(' AND ', $tmp);
			// If not an array, making where clause is by id
		} else {
			$where = 'id = ' . $where;
		}

		// Query Creation
		$query = 'UPDATE ' . $table . ' SET ' . $set . ' WHERE ' . $where;
		$this->query($query, $fields, 'update');
	}
}