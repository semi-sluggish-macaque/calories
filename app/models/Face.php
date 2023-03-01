<?php

namespace app\models;

use RedBeanPHP\R;

class Face extends AppModel
{
    public function get_user_food($user_id, $day_part, $current_date)
    {
//        return R::getAll("SELECT * FROM user_meal WHERE user_id = ? ORDER BY id DESC LIMIT $start, $perpage", [$user_id]);
        return R::getAll("SELECT * FROM user_meal JOIN food ON user_meal.id = food.id WHERE user_id = $user_id AND day_part = '$day_part' AND time = '$current_date'");
    }

    public function get_popular_food()
    {
        return R::getAll("SELECT * FROM food WHERE popular = 1");
    }

    public function add_user_food($user_id, $day_part, $time, $amount, $id)
    {
//        R::exec("INSERT INTO `user_meal`(`id`, `user_id`, `amount`, `time`, `day_part`) VALUES ('2','21','123','2023-03-01', 'dinner')");

        R::exec("INSERT INTO user_meal (id, user_id, amount, time, day_part) VALUES (?, ?, ?, ?, ?)", [$id, $user_id, $amount, $time, $day_part]);

    }

    public function edit_user_food()
    {

    }

    public function calculate_total_calories($user_id, $day_part,  $current_date)
    {
        return (R::getCell("SELECT sum(cal*amount) FROM user_meal JOIN food ON user_meal.id = food.id WHERE user_id = $user_id AND day_part = '$day_part' AND time = '$current_date'")) / 100;

    }

}