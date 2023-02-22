<?php

namespace cal;

use RedBeanPHP\R;

class db
{

    use Tsingleton;

    private function __construct()
    {

        $db = require_once CONFIG . '/config_db.php';
        R::setup($db['dsn'], $db['user'], $db['password']);
        if (!R::testConnection()) {
            throw new \Exception('No connection to db', 500);
        }
        R::freeze(true);
        if (DEBUG) {
            //метод возвращет sql запросы которые будет выполнять
            R::debug(true, 3);
        }

        //в конвенции Redbean не принято называть таблицы с использованием "_"(order_prod)
        //этот метод позволяет обойти данное ограничение(при обращения к таблице с названием
        //такого типа будет ошибка)
        R::ext('xdispense', function ($type) {
            return R::getRedBean()->dispense($type);
        });

    }

}
