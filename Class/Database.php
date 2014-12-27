<?php
class Database
{

	// pdo object.
	private $pdo;

	public function __construct()
	{
		$config = parse_ini_file("sql.ini");
		$username = $config['username'];
		$password = $config['password'];
		$database = $config['dbname'];
		$host = $config['host'];
		$port = $config['port'];
		$driver = $config['driver'];

		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		);

		try {
			$this->pdo = new PDO($driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $database, $username, $password, $options);
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
		if(!empty($result)){
			return $result[0];
		} else {
			return '';
		}
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
			$sql = $this->pdo->prepare($query);
			$sql->execute($params);
			if($type === 'find') {
				$result = $sql->fetchAll();
			}
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
	public function find($table = '', $type = 'all', $options = array())
	{
		$where = $join = $order = $limit = '';

		if (!isset($options['fields'])) {
			$fields = '*';
		} else {
			$fields = implode(', ', $options['fields']);
		}

		if (isset($options['order'])) {
			$order = ' ORDER BY ';
			$order .= implode(', ', $options['order']);
		}

		if (isset($options['conditions'])) {
			$where = ' WHERE ';
			$tmp = array();
			foreach ($options['conditions'] as $field => $value) {
				$cond = explode(' ', $field);
				// Making default array with field and value
				if (isset($cond[1])) {
					$tmp[] = $cond[0] . ' ' . $cond[1] . '\'' . $value . '\'';
				} else {
					$tmp[] = $field . ' = \'' . $value . '\'';
				}
			}

			// Making the where clause
			$count = count($tmp);
			for ($i = 0; $i < $count; $i++) {
				// Test if element is the first i array
				if ($i === 0) {
					$where .= $tmp[$i];
				} else {
					// If not first element, adding the " AND " clause
					$where .= ' AND ' . $tmp[$i];
				}
			}
		}

		if (isset($options['conditionIn'])) {
			$where = ' WHERE ';
			foreach ($options['conditionIn'] as $key => $value) {
				if (!empty($value)) {
					$where .= $key . ' IN (' . $value . ')';
				} else {
					$where .= 'id = 0';
				}
			}
		}

		if (isset($options['join'])) {
			foreach ($options['join'] as $joinTable => $onJoin) {
				$join .= ' LEFT JOIN ' . $joinTable . ' AS ' . strtoupper($joinTable) . ' ON ' . $onJoin;
			}
		}

		if (isset($options['limit'])) {
			$limit = ' LIMIT ';
			if (count($options['limit']) > 1) {
				$limit .= implode(', ', $options['limit']);
			} else {
				$limit .= $options['limit'];
			}
		}

		if ($type === 'count') {
			$query = 'SELECT COUNT(*) AS count FROM ' . $table . $join . $where . $order . $limit;
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
	public function insert($table, $fields = array())
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
	public function update($table, $fields = array(), $where = 'id')
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
				$tmp[] = $field . ' = \'' . $value . '\'';
			}

			// Making the where clause
			$count = count($tmp);
			for ($i = 0; $i < $count; $i++) {
				// Test if element is the first i array
				if ($i === 0) {
					$where = $tmp[$i];
				} else {
					// If not first element, adding the " AND " clause
					$where .= ' AND ' . $tmp[$i];
				}
			}
			// If not an array, making where clause is by id
		} else {
			$where = 'id = ' . $where;
		}

		// Query Creation
		$query = 'UPDATE ' . $table . ' SET ' . $set . ' WHERE ' . $where;
		// No return. (return SQLStatement)
		$this->query($query, $fields, 'update');
	}
}