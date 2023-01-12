<?php
namespace  Vannghia\SimpleQueryBuilder\Interfaces;
interface  CollectionInterface extends  Countable, IteratorAggregate, Accessable, Arrayable{
    public  function  isEmpty();
    public  function filter($callBack);
    public  function  clear();
    public function  add($element);
    public  function  first();
    public  function last();
    public  function  map($callBack);

}
