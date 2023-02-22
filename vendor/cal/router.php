<?php

namespace cal;


use mysql_xdevapi\Exception;

class router
{
    protected static array $routes = [];
    protected static array $route = [];

    public static function add($regxp, $route = [])
    {
        self::$routes[$regxp] = $route;
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function getRoute(): array
    {
        return self::$route;
    }

    //отделяет гет параметры от адреса
    protected static function removeQueryString($url)
    {
        if ($url) {
            //explode разбивает строку на элементы массива по определённому разделителю
            //в данном случае разбивает по разделителю &. Сейчас должно быть два элемнта массива, по этому указан
            // третий аргумент 2(всё что после первой & попадет во второй элемент)
            $params = explode('&', $url, 2);
            //ищется, если в первом элемента массива равно(то есть get параметр)
            if (false === str_contains($params[0], '=')) {
                //если нет =
                return rtrim($params[0], '/');
            }
        }
        return '';
    }

    public static function dispatch($url)
    {
        //отделяет гет параметры от адреса
//        debug($url);//page/gay&12
        $url = self::removeQueryString($url);
//        debug($url,1);
//        debug($url, 1);//page/gay
        //проверяет, попадает ли путь под заданые правила
        if (self::matchRoute($url)) {
            if (!empty(self::$route['lang'])) {
                app::$app->setProperty('lang', self::$route['lang']);
            }
            //превращает даннные с массива route в путь к соответствующему контролеру
            // { ["controller"]=>"Page" ["action"]=>"view" ["admin_prefix"]=>"" } -> app\controllers\PageController
            $controller = 'app\controllers\\' . self::$route['admin_prefix'] . self::$route['controller'] . 'Controller';
            //если соответствующий контроллер существует
            if (class_exists($controller)) {

                //благодаря php docs ниже, теперь для $controllerObject видно все его методы
                /** @var Controller $controllerObject */
                //создает экземпляр controller c адресом
                //создает новый экземпляр контроллера
                $controllerObject = new $controller(self::$route);
                //создает путь к моделе данного экземпляра
                $controllerObject->getModel();

                //определяет и форматирует action
                $action = self::lowerCamelCase(self::$route['action'] . 'Action');
                if (method_exists($controllerObject, $action)) {
                    //вызывает метод для записи мета данных
                    // для такого адреса http://ishop/ будет:
                    $controllerObject->$action();
                    //создает путь к виду данного экземпляра
                    $controllerObject->getView();
                } else {
                    throw new \Exception("Метод{$controller}::{$action} не найден", 404);

                }
            } else {
                throw new \Exception("Контроллер{$controller} не найден", 404);
            }

        } else {
            throw new Exception("страница не найдена", 404);
        }
    }

    //проверяет, попадает ли путь под заданые правила
    public static function matchRoute($url): bool
    {
        //routes массив со всмеми возможными варинтами патернов адреса

        foreach (self::$routes as $pattern => $route) {
            //флаг i делает паттерн регистронезависимым
            //паттерн, строка с которой ищется соответствие, то куда попадает запомниное
            //то есть если найдено соответствие, оно обработаеться и вернётся true
            if (preg_match("#{$pattern}#i", $url, $matches)) {

                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                //если нет 'action' то присваеватся базовый 'action'
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (empty($route['admin_prefix'])) {
                    $route['admin_prefix'] = '';
                } else {
                    $route['admin_prefix'] .= '\\';
                }
                $route['controller'] = self::uppreCamelCase($route['controller']);
                //записывает отредактированый адресс в глобальную переменную
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    //CamelCase
    protected static function uppreCamelCase($name): string
    {
        //new-product -> new product
        $name = str_replace('-', ' ', $name);
        //new product -> New Product
        $name = ucwords($name);
        //New Prodcut -> NewProduct
        $name = str_replace(' ', '', $name);
        return $name;
    }

    //camelCase
    protected static function lowerCamelCase($name): string
    {
        //lcfirst первую букву с строке сделает маленькой
        return lcfirst(self::uppreCamelCase($name));
    }

}