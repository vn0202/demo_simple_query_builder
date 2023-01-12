<?php

namespace Vannghia\SimpleQueryBuilder\Config;


class Connection
{
    public  static $config = [];
    public static function connect()
    {

//        $config = require "./../test/Config.php";
        $config = self::$config;
        try {
            if ($config['driver'] === "mysql") {
                return new \PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
            }

        } catch (\PDOException $e) {
            echo "Connect fail....";
        }
    }
}
