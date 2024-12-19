<?php
require_once("../modele");

abstract class ControllerTruc {
    protected $modelClass; 
    protected $id;

    public function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header("Content-Type:application/json, charset=utf-8");
        echo json_encode($data);
        exit;
    }
    
    //Pour lister all records
    public function list() {
        $model = $this->modelClass;
        $objects = $model::getAll();
        return $this->jsonResponse($objects);
    }

    public function detail() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!isset(($_GET['id']))) {
                echo "No ID provided";
                return;
            }
            $model = $this->modelClass;
            $obj = $model::getObjetById($_GET['id']);
            if (!empty($obj)) $obj = $obj[0];

            return $this->jsonResponse($obj); 
        }

    }

    public function create() {

    }
}
?>