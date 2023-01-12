<?php

namespace Vannghia\SimpleQueryBuilder;

use http\QueryString;
use Vannghia\SimpleQueryBuilder\Data;
use Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder;

abstract class Model extends Data
{
    public $query;
    protected $table = '';

    public function __construct()
    {

        $this->query = new QueryBuilder($this->table);

    }

    public function __call(string $name, array $arguments)
    {
        return $this->{"pre" . $name}(...$arguments);

    }

    public static function __callStatic(string $name, array $arguments)
    {
        // TODO: Implement __callStatic() method.

        return (new static)->{"pre" . $name}(...$arguments);
    }

    public function preselect(array $fields)
    {

        $this->query->select($fields);
        return $this;
    }

    public function prewhere(...$array)
    {

        $this->query->where($array);
        return $this;

    }

    public function prefind(array $search)
    {
         $result = $this->query->find($search);
        return $result === null ? $result : static::collection([$result])  ;
    }

    public function preget()
    {
        $result = $this->query->get();
        return $result === null ? $result :  static::collection($result);
    }
 public  function  prefirst(){
        $result = $this->query->first();
        return  $result === null ? $result : static::collection([$result]) ;
 }
    public function prelimit($limit, $offset = 0)
    {
        $this->query->limit($limit, $offset);
        return $this;
    }
    public  function  orderBy(array $fields, $mode = 'asc'){
        $this->query->orderBy($fields,$mode);
        return $this;
    }
    public  function  precount(){
        return $this->query->count();
    }

    public  function  preleftjoin(string $tableJoin, array $condition){
        $this->query->leftjoin($tableJoin,$condition);
        return $this;

    }
    public  function  prerightjoin(string $tableJoin, array $condition){
        $this->query->rightjoin($tableJoin,$condition);
        return $this;
    }

    public function getstr()
    {
        return $this->query->getPrepareString();
    }
    public  function  prejoin($tableJoin, array $condition){
        $this->query->join($tableJoin,$condition);
        return $this;

    }
    public  function  preinsert( array $data){
        $this->query->insert($data);

    }
    public  function preupdate(array $data)
    {
        $this->query->update($data);

    }
    public function  prewherenot(array $array){
        $this->query->wherenot($array);
    }

    public function predelete()
    {
       return  $this->query->delete();

    }
    public  function  precreate(array $array ){
        $keys = array_keys($array);
        $vals= array_values($array);
        $this->query->insert($array);


    }
    public function pretruncate()
    {
        $this->query->truncate();
    }

}