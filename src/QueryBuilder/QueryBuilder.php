<?php

namespace Vannghia\SimpleQueryBuilder\QueryBuilder;

use http\Exception\BadConversionException;
use Vannghia\SimpleQueryBuilder\Config\Connection;
use PDO;
use Vannghia\SimpleQueryBuilder\Data;
use Vannghia\SimpleQueryBuilder\Interfaces\IQueryBulider;

class QueryBuilder
{
    private PDO $conn;

    protected static $table = '';
    private $where = "";
    private $whereCondition = [];
    private $prepare;
    private $orderBy = "";
    private $limit = "";
    private $join = "";
    private  $para = [];


    public function __construct(string $table)
    {
        $this->conn = Connection::connect();
        static::$table = $table;
    }

    public static function table(string $table = ''): QueryBuilder
    {
        // TODO: Implement table() method.
        static::$table = $table;
        $static = new static($table);
        return $static;
    }

    public function where(array $array)
    {
        if (empty($this->where)) {
            $this->where = " WHERE ";
        } else {
            $this->where .= " AND ";
        }
        foreach ($array as $arr) {
            $key = $arr[0];
            $key = $arr[0].'1';
               if(!in_array($key,$this->para)){
                  array_push($this->para,$key);
               }
               else{
                   $key = changeKey($this->para,$key);
                  array_push($this->para,$key);
                   echo "Cos vafo day " . $key;
               }
            $this->where .= $arr[0] . " $arr[1] " . ":{$key}" . " AND ";
            $this->whereCondition[$key] = $arr[2];
        }
        $this->where = substr($this->where, 0, -5);
        return $this;
    }

    public function wherenot(array $array)
    {
        if (empty($this->where)) {
            $this->where = " WHERE NOT ";
        }
        foreach ($array as $arr) {
            $this->where .= $arr[0] . " $arr[1] " . ":{$arr[0]}" . " AND NOT ";
            $this->whereCondition[$arr[0]] = $arr[2];
        }
        $this->where = substr($this->where, 0, -9);
        return $this;
    }


    public function orderBy(array $fields, $mode = 'asc')
    {
        $mode = strtoupper($mode);
        $stringField = implode(', ', $fields);

        if ($mode == "ASC") {
            $this->orderBy = " ORDER BY " . $stringField . " ASC ";
        } else {
            $this->orderBy = " ORDER BY " . $stringField . " DESC ";
        }
        return $this;
    }

    public function limit(int $limit, int $offset = 0)
    {
        $this->limit = " LIMIT {$limit}  OFFSET {$offset}";
        return $this;
    }

    public function get($flag = \PDO::FETCH_ASSOC)
    {
        try {
            if (empty($this->prepare)) {
                $this->prepare = "SELECT * FROM " . self::$table;
            }
            $test = $this->conn->prepare($this->prepare . $this->join . $this->where . $this->orderBy . $this->limit);
            if (empty($this->whereCondition)) {
                $test->execute();
            } else {
                $test->execute($this->whereCondition);
            }
            return $test->fetchAll($flag);

        } catch (\PDOException $e) {
            echo $this->getPrepareString();
            echo " Have some errors";
            file_put_contents('PDOErrors.txt', $e->getMessage() . " at " . date("d\m\Y H:m:s", time()) . "\n", FILE_APPEND);
        }
    }

    public function first($flag = \PDO::FETCH_ASSOC)
    {
        try {
            if (empty($this->prepare)) {
                $this->prepare = "SELECT * FROM " . self::$table;
            }
            $run = $this->conn->prepare($this->prepare . $this->join . $this->where . $this->orderBy);
            if (empty($this->whereCondition)) {
                $run->execute();
            } else {
                $run->execute($this->whereCondition);
            }
            return $run->fetch($flag);
        } catch (\PDOException $e) {
            echo "have some errors";
            file_put_contents('PDOErrors.txt', $e->getMessage() . " at " . date("d\m\Y H:m:s", time()) . "\n", FILE_APPEND);
        }
    }

