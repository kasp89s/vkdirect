<?php
/**
 * Class DB ��� ������ � ����� ������
 *
 * ������:
 * $db = DB::instance();
 *
 * $increment = $db->insert($sql, [':key' => 'value'])->execute();
 */
class DB {
    /**
     * Initial param.
     */
    protected static $_instance = false;
    /**
     * MySql Query.
     * @var
     */
    private $_query = false;
    /**
     * Singleton initial.
     */
    public static function instance()
    {
        if (empty(self::$_instance) === true) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    /**
     * Initial start params.
     */
    private function __construct()
    {
        $params = include_once 'bootstrap.php';
        $connect = mysql_connect($params['db']['host'], $params['db']['user'], $params['db']['password']);
        mysql_set_charset($params['db']['charset'], $connect);
        mysql_select_db($params['db']['database']);
    }
    /**
     * ����� ���������� �������.
     *
     * @return int|null
     */
    public function count()
    {
        if (empty($this->_query)) return null;
        return mysql_num_rows($this->_query);
    }
    /**
     * ��������� ������ �������/��������/������.
     *
     * @param $sql
     */
    public function execute($sql)
    {
        mysql_query($sql);
    }
    /**
     * ��������� ������ �������.
     *
     * ������ $db->insert($sql, [':key' => 'value'])->execute();
     *
     * @param $sql
     * @param $params
     *
     * @return integer ����
     */
    public function insert($sql, $params = array())
    {
        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $sql = str_replace($key, "'" . addslashes($value) . "'", $sql);
            }
        }
        $query = mysql_query($sql) or die(mysql_error());
        return mysql_insert_id();
    }
    /**
     * ��������� ������ �������.
     *
     * ������ $db->update('table_name', [':key' => 'value'])->execute();
     *
     * @param $table
     * @param $id
     * @param array $params
     */
    public function update($table, $id,  $params = array())
    {
        if (count($params) > 0) {
            $sql = "UPDATE `{$table}` SET ";
            $data = array();
            foreach ($params as $key => $value) {
                $value = addslashes($value);
                $data[] = " `{$key}`= '{$value}'";
            }
            $sql.= implode(',', $data);
            $sql.= " WHERE `id` = {$id} ;";
            $query = mysql_query($sql) or die(mysql_error());
        }
    }
	
	    /**
     * ��������� ������ �������� ������.
     *
     * @param $table
     * @param $id
     * @param array $params
     */
    public function create($table, $params = array())
    {
        if (count($params) > 0) {
            $sql = "INSERT INTO `{$table}` ";
            $data = array();
            foreach ($params as $key => $value) {
				$value = addslashes($value);
				$cols[] = "`{$key}`";
				$values[] = "'{$value}'";
            }
            $sql.= '(' . implode(', ', $cols) . ')';
            $sql.= ' VALUES (' . implode(', ', $values) . ');';

            $query = mysql_query($sql) or die(mysql_error());
			
			return mysql_insert_id();
        }
		
		return false;
    }
	
    /**
     * ��������� ������ �������.
     *
     * @param $sql
     * @param $params
     *
     * @return object DB
     */
    public function select($sql, $params = array())
    {
        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $sql = str_replace($key, "'" . addslashes($value) . "'", $sql);
            }
        }
        $this->_query = mysql_query($sql);
        return $this;
    }
    /**
     * ���������� ���������� ������� ��� �����. �����.
     *
     * @return array
     */
    public function asArray()
    {
        if (empty($this->_query)) return null;
        $result = array();
        while ($line = mysql_fetch_assoc($this->_query)) {
            $result[] = $line;
        }
        mysql_free_result($this->_query);
        return $result;
    }
    /**
     * ���������� 1 ������� ������� � ���� �������.
     *
     * @return object|\stdClass
     */
    public function find()
    {
        if (empty($this->_query)) return null;
        $result = mysql_fetch_object($this->_query);
        mysql_free_result($this->_query);
        return $result;
    }
    /**
     * ���������� ������� ��� ����� ��������.
     *
     * @return array
     */
    public function findAll()
    {
        if (empty($this->_query)) return null;
        $result = array();
        while ($line = mysql_fetch_object($this->_query)) {
            $result[] = $line;
        }
        return $result;
    }
}