<?php

namespace app\models;

use RedBeanPHP\R;

class Face extends AppModel
{
    public function get_user_food($user_id, $day_part, $current_date)
    {
        return R::getAll("SELECT * FROM user_meal JOIN food ON user_meal.id = food.id WHERE user_id = $user_id AND day_part = '$day_part' AND time = '$current_date'");
    }

    public function get_popular_food($day_part, $current_date)
    {
        return R::getAll("SELECT * FROM food WHERE id NOT IN ( SELECT food.id FROM food JOIN user_meal ON food.id = user_meal.id WHERE day_part = '$day_part' AND time = '$current_date');");

    }

    public function add_user_food($user_id, $day_part, $time, $amount, $id)
    {
        R::exec("INSERT INTO user_meal (id, user_id, amount, time, day_part) VALUES (?, ?, ?, ?, ?)", [$id, $user_id, $amount, $time, $day_part]);

    }

    public function update_user_food($user_id, $day_part, $time, $amount, $id)
    {
//        R::exec("UPDATE `user_meal` SET `amount`= ? WHERE user_id = ?  day_part = ? AND time = ? AND id = ?)", [$amount, $user_id, $day_part, $time, $id]);

        R::exec("UPDATE `user_meal` SET `amount` = ? WHERE user_id = ? AND day_part = ? AND time = ? AND id = ?", [$amount, $user_id, $day_part, $time, $id]);

    }

    public function delete_user_food($user_id, $day_part, $time, $id)
    {
        R::exec("DELETE FROM user_meal WHERE id = ? AND user_id = ? AND time = ? AND day_part = ?", [$id, $user_id, $time, $day_part]);

    }


    public function calculate_total_calories($user_id, $day_part, $current_date)
    {
        return (R::getCell("SELECT sum(cal*amount) FROM user_meal JOIN food ON user_meal.id = food.id WHERE user_id = $user_id AND day_part = '$day_part' AND time = '$current_date'")) / 100;

    }

}