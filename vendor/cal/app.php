<?php

//главный класс приложения
namespace cal;

// при добавление товара в корзину значек корзины меняется, но при удаление с корзины, без перезагрузки страницы
//он не будет менятся назад, это можно сделать, но это возможно будет дорогая операция

//%2c - кодированая запятая

//в сессии объекты автоматически сериализуются

//$_SESSION['form_data'] где-то в админке написано вот так, это не правильно - изменить
class app
{
    public static $app;

    public function __construct()
    {
        //считывает адресс и записывает в querry controller и action
        //http://ishop/page/view -> page/view
        $query = trim(urldecode($_SERVER['QUERY_STRING']), '/');
        //создает экземпляр класса, который отвечает за обработку ошибок
        new ErrorHandler();
        session_start();
        //создает класс с параметрами
        self::$app = Registry::getInstance();
        //заполняет массив параметров в классе регистра
        $this->getParams();
        //запускает метод диспетчера для маршрутизации на сайте
        router::dispatch($query);
//        session_destroy();
//        die;
    }

    //метод для заполнения параметров в регистре
    protected function getParams()
    {
        $params = require_once CONFIG . '/params.php';
        if (!empty($params)) {
            foreach ($params as $k => $v) {
                self::$app->setProperty($k, $v);

            }
        }

    }
}