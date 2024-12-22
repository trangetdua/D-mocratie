<?php
require_once ('../config/connexion.php'); 
require_once ('../modele/modele.php');




    // Mettre en attribut ce qu'il y a en dessous
header("Content-Type:application/json"); // le format du corps de la requete est JSON
$pdo = Connexion::getConnection();
$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'], '/'));

if (!is_null($path[0])){
	$table=$path[0];
    try {
        if ($method == 'GET') {
			$requete = "select * from $table";
			$i=0;
			$j=0;
			//format : $table/$connection/$table2
			while(isset($path[$i+2])){
				$j=$i+1;
				$k=$i;
				$i=$i+2;
				$requete = $requete . " inner join $path[$i] on $path[$i].$path[$j] = $path[$k].$path[$j]";
				
			}
			$requete = $requete . ";";
            $stmt = $pdo->query($requete);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);   
            
    
        } elseif($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('insert into utilisateur (nom_utilisateur, prenom_utilisateur, adr_utilisateur, cp_utilisateur, mail_utilisateur, login_utilisateur, pdp_utilisateur 
                                values (:nom, :prenom, :adr, :cp, :mail, :login, :pdp) ');
            $stmt->execute([
                ':id' => $data['id_utilisateur'],
                ':nom' => $data['nom_utilisateur'],
                ':prenom' => $data['prenom_utilisateur'],
                ':adr' => $data['adr_utilisateur'],
                ':cp' => $data['cp_utilisateur'],
                ':mail' => $data['mail_utilisateur'],
                ':login' => $data['login_utilisateur'],
                ':pdp' => $data['pdp_utilisateur'],
            ]);
            http_response_code(201); // It means the request succeeded, a new resource was created as a result 
            echo json_encode(['message' => 'Utilisateur ajouté avec succès']);
            //break;
            
        } elseif ($method == 'PUT') {
            if(isset($path[1])) {
                $id = intval($path[1]);
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare('update utilisateurs set nom_utilisateur = :nom, prenom_utilisateur = :prenom, adr_utilisateur = :adr, cp_utilisateur = :cp, 
                                        mail_utilisateur = :mail, login_utilisateur = :login, pdp_utilisateur = :pdp
                                        where id_utilisateur = :id');
                $stmt->execute([
                    ':nom' => $data['nom_utilisateur'],
                    ':prenom' => $data['prenom_utilisateur'],
                    ':adr' => $data['adr_utilisateur'],
                    ':cp' => $data['cp_utilisateur'],
                    ':mail' => $data['mail_utilisateur'],
                    ':login' => $data['login_utilisateur'],
                    ':pdp' => $data['pdp_utilisateur'],
                    ':id' => $id,
                ]);
                http_response_code(201); // Code status : POST/PUT succeeded
                echo json_encode(['message' => 'Utilisateur mis à jour avec succès']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'ID user demandé']);
            }
            //break;
    
    
        } elseif ($method == 'DELETE') {
            if(isset($path[1])) {
                $id = intval($path[1]);
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare('delete from utilisateurs where id_utilisateur = :id');
                $stmt->execute(['id' => $id]);
                http_response_code(201);
                echo json_encode(['message' => 'Utilisateur supprime']);
            } else {
                http_response_code(400); // Bad request : ID User false
                echo json_encode(['message' => 'ID User demandé']);
            } 
            //break;

        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Méthode pas autorise']);
        }
        
        
        } catch (Exception $e) {
            http_response_code(500); //Method not allowed
            echo json_encode(['message' => 'Méthode non autorise']);
            echo $e->getMessage();

        }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint non trouve']);
}


?>