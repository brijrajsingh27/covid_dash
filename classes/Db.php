<?php

namespace classes;

use classes\Config;

class Db {

    public $conn;
    public static $sql;
    public static $instance = null;
    private $db_host = Config::DB_host;
    private $db_name = Config::DB_Name;
    private $db_user = Config::DB_User;
    private $db_pwd = Config::DB_Pwd;

    private function __construct() {

        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pwd);
        if (!mysqli_select_db($this->conn, $this->db_name)) {
            die("no database selected");
        }
        mysqli_query($this->conn, 'set names utf8');
        return $this->conn;
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Db;
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    /**
     * Query the database
     */
    public function query($qry) {
        
        self::$sql = $qry;
        $result = mysqli_query($this->conn, self::$sql);
        $resultRow = array();
        $i = 0;
        if(isset($result->num_rows) && $result->num_rows>0) {
            while ($row = mysqli_fetch_assoc($result)) {
                foreach ($row as $k => $v) {
                    $resultRow[$i][$k] = $v;
                }
                $i++;
            }
            return $resultRow; 
        }else{
            return FALSE;
        }
    }
    public function select($table, $condition = array(), $field = array()) {

        $where = '';
        if (!empty($condition)) {
            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        $fieldstr = '';
        if (!empty($field)) {
            foreach ($field as $k => $v) {
                $fieldstr .= $v . ',';
            }
            $fieldstr = rtrim($fieldstr, ',');
        } else {
            $fieldstr = '*';
        }

        self::$sql = "select {$fieldstr} from {$table} {$where}";
//        echo self::$sql ;
        $result = mysqli_query($this->conn, self::$sql);
        $resultRow = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            foreach ($row as $k => $v) {
                $resultRow[$i][$k] = $v;
            }
            $i++;
        }
        return $resultRow;
    }

    /**
     * Add a record
     */
    public function insert($table, $data) {
        
        $values = '';
        $datas = '';
        foreach ($data as $k => $v) {
            
            $values .= $k . ',';
            $datas .= "'$v'" . ',';
        }
        $values = rtrim($values, ',');
        $datas = rtrim($datas, ',');
        self::$sql = "INSERT INTO {$table} ({$values}) VALUES ({$datas})";
//        echo self::$sql;
        if (mysqli_query($this->conn,self::$sql)) {
            return mysqli_insert_id($this->conn);
        } else {
            return false;
        };
    }

    /**
     * Modify a record
     */
    public function update($table, $data, $condition = array()) {
        $where = '';
        if (!empty($condition)) {
            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        $updatastr = '';
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $updatastr .= $k . "='" . $v . "',";
            }
            $updatastr = 'set ' . rtrim($updatastr, ',');
        }
        self::$sql = "update {$table} {$updatastr} {$where}";
        return mysql_query(self::$sql);
    }

    /**
     * Delete records
     */
    public function delete($table, $condition) {
        $where = '';
        if (!empty($condition)) {
            foreach ($condition as $k => $v) {
                $where .= $k . "='" . $v . "' and ";
            }
            $where = 'where ' . $where . '1=1';
        }
        self::$sql = "delete from {$table} {$where}";
        return mysql_query(self::$sql);
    }

    public static function getLastSql() {
        echo self::$sql;
    }

}

?>