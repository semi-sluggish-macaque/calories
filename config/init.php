<?php
// 1 значит что приложение в разработке, когда приложение будет готово, 1 надо поменять на 0, тогда не будет показываться
// и будут показыватся страница 404 либо подобное
define("DEBUG", 1);
//ведет в корень проекта
define("ROOT", dirname(__DIR__));
//храниться путь к публичной папке
define("WWW", ROOT . '/public');
//путь в приложению app
define("APP", ROOT . '/app');
//путь в ядру
define("CORE", ROOT . '/vendor/cal');
//помощники
define("HELPERS", ROOT . '/vendor/cal/helpers');
//кеш
define("CACHE", ROOT . '/tmp/cashe');
//логи
define("LOGS", ROOT . '/tmp/logs');
//конфигурация
define("CONFIG", ROOT . '/config');
//шаблон сайта по умолчанию
define("LAYOUT",'ishop');
//адресс сайта
define("PATH",'http://calories');
//адресс админки
define("ADMIN", 'http://calories/admin');
//картинка по умолчанию
define("NO_IMAGE", '/uploads/no.png');

require_once ROOT . '/vendor/autoload.php';

