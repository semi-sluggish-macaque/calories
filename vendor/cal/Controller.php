<?php

namespace cal;

abstract class Controller
{
    //тут хранятся данные для вида
    public array $data = [];
    //нужен для передачи метаданных страницы(название, метаданные, ключевики)
    public array $meta = ['title'=>'', 'decription'=>'','keywords'=>''];
    //может быть либо то либо то
    public false|string $layout = '';
    public string $view = '';
    public object $model;

    public function __construct(public $route=[])
    {
    }

    public function getModel()
    {
        //создает путь к моделе
        /** @var Model $model */

            $model = 'app\models\\' . $this->route['admin_prefix'] . $this->route['controller'];
        if(class_exists($model)){
            $this->model = new $model();
        }
    }

    public function getView()
    {
        //если в $this->view что-то есть, ($this->view == true) то оно таким и останется, в противном случае запишется то,
        // что в $this->route['action']
        $this->view = $this->view ?: $this->route['action'];
        //для http://ishop/  this->view будет index
//        debug($this->view, 1);
//        debug($this, 1)
        (new View($this->route, $this->layout, $this->view, $this->meta))->render($this->data);
    }

    //метод доавляет переменные на вид
    public function set($data)
    {
        $this->data = $data;
    }
    //метод доавляет метаданные на вид
    public function setMeta($title='', $description='', $keywords='')
    {
        $this->meta = [
            'title'=>$title,
            'decription'=>$description,
            'keywords'=>$keywords,
        ];
    }

    public static function is_ajax() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest'));
    }

    //подгружает дополнительный вид
    public function loadView($view, $vars=[])
    {
        extract($vars);
        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);
        require APP . "/views/{$prefix}{$this->route['controller']}/{$view}.php";
        die;
    }

    public function error_404($folder = 'Error', $view = 404, $response = 404)
    {
        http_response_code($response);
        $this->setMeta(___('tpl,error_404'));
        $this->route['controller'] = $folder;
        $this->view = $view;
    }

}