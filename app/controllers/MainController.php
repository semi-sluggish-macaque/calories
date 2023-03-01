<?php

namespace app\controllers;

use app\models\Main;
use cal\app;
use cal\Pagination;
use RedBeanPHP\R;

/** @property Main $model */
class MainController extends AppController
{
    public function registrationAction()
    {
        $json = file_get_contents('php://input');
        $_POST = json_decode($json, true);
        if (!empty($_POST)) {
            //в пост запросе данные, которые ввел пользовтель
            $data = $_POST;
            //проверка на кореткность формы
            $this->model->load();
            //валидация данных
            if (!$this->model->validate($this->model->attributes) || !$this->model->checkUnque()) {
                //вывод ошибки валидаци
                $this->model->getErrors();
                $response = array("status" => "error", "message" => "Error");
                //сохранение данных при ошибке
                $_SESSION['form_data'] = $this->model->attributes;
            } else {
                //шифрование пароля
                $this->model->attributes['password'] = password_hash(
                    $this->model->attributes['password'], PASSWORD_DEFAULT
                );
                //сохранение данных пользователя в базу
                if ($this->model->save('user')) {
                    $_SESSION['success'] = ___('user_signup_success_register');
                    $response = array("status" => "success", "message" => "Data written to file");

                } else {
                    //вывод ошибки сохранения
                    $_SESSION['errors'] = ___('user_signup_error_register');
                    $response = array("status" => "error", "message" => "Error");

                }
            }
            echo json_encode($response);
            die;
        }
    }

    public function loginAction()
    {
        $json = file_get_contents('php://input');
        $_POST = json_decode($json, true);


        if (!empty($_POST)) {
            if ($this->model->login()) {

                $_SESSION['success'] = ___('user_login_success_login');
                $response = array("status" => "success", "message" => "Data written to file");

            } else {
                $_SESSION['errors'] = ___('user_login_error_login');
                $response = array("status" => "error", "message" => "Error");

            }
        }

//        $this->setMeta(___('tpl_login'));

        echo json_encode($response);
        die;
    }

    public function indexAction()
    {
        unset($_SESSION['user']);
    }
}

