<?php

namespace app\models;

use RedBeanPHP\R;

class Main extends AppModel
{
    //такое называеться "безопасные данные", сервер получает те данные, которые он ожидает
    //метод модели load его заполнит
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
    ];

    public array $rules = [
        //если поля приходят, то к ним применяются правила
        'required' => ['email', 'password', 'name',],
        'email' => ['email'],
        'lengthMin' => [
            ['password', 6],
            ['name', 4],
        ],
        'optional' => ['email', 'password'],
    ];
    public array $lables = [
        'email' => 'tpl_signup_email_input',
        'password' => 'tpl_signup_password_input',
        'name' => 'tpl_signup_name_input',
    ];


    public static function checkAuth(): bool
    {
        return isset($_SESSION['user']);
    }

    public function checkUnque($text_error = ''): bool
    {
        $user = R::findOne('user', 'email = ?', [$this->attributes['email']]);
        if ($user) {
            $this->errors['unigue'][] = $text_error ?: ___('user_signup_error_email_unique');
            return false;
        }
        return true;
    }

//    public function get_count_order($user_id): int
//    {
//        return R::count('orders', 'user_id = 6');
//    }
//
//    public function get_user_orders($start, $perpage, $user_id): array
//    {
//        return R::getAll("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT $start, $perpage", [$user_id]);
//    }
//
//    public function get_user_order($id): array
//    {
//        return R::getAll("SELECT o.*, op.* FROM orders o JOIN order_product op on o.id = op.order_id
//WHERE o.id = ?", [$id]);
//    }
//
//    public function get_count_files(): int
//    {
//        return R::count('order_download', 'user_id = ? AND status = 1', [$_SESSION['user']['id'][0]]);
//    }
//
//    public function get_user_files($start, $perpage, $lang): array
//    {
//        return R::getAll("SELECT od.*, dd.* FROM order_download od JOIN download d on d.id = od.download_id
//                        JOIN download_description dd on d.id = dd.download_id WHERE od.user_id = ? AND
//                        od.status = 1 AND dd.language_id = ? LIMIT $start, $perpage", [$_SESSION['user']['id'][0], $lang['id']]);
//    }
//
//
//    public function get_user_file($id, $lang): array
//    {
//        return R::getRow("SELECT od.*, d.*, dd.* FROM order_download od JOIN download d on d.id = od.download_id
//                JOIN download_description dd on d.id = dd.download_id WHERE od.user_id = ? AND
//                od.status = 1  AND dd.language_id = ?  AND od.id = ?", [$_SESSION['user']['id'][0], $lang['id'], $id]);
//    }
}
