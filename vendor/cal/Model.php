<?php

namespace cal;

use RedBeanPHP\R;
use Valitron\Validator;

abstract class Model
{
    //свойства, куда загружаються данные(имя, пароль, мейд, адресс)
    public array $attributes = [];
    //
    public array $errors = [];
    //правила валидации
    public array $rules = [];
    //переводные фразы
    public array $lables = [];

    public function __construct()
    {

        Db::getInstance();

    }

    //метод, который проверяет, не изменил ли пользователь форму и не ввел туда данные
    //например если чел ввел lastname с значением fedorov, оно игнорируеться
    public function load($post = true)
    {
        $data = $post ? $_POST : $_GET;
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function validate($data): bool
    {
        //подключения переводных фраз валидатора
        Validator::langDir(APP . '/languages/validator/lang');
        //выбор языка локализации
        Validator::lang(app::$app->getProperty('language')['code']);
        //создание объекта валидатора
        $validator = new Validator($data);
        //передача кастомных правил в валидатор
        $validator->rules($this->rules);
        //установка переводных фраз
        $validator->labels($this->getLables());
        //валидация
        if ($validator->validate()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            debug($this->errors);
            return false;
        }
    }

    //форматированая запись ошибок
    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>{$item}</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['errors'] = $errors;
    }

    //метод заменяет переводную фразу её значением
    public function getLables(): array
    {
        $labels = [];
        foreach ($this->lables as $k => $v) {
            $labels[$k] = ___($v);

        }
        return $labels;
    }

    public function save($table): int|string
    {
        //добавление данных в базу данных нативным способом ORM R
        //также можно добавить и с помощью SQL запроса
        $tbl = R::dispense($table);

        foreach ($this->attributes as $name => $value) {
            if ($value != '') {
                $tbl->$name = $value;
            }
        }
        return R::store($tbl);
    }

    public function login($is_admin = false)
    {
        $password = post('password', '');
        $email = post('email', '');
        if ($email && $password) {

            if ($is_admin) {
                $user = R::findOne('user', "email = ? AND role = 'admin'", [$email]);
            } else {
                $user = R::findOne('user', "email = ?", [$email]);
            }

            if ($user) {
                if (password_verify($password, $user->password)) {
                    foreach ($user as $k => $v) {
                        if ($k != 'password') {
                            //из-за того, что $v в скобках данные криво добавляются в сессию
                            // [id] => Array
                            //        (
                            //            [0] => 6
                            //        )
                            $_SESSION['user'][$k] = [$v];
                        }
                    }
                    return true;
                    redirect();
                }
            }
        }
        return false;
    }

    public function update($table, $id): int|string
    {
        $tbl = R::load($table, $id);
        foreach ($this->attributes as $name => $value) {
            if ($value != '') {
                echo $value;
                $tbl->$name = $value;
            }
        }
        return R::store($tbl);
    }
}
