<?php

namespace app\controllers;

use app\models\Face;
use RedBeanPHP\R;


/** @property Face $model */
class FaceController extends AppController

{
    function indexAction()
    {
//        $one_day_ago = date('Y-m-d', strtotime('-1 day'));
//        debug($one_day_ago, 1);
        $this->layout = 'app';
        $current_time = date('H');
        $day_part = self::day_part();
        $current_date = date('Y-m-d', strtotime('-1 day'));
        $data = $this->model->get_user_food($_SESSION['user']['id'][0], $day_part, $current_date);
        $totalCalories = $this->model->calculate_total_calories($_SESSION['user']['id'][0], $day_part, $current_date);
        $this->set(compact('data', 'totalCalories', 'day_part'));

    }

    public function getdataAction()
    {
        $time = date('Y-m-d');
        $day_part = self::day_part();
        $data = $this->model->get_popular_food($day_part, $time);
        $json_data = json_encode($data);
        header('Content-Type: application/json');
        echo $json_data;
        die;
    }

    public function addProductAction()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $id = $data['id'];
        $amount = $data['quantity'];
        $time = date('Y-m-d');
        $user_id = $_SESSION['user']['id'][0];
        $current_date = date('Y-m-d');
        $day_part = self::day_part();
        $this->model->add_user_food($user_id, $day_part, $time, $amount, $id);
        $totalCalories = $this->model->calculate_total_calories($user_id, $day_part, $current_date);
        echo json_encode($totalCalories);
        die;
    }

    public function deleteAction()
    {
        $json = file_get_contents('php://input');
        $id = json_decode($json, true);
        $time = date('Y-m-d');
        $user_id = $_SESSION['user']['id'][0];
        $current_date = date('Y-m-d');
        $day_part = self::day_part();
        $this->model->delete_user_food($user_id, $day_part, $time, $id);
        $totalCalories = $this->model->calculate_total_calories($user_id, $day_part, $current_date);

        echo json_encode($totalCalories);
        die;
    }

    public function editAction()
    {

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $id = $data['id'];
        $amount = $data['quantity'];
        $time = date('Y-m-d');
        $user_id = $_SESSION['user']['id'][0];
        $current_date = date('Y-m-d');
        $day_part = self::day_part();
        $this->model->update_user_food($user_id, $day_part, $time, $amount, $id);
        $totalCalories = $this->model->calculate_total_calories($user_id, $day_part, $current_date);
        echo json_encode($totalCalories);
        die;
    }

    static private function day_part()
    {
        $current_time = date('H');
        if ($current_time >= 4 && $current_time <= 12) {
            return $day_part = 'breakfast';
        }
        if ($current_time >= 13 && $current_time <= 17) {
            return $day_part = 'dinner';
        }
        if ($current_time >= 18) {
            return $day_part = 'lunch';
        }
    }
}
