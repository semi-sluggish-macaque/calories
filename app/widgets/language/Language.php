<?php

namespace app\widgets\language;
use RedBeanPHP\R;
use cal\app;



class Language
{

    protected $tpl;
    protected $languages;
    protected $language;

    public function __construct()
    {
        //экземпляр создаеться в ishop/app/views/parts/header.php
        $this->tpl = __DIR__ . '/lang_tpl.php';
        $this->run();
    }

    protected function run()
    {
        //получение всех яхыков с пропетис
        $this->languages = app::$app->getProperty('languages');
        //получение текущего языка с пропортис
        $this->language = app::$app->getProperty('language');
        echo $this->getHTML();
    }

    public static function getLanguages(): array
    {
        //возвращает асоциативный массив, где ключ code, а все остальное идет в значения
        return R::getAssoc("SELECT code, title, base, id FROM language ORDER BY base DESC");
    }


    public static function getLanguage($languages)
    {
        $lang = app::$app->getProperty('lang');
        if($lang && array_key_exists($lang, $languages)){
            $key = $lang;
        } elseif(!$lang) {
            //если в ссылка нет ключа языка, то присваетья ключ первого элемента массва, то естб ключ базового языка
            //он всегда первый, тк при получения массива языков с базы данных происходит соответсвующая сортировка
            $key = key($languages);
        } else {
            //если в ссылке несуществующий язык
            $lang = h($lang);
            throw new \Exception("not found language {$lang}", 404);
        }

        $lang_info = $languages[$key];
        $lang_info['code'] = $key;
        return $lang_info;
    }

    protected function getHTML()
    {
        //буферизация вывода, если какой-то файл подключаетсья, то он будет в буфере, а не выводиться
        ob_start();
        require $this->tpl;
        //возвращает содержимое буфера обмена и затем буфер очищаеться
        return ob_get_clean();
    }
}