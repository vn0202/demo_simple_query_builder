<?php
require  "../vendor/autoload.php";

$config = [
    'driver'=>'mysql',
    'host'=>'localhost',
    'dbname'=>'app',
    'username'=>'root',
    'password'=>'root',
];
\Vannghia\SimpleQueryBuilder\Config\Connection::$config = $config;
$test = \Vannghia\SimpleQueryBuilder\Test\TblAdmin::get();
$test2 = \Vannghia\SimpleQueryBuilder\Test\TblProduct::count();
var_dump($test2);