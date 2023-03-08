<?php

namespace app\controllers;

use app\models\Face;
use RedBeanPHP\R;


/** @property Face $model */
class FaceController extends AppController

{
    function indexAction()
    {
        $this->layout = 'app';
    }

    public function renderAction()
    {
        $json = file_get_contents('php://input');
        $recieved_data = json_decode($json, true);
        $totalCalories = $this->model->calculate_total_calories($_SESSION['user']['id'][0], $recieved_data['dayPart'], $recieved_data['date']);
        $products = $this->model->get_user_food($_SESSION['user']['id'][0], $recieved_data['dayPart'], $recieved_data['date']);
        $data = [
            'products' => $products,
            'totalCalories' => $totalCalories,
        ];
        echo json_encode($data);
        die;

    }

    public function getdataAction()
    {
        $json = file_get_contents('php://input');
        $reciedved_data = json_decode($json, true);
        $data = $this->model->get_popular_food($reciedved_data['dayPart'], $reciedved_data['date'], $_SESSION['user']['id'][0]);
//        $data = $this->model->get_popular_food('lunch', "2023-03-07");
//        $json_data = json_encode($data);
        $json_data = json_encode($data);
//        header('Content-Type: application/json');
        echo $json_data;
        die;
    }

    public function addProductAction()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $id = $data['id'];
        $amount = $data['quantity'];
        $user_id = $_SESSION['user']['id'][0];
        $current_date = $data['currentDate'];
        $day_part = $data['day_part'];
        $this->model->add_user_food($user_id, $day_part, $current_date, $amount, $id);
        $totalCalories = $this->model->calculate_total_calories($user_id, $day_part, $current_date);
        echo json_encode($totalCalories);
        die;
    }

    public function deleteAction()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $user_id = $_SESSION['user']['id'][0];
        $current_date = $data['currentDate'];
        $day_part = $data['dayPart'];
        $id = $data['id'];
        $this->model->delete_user_food($user_id, $day_part, $current_date, $id);
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