    public function insert(array $data)
    {
        try {
            $field = array_keys($data);
            $val = array_values($data);
            $stringField = implode(",", $field);
            $stringQuestionMark = str_repeat("?, ", count($field));
            $stringQuestionMark = substr($stringQuestionMark, 0, -2);
            $this->prepare = "INSERT INTO " . self::$table . " (" . $stringField . ")" . " values " . "(" . $stringQuestionMark . ")";
            $run = $this->conn->prepare($this->prepare);
            $run = $run->execute($val);
            return true;
        } catch (\PDOException $e) {
            echo "ERROR! Co loi xay ra voi PDO";
            file_put_contents('PDOErrors.txt', $e->getMessage() . " at " . date("d\m\Y H:m:s", time()) . "\n", FILE_APPEND);
        }
    }

    public function update(array $data)
    {
        try {
            $stringQuestion = "";
            foreach ($data as $key => $val) {
                $stringQuestion .= $key . "=:{$key}, ";
                $this->whereCondition[$key] = $val;
            }
            $stringQuestion = substr($stringQuestion, 0, -2);
            $this->prepare = "UPDATE " . self::$table . " SET " . $stringQuestion;

            $run = $this->conn->prepare($this->prepare . $this->where);

            if (empty($this->whereCondition)) {
                $run = $run->execute();
            } else {
                $run = $run->execute($this->whereCondition);
            }
            return true;
        } catch (\PDOException $e) {
            file_put_contents('PDOErrors.txt', $e->getMessage() . " at " . date("d\m\Y H:m:s", time()) . "\n", FILE_APPEND);
            return false;
        }
    }

    public function select(array $items = []): QueryBuilder
    {
        // TODO: Implement select() method.

        if (empty($items)) {
            $this->prepare = "SELECT * FROM " . static::$table;
        } else {
            $string = implode(",", $items);
            $this->prepare = "SELECT " . $string . " FROM " . static::$table;
        }
        return $this;
    }

    public function delete()
    {
        try {
            $this->prepare = "DELETE FROM " . self::$table;
            $run = $this->conn->prepare($this->prepare . $this->where);
            if (empty($this->whereCondition)) {
                $run = $run->execute();
            } else {
                $run = $run->execute($this->whereCondition);
            }
            return true;
        } catch (\PDOException $e) {

            file_put_contents('PDOErrors.txt', $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    public function count()
    {
        try {
            if (empty($this->prepare)) {
                $this->prepare = "SELECT * FROM " . self::$table;
            }
            $test = $this->conn->prepare($this->prepare . $this->join . $this->where);
            if (empty($this->whereCondition)) {
                $test->execute();
            } else {
                $test->execute($this->whereCondition);
            }
            return count($test->fetchAll());
        } catch (\PDOException $e) {
            file_put_contents('PDOErrors.txt', $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    public function join($tableJoin, array $condition)
    {
        $this->join = " INNER JOIN {$tableJoin} ON " . $condition[0] . " {$condition[1]} " . $condition[2];
        return $this;
    }

    public function leftjoin(string $tableJoin, array $condition)
    {
        $this->join = " LEFT JOIN {$tableJoin} ON " . $condition[0] . " {$condition[1]} " . $condition[2];
        return $this;
    }

    public function rightjoin(string $tableJoin, array $condition)
    {
        $this->join = " RIGHT JOIN {$tableJoin} ON " . $condition[0] . " {$condition[1]} " . $condition[2];
        return $this;
    }

    public function find(array $search)
    {
        try {
            $key = array_keys($search)[0];
            $run = $this->conn->prepare("SELECT * FROM " . self::$table . " WHERE  {$key} =:{$key} ");
            $run->execute($search);
            return $run->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo " have some errors";
            file_put_contents('PDOErrors.txt', $e->getMessage() . ' at time : ' . date('d/m/Y -H:m:s', time()) . "\n", FILE_APPEND);
        }
    }

    public function getPrepareString()
    {
        return $this->prepare . $this->where ;
    }


}