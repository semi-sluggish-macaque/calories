<?php
//фронт контроллер, создаёт класс приложения (app.php)




if(PHP_MAJOR_VERSION < 8){
    die('необходима версия php >=8');
}


require_once dirname(__DIR__) . '/calories/config/init.php';
require_once HELPERS . '/functions.php';
require_once CONFIG . '/routes.php';

new \cal\app();

?>
