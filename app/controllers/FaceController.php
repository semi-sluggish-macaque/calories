<?php

namespace app\controllers;

use app\models\Face;
use MongoDB\BSON\ObjectId;
use RedBeanPHP\R;

//use app\models\Main;

/** @property Face $model */
class FaceController extends AppController

{
    function indexAction()
    {
        $this->layout = 'app';
        $current_time = date('H');
        if ($current_time >= 4 && $current_time <= 12) {
            $day_part = 'breakfast';
        }
        if ($current_time >= 13 && $current_time <= 17) {
            $day_part = 'dinner';
        }
        if ($current_time >= 18) {
            $day_part = 'lunch';
        }
        $current_date = date('Y-m-d');

        $data = $this->model->get_user_food($_SESSION['user']['id'][0], $day_part, $current_date);
        $totalCalories = $this->model->calculate_total_calories($_SESSION['user']['id'][0], $day_part, $current_date);
        $this->set(compact('data', 'totalCalories'));
    }

    public function getdataAction()
    {
        $data = $this->model->get_popular_food();
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
        $current_time = date('H');
        if ($current_time >= 4 && $current_time <= 12) {
            $day_part = 'breakfast';
        }
        if ($current_time >= 13 && $current_time <= 17) {
            $day_part = 'dinner';
        }
        if ($current_time >= 18) {
            $day_part = 'lunch';
        }
        $user_id = $_SESSION['user']['id'][0];

        $current_date = date('Y-m-d');

        $this->model->add_user_food($user_id, $day_part, $time, $amount, $id);

        $totalCalories = $this->model->calculate_total_calories($user_id, $day_part, $current_date);

        $response = "succes";
        echo json_encode( $totalCalories);
        die;
    }
}
