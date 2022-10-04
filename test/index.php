<?php
require  "../vendor/autoload.php";
use Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder as DB;
use Vannghia\SimpleQueryBuilder\TblAdmin ;
$config = [
    'driver'=>'mysql',
    'host'=>'localhost',
    'dbname'=>'app',
    'username'=>'root',
    'password'=>'root',
];
\Vannghia\SimpleQueryBuilder\Config\Connection::$config = $config;
$test = TblAdmin::get();
$test2 = \Vannghia\SimpleQueryBuilder\TblProduct::count();
var_dump($test2);