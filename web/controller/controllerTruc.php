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
                return $this->jsonResponse(["error" => "ID non providé"], 400); //Best-practices with correct use of status codes
            }
            $model = $this->modelClass;
            $obj = $model::getObjetById($_GET['id']);
            if (!empty($obj)) {
                $obj = $obj[0];
                return $this->jsonResponse($obj);
            } else {
                return $this->jsonResponse(["error" => "Pas trouvé"], 404); //Bad request from client
            }
        } else {
            return $this->jsonResponse(["error" => "Méthode non autorisé"], 500);
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $model = $this->modelClass;
            $data = json_decode(file_get_contents('php://input'), true);
            $newId = $model::create($data); 

            if($newID) {
                return $this->jsonResponse(["message" => "Utilisateur ajouté avec succès" ], 201);
            } else {
                return $this->jsonResponse(["error" => "Impossible de créer un nouvel utilisateur"],400 );
            }
        } else {
            return $this->jsonResponse(["error" => "Méthode non autorisé"], 500);
        }
    }

    public function update() {
        if (!isset(($_GET['id']))) {
            return $this->jsonResponse(["error" => "ID non providé"], 400); //Best-practices with correct use of status codes
        }
        $id = $_GET['id'];
        $model = $this->modelClass;

        if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputData = $_SERVER['REQUEST_METHOD'] 
        }
    }
}
?>