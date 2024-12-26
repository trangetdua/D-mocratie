<?php

require_once ('./modele/utilisateur.php');

class utilisateurControleur {


        /*
    ========================== FONCTIONNALITE WEB ================================
    */

    //Afficher la formulaire de connexion 
    public function registerForm() {
        require __DIR__ . '/../vue/user/login.php'; // A modifier la page de connexion
    }

    //Traitement du s'inscrire (nouveau compte)
    public function register() {
        // Récupérer les données 
        $data = json_decode(file_get_contents('php://input'), true) 
                 ?? $_POST; 

        // Encrypter le mot de pase
        $data['Password_Utilisateur'] = password_hash($data['Password_Utilisateur'], PASSWORD_BCRYPT);
        
        $newId = Utilisateur::create($data);
        if ($newId) {
            echo json_encode(["message" => "User créé", "id"=>$newId]);
        } else {
            echo json_encode(["error"=> "Erreur création"]);
        }
    }

    //Traitement du login (avoir déjà un compte)
    public function login() {
        // Récupérer email + password
        $mail = $_POST['Mail_Utilisateur'] ?? '';
        $pass = $_POST['Password_Utilisateur'] ?? '';
        
        // Chercher user selon mail
        $user = Utilisateur::getUserByEmail($mail); // A ajouter getUserByEmail(...) 
        
        //   (trong Utilisateur / repository)
        if ($user && password_verify($pass, $user->get('Password_Utilisateur'))) {
            // Lưu session
            session_start();
            $_SESSION['id_user'] = $user->get('Id_Utilisateur');
            // ...
            echo "Login success";
        } else {
            echo "Wrong email or pass";
        }
    }


    //Traitement de la suppression de compte
    public function deleteAccount() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            echo "Not logged in";
            return;
        }
        $idUser = $_SESSION['id_user'];
        $ok = Utilisateur::delete($idUser);
        if ($ok) {
            session_destroy();
            echo "Compte supprimé";
        } else {
            echo "Erreur suppression compte";
        }
    }

    /*
    ========================== REPONSE JSON ================================
    */
    
    // GET /utilisateurs : 
    public function index() {
        $users = Utilisateur::getAll();
        header("Content-Type: application/json");
        echo json_encode($users);
    }

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
