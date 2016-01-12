<?php
/**
 * @name MysqlLib
 * @author ruansheng
 */
class MysqlLib {
    private $host = '127.0.0.1';
    private $port = 3306;
    private $dbname = 'mpress';
    private $user = 'root';
    private $pswd = '19900918';
    private $dbh;

    public function __construct() {
        $schema = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname='. $this->dbname;
        $this->dbh = new PDO($schema, $this->user , $this->pswd, array( PDO::ATTR_PERSISTENT => false));
    }

    /**
     * 查询数据
     * @param string $table
     * @param $fields
     * @param $map
     * @return array
     */
    public function find($table = '', $fields = '*', $map = '') {
        if(empty($table)) {
            return false;
        }
        if(empty($fields)) {
            return false;
        }

        if($fields != '*' && !is_array($fields)) {
            return false;
        }

        if ($fields == '*') {
            if($map == '') {
                $sql = "select * from ". $table . ' limit 1';
            } else {
                $sql = "select * from ". $table ." where " . $map . ' limit 1';
            }
        } else {
            if($map == '') {
                $sql = "select " . implode(',', $fields) . " from " . $table . ' limit 1';
            } else {
                $sql = "select " . implode(',', $fields) . " from " . $table . " where " . $map . ' limit 1';
            }
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
        $list = array();
        foreach ($rows as $rs) {
            $list = $rs;
        }
        unset($stmt);

        return $list;
    }

    /**
     * 查询数据
     * @param string $table
     * @param $fields
     * @param $map
     * @return array
     */
    public function select($table = '', $fields = '*', $map = '') {
        if(empty($table)) {
            return false;
        }
        if(empty($fields)) {
            return false;
        }
        if(!is_array($fields)) {
            return false;
        }

        if ($fields == '*') {
            if($map == '') {
                $sql = "select * from ". $table;
            } else {
                $sql = "select * from ". $table ." where " . $map;
            }
        } else {
            if($map == '') {
                $sql = "select " . implode(',', $fields) . " from " . $table;
            } else {
                $sql = "select " . implode(',', $fields) . " from " . $table . " where " . $map;
            }
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
        $list = array();
        foreach ($rows as $rs) {
            $list = $rs;
        }
        unset($stmt);

        return $list;
    }

    /**
     * 插入数据
     * @param $table
     * @param $fields
     * @param $values
     * @return string
     */
    public function insert($table, $fields = [], $values = []) {
        if (empty($table)) {
            return false;
        }

        if(!is_array($fields)) {
            return false;
        }

        if(!is_array($values)) {
            return false;
        }

        $values_str = array();
        foreach($values as $v) {
            $values_str[] = '?';
        }

        $sql = '';
        if (empty($fields)) {
            $sql .= 'INSERT INTO '. $table . ' VALUES ('. implode(',', $v) .')';
        } else {
            $fields_count = count($values);
            $values_count = count($values);
            if($fields_count != $values_count) {
                return false;
            }
            $sql .= 'INSERT INTO '. $table . '('. implode(',', $fields) .') VALUES ('. implode(',', $values_str) .')';
        }

        $stmt = $this->dbh->prepare($sql);
        foreach($values as $kv=> &$vv) {
            $stmt->bindParam($kv + 1, $vv, PDO::PARAM_INT);
        }
        $stmt->execute();

        $id = $this->dbh->lastInsertId();
        unset($stmt);

        return $id;
    }
}
