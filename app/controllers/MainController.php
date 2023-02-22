<?php

namespace app\controllers;

use app\models\Main;
use cal\app;
use cal\Pagination;

/** @property Main $model */
class MainController extends AppController
{
    public function credentialsAction()
    {

        //если пользовател ауторизован и перешел на регистрацию, его отправит на главную страницу
        if (!Main::checkAuth()) {
            redirect(base_url() . 'user/login');
        }

        if (!empty($_POST)) {

            //в пост запросе данные, которые ввел пользовтель
            //проверка на кореткность формы
            $this->model->load();
            if (empty($this->model->attributes['password'])) {
                unset($this->model->attributes['password']);
            }
            unset($this->model->attributes['email']);
            //валидация данных
            if (!$this->model->validate($this->model->attributes)) {
                //вывод ошибки валидаци
                $this->model->getErrors();
                //сохранение данных при ошибке
//                не работает
//                $_SESSION['form_data'] = $data;
            } else {
                if (!empty($this->model->attributes['password'])) {//шифрование пароля
                    $this->model->attributes['password'] = password_hash(
                        $this->model->attributes['password'], PASSWORD_DEFAULT
                    );
                }

                //сохранение данных пользователя в базу
                if ($this->model->update('user', $_SESSION['user']['id'][0])) {
                    $_SESSION['success'] = ___('user_credentials_success');
                    foreach ($this->model->attributes as $k => $v) {
                        if (!empty($v) && $k != 'password') {
                            //!!!!!!!!!
                            $_SESSION['user'][0][$k] = $v;
                        }
                    }
                } else {
                    //вывод ошибки сохранения
                    $_SESSION['errors'] = ___('user_credentials_error');
                }
            }
//           debug( base_url() . "face");
        }
        $this->setMeta(___('user_credentials_tittle'));
    }

    public function indexAction()
    {
        //если пользовател ауторизован и перешел на регистрацию, его отправит на главную страницу
//        if (Main::checkAuth()) {
//            redirect(base_url());
//        }
        if (!empty($_POST)) {
            //в пост запросе данные, которые ввел пользовтель
            $data = $_POST;
            //проверка на кореткность формы
//            debug($_POST, 1);
            $this->model->load();
            //валидация данных
            if (!$this->model->validate($this->model->attributes) || !$this->model->checkUnque()) {
                //вывод ошибки валидаци
                $this->model->getErrors();
                //сохранение данных при ошибке
                $_SESSION['form_data'] = $this->model->attributes;
                return false;
            } else {
                //шифрование пароля
                $this->model->attributes['password'] = password_hash(
                    $this->model->attributes['password'], PASSWORD_DEFAULT
                );

                //сохранение данных пользователя в базу
                if ($this->model->save('user')) {
                    $_SESSION['success'] = ___('user_signup_success_register');
                    return true;
                } else {
                    //вывод ошибки сохранения
                    $_SESSION['errors'] = ___('user_signup_error_register');
                    return false;
                }
            }
//            redirect();
        }
        $this->setMeta(___('tpl_sign_up'));
    }

    public function loginAction()
    {
//        if (Main::checkAuth()) {
//            redirect(base_url());
//        }

        if (!empty($_POST)) {
            if ($this->model->login()) {

                $_SESSION['success'] = ___('user_login_success_login');
                redirect( base_url() . "face");

            } else {
                $_SESSION['errors'] = ___('user_login_error_login');
                redirect();
            }
        }

        $this->setMeta(___('tpl_login'));
    }

    public function logoutAction()
    {
        if (User::checkAuth()) {
            unset($_SESSION['user']);
            redirect(base_url() . 'user/login');
        }
    }

//    public function cabinetAction()
//    {
//        if (!User::checkAuth()) {
//            redirect(base_url() . 'user/login');
//        }
//        $this->setMeta(___('tpl_cabinet'));
//    }
//
//    public function ordersAction()
//    {
//        if (!User::checkAuth()) {
//            redirect(base_url() . 'user/login');
//        }
//
//        $page = get('page');
//        //$perpage = app::$app->getProperty('pagination');
//        $perpage = 1;
////        debug($_SESSION['user']['id'][0], 1);
//        $total = $this->model->get_count_order($_SESSION['user']['id'][0]);
//        $pagination = new Pagination($page, $perpage, $total);
//        $start = $pagination->getStart();
//
//        $orders = $this->model->get_user_orders($start, $perpage, $_SESSION['user']['id'][0]);
//
//        $this->setMeta(___('user_orders_title'));
//        $this->set(compact('orders', 'pagination', 'total'));
//    }
//
//    public function orderAction()
//    {
//        if (!User::checkAuth()) {
//            redirect(base_url() . 'user/login');
//        }
//
//        $id = get('id');
//        $order = $this->model->get_user_order($id);
//        if (!$order) {
//            throw new \Exception('Not found order', 404);
//        }
//        $this->setMeta(___('user_order_title'));
//        $this->set(compact('order'));
//    }
//
//    public function filesAction()
//    {
//        if (!User::checkAuth()) {
//            redirect(base_url() . 'user/login');
//        }
//        $lang = app::$app->getProperty('language');
//        $page = get('page');
//        //$perpage = app::$app->getProperty('pagination');
//        $perpage = 3;
//        $total = $this->model->get_count_files();
//        $pagination = new Pagination($page, $perpage, $total);
//        $start = $pagination->getStart();
//
//        $files = $this->model->get_user_files($start, $perpage, $lang);
//
//        $this->setMeta(___('user_files_title'));
//        $this->set(compact('files', 'pagination', 'total'));
//    }
//
//    public function downloadAction()
//    {
//        if (!User::checkAuth()) {
//            redirect(base_url() . 'user/login');
//        }
//        $id = get('id');
//        $lang = app::$app->getProperty('language');
//
//        $file = $this->model->get_user_file($id, $lang);
//        if ($file) {
//            $path = WWW . "/assets/downloads/{$file['filename']}";
//            if (file_exists($path)) {
//
//                //скачивание файла по временной ссылке
//                header('Content-Type: application/octet-stream');
//                header('Content-Disposition: attachment; filename="' . basename($file['original_name']) . '"');
//                header('Expires: 0');
//                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//                header('Pragma: public');
//                header('Content-Length: ' . filesize($path));
//                readfile($path);
//                exit();
//            } else {
//                $_SESSION['errors'] = ___('user_download_error');
//            }
//        }
//
//        redirect();
//    }
}