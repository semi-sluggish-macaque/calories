<?php

namespace cal;

class ErrorHandler
{

    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }

        //задается пользовательский обработчик исключений
        set_exception_handler([$this, 'exceptionHandler']);

        //задается пользовательский обработчик ошибок
        set_error_handler([$this, 'errorHandler']);

        //включить буфер(буферизацию)
        ob_start();

        //задается пользовательский обработчик фатальных ошибок
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }


    //главный метод обработки ошибок
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        //логирование ошибок
        $this->logError($errstr, $errfile, $errline);
        //отображение ошибок
        $this->displayError($errno, $errstr, $errfile, $errline);
    }


    public function fatalErrorHandler()
    {
        //получаем последнюю ошибку
        $error = error_get_last();
        //проверка, не пуста ли она и соответствует типо ошибки тем, которые мы можем обработать
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            //логируем ошибку
            $this->logError($error['message'], $error['file'], $error['line']);
            // выключаем буфер
            ob_end_clean();
            // дальше её показываем
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            // в противном случае, если ничего не выполнилось, завершаем данный метод
            ob_end_flush();
        }
    }

    public function exceptionHandler(\Throwable $e)
    {
        $this->logError($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    protected function logError($message = '', $file = '', $line = '')
    {
        file_put_contents(
        // куда передаются данные
            LOGS . '/errors.log',
            //сами данные
            "[" . date('Y-m-d H:i:s') . " ] Текст ошибки: {$message} | Файл: {$file} | Строка: {$line}\n==========\n",
            //константа, чтобы данные записывались в конец файла
            FILE_APPEND);
    }

    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        if ($response == 0) {
            $response = 404;
        }
        //стандартная php функция, которая отправляет необходимый код ответа в заголовках
        http_response_code($response);
        if ($response == 404 && !DEBUG) {
            require_once WWW . '/errors/404.php';
            die;
        }
        if (DEBUG) {
            require_once WWW . '/errors/development.php';
        } else {
            require_once WWW . '/errors/production.php';
        }
        die;
    }

}