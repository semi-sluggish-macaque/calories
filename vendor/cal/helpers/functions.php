<?php

function debug($data, $die = false)
{

    echo '<pre>' . print_r($data, 1) . '</pre>';
    if ($die) {
        die;
    }
}

// функция для избежание xmr уязвимостей
function h($str)
{
    //ENT_QUOTES преобразует как двойные так и одинарные кавычки
    return htmlspecialchars($str, ENT_QUOTES);
}

//http опциональный аргумент, по умолчанию false
function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        //возвращение пользователя на ту страницу, откуда он пришел
        //'HTTP_REFERER' адрес с которого пришел пользователь, в противном случае отправляем на главную страницу
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
    //отправка на стриницу с адресом redirect
    header("Location: $redirect");
    die;
}

function base_url()
{
    // если \cal\app::$app->getProperty('lang') присутствует, тогда берём его и добавляем к url адресу, если нет, то ничго не добавляем
    return PATH . '/' . (\cal\app::$app->getProperty('lang') ? \cal\app::$app->getProperty('lang') . '/' : '');

}

/**
 * @param string $key key of GET array
 * @param string $type Values 'i', 'f', 's'
 * @return float|int|string
 */
//get('page')
//$_GET['page']
function get($key, $type = 'i')
{

    //если get('page'), то
    $param = $key;
    //$page = $_GET[$param] ?? '';
    //то есть $$param становиться переменной с именем, которое передали в $key
    $$param = $_GET[$param] ?? '';
    //если
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        //предпологаем, что это будет строка
        return trim($$param);
    }
}

/**
 * @param string $key key of POST array
 * @param string $type Values 'i', 'f', 's'
 * @return float|int|string
 */
//get('page')
//$_GET['page']
function post($key, $type = 's')
{
    //если get('page'), то
    $param = $key;
    //$page = $_GET[$param] ?? '';
    //то есть $$param становиться переменной с именем, которое передали в $key
    $$param = $_POST[$param] ?? '';
    //если
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        //предпологаем, что это будет строка
        return trim($$param);
    }
}

function __($key)
{
    echo \cal\language::get($key);
}

function ___($key)
{
    return \cal\language::get($key);
}

function get_cart_icon($id)
{
    if ((!empty($_SESSION['cart'])) && array_key_exists($id, $_SESSION['cart'])) {
        $icon = '<i class="fas fa-luggage-cart"></i>';
    } else {
        $icon = '<i class="fas fa-shopping-cart"></i>';
    }
    return $icon;
}

function get_field_value($name)
{
    return isset($_SESSION['form_data'][$name]) ? h($_SESSION['form_data'][$name]) : '';
}


function get_field_array_value($name, $key, $index)
{
    return isset($_SESSION['form_data'][$name][$key][$index]) ? h($_SESSION['form_data'][$name][$key][$index]) : '';
}
