<?php

require_once ('./modele/utilisateur.php');

class utilisateurControleur {

    //Afficher la formulaire de connexion 
    public function registerForm() {
        require __DIR__ . '/../vue/user/register.php';
    }

    // GET /utilisateurs : 
    public function index() {
        $users = Utilisateur::getAll();
        header("Content-Type: application/json");
        echo json_encode($users);
    }


    /*
    ========================== REPONSE JSON ================================
    */

    // GET /utilisateurs/show?id=XYZ : 
    public function show() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $user = Utilisateur::getObjetById($id);
            header("Content-Type: application/json");
            echo json_encode($user);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Missing id"]);
        }
    }

    // POST /utilisateurs/create 
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            http_response_code(400);
            echo json_encode(["error" => "No data"]);
            return;
        }
        $newId = Utilisateur::create($data);
        if ($newId) {
            http_response_code(201);
            echo json_encode(["message" => "Utilisateur créé", "id" => $newId]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Erreur lors de la création"]);
        }
    }

    // PUT /utilisateurs/update?id=XYZ 
    public function update() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Missing id"]);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $ok = Utilisateur::update($id, $data);
        if ($ok) {
            echo json_encode(["message" => "Utilisateur mis à jour"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Erreur lors de la mise à jour"]);
        }
    }

    // DELETE /utilisateurs/delete?id=XYZ 
    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Missing id"]);
            return;
        }
        $ok = Utilisateur::delete($id);
        if ($ok) {
            echo json_encode(["message" => "Utilisateur supprimé"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Erreur lors de la suppression"]);
        }
    }
}
