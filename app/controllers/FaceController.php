<?php

namespace app\controllers;

class FaceController extends AppController
{
    public function indexAction()
    {
    }

    public function testAction()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!empty($data)) {
            $result = file_put_contents("file.txt", $json);
            if ($result === false) {
                echo "Error writing to file";
            } else {
                echo "Data written to file";
            }
        } else {
            echo "No data received";
        }
        redirect();
    }
}
