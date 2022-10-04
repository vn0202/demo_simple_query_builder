<?php
require  "../vendor/autoload.php";
use Vannghia\SimpleQueryBuilder\Config\Connection;
use Vannghia\SimpleQueryBuilder\QueryBuilder\QueryBuilder as DB;
use Vannghia\SimpleQueryBuilder\Test\TblAdmin;

$config = [
    'driver'=>'mysql',
    'host'=>'localhost',
    'dbname'=>'app',
    'username'=>'root',
    'password'=>'root',
];
Connection::$config = $config;
$data = [
    'fullname'=>'vnpgroup',
    'username'=>'VNPGROUP',
    'password'=>md5('vnp'),
    'email'=>'vnp@gmail.com',
    'phone'=>123456789,
    'address'=>'102 Thai Thinh',
    'reg_date'=>time(),
    'role'=>1,
    'admin_intro'=>2,
    ];
$test = TblAdmin::find(['id'=>1]);
print_r($test);
