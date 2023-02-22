<?php

namespace cal;

use RedBeanPHP\R;

class View
{
    public string $content = '';

    public function __construct(

        public $route,
        public $layout = '',
        public $view = '',
        public $meta = ['title' => '', 'keywords' => '', 'description' => ''],
    )
    {
        if (false !== $this->layout) {
            $this->layout = $this->layout ?: LAYOUT;
        }
    }

    public function render($data)
    {
        if (is_array($data)) {
            //берёт по ключам данные с массива  и создает соответствующее переменные
            extract($data);
        }
        //admin\ => admin/
        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);
        //формирование пути, где должен лежать нужный вид
        $view_file = APP . "/views/{$prefix}{$this->route['controller']}/{$this->view}.php";
        if (is_file($view_file)) {
            //включается буффер
            ob_start();
            //подкчюает вид
            //для http://ishop/ -> Z:\OpenServer\domains\ishop/app/views/Main/index.php
            require_once $view_file;
            //этот вид запрашивается и заносится в буфер и потом содержимое буфера заносится в $this->content
            // и с файла ishop/views/layouts/ishop.php вызывается контент
            $this->content = ob_get_clean();
        } else {
            throw new \Exception("не найден вид{$view_file}", 500);
        }

        if (false !== $this->layout) {
            //формирует путь к макету
            $layout_file = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layout_file)) {
                //подключает макет(шаблон)
                require_once $layout_file;
            } else {
                throw new \Exception("не найден шаблон ${layout_file}", 500);
            }
        }
    }

    public function getMeta()
    {
        $out = '<title>' . App::$app->getProperty('site_name') . '::' . h($this->meta['title']) . '</title>' . PHP_EOL;
        $out .= '<meta name="decription" content="' . h($this->meta['decription']) . '">' . PHP_EOL;
        $out .= '<meta name="keywords" content="' . h($this->meta['keywords']) . '">' . PHP_EOL;
        return $out;
    }

    public function getDblogs()
    {
        if (DEBUG) {
//            if(R::testConnection()){
            $logs = R::getDatabaseAdapter()
                ->getDatabase()
                ->getLogger();
            $logs = array_merge(
                $logs->grep('SELECT'),
                $logs->grep('INSERT'),
                $logs->grep('UPDATE'),
                $logs->grep('DELETE'));
            debug($logs);
        }
    }

//    }

    public function getPart($file, $data = null)
    {
        if (is_array($data)) {
            extract($data);
        }
        $file = APP . "/views/{$file}.php";
        if (is_file($file)) {
            require $file;
        } else {
            echo "File {$file} не найден";
        }
    }

}