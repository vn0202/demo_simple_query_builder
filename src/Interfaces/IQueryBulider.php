<?php
namespace  Vannghia\SimpleQueryBuilder\Interfaces;
use Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder;

interface  IQueryBulider{
    public  function  table(string $table = ''):QueryBuilder;
    public  function  select():QueryBuilder;
    public  function  where(): QueryBuilder;
    public  function  get();
    public  function  first();
    public  function  count();
}