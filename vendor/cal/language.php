<?php

namespace cal;

class language
{

    //массив со всеми переводными фразами страницы
    public static array $lang_data = [];
    //массив с переводными фразами шаблона
    public static array $lang_layout = [];
    //массив с переводными фразами вида
    public static array $lang_view = [];

    public static function load($code, $view)
    {
//        не знаю зачем тут фигурные скобки, если дебажить, то они ни на что не влияют
        $lang_layout = APP . "/languages/${code}.php";
        $lang_view = APP . "/languages/${code}/{$view['controller']}/{$view['action']}.php";
//        debug($lang_view, 1);
        if (file_exists($lang_layout)) {
            self::$lang_layout = require_once $lang_layout;
        }

        if (file_exists($lang_view)) {
            self::$lang_view = require_once $lang_view;
        }

        self::$lang_data = array_merge(self::$lang_layout, self::$lang_view);
//        debug(self::$lang_data["user_login_error_login"], 1);

    }

    public static function get($key)
    {
        //если $lang_data[$key] == true, то вернет его, в противном случаем вернет $key
        return self::$lang_data[$key] ?? $key;
    }


}