<?php
require_once ('../config/connexion.php'); 


    // Mettre en attribut ce qu'il y a en dessous
header("Content-Type:application/json"); // le format du corps de la requete est JSON
$pdo = Connexion::getConnection();
//$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'], '/'));
$method = $_GET['method'];

if (!is_null($path[0])){
	$table=$path[0];
    try {

        if ($method == 'GET') {
			//format de la requete: $table/$connection/$table2

			$requete = "select * from $table";
			$i=0;
			$j=0;
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
		
			if($path[1]=='id'){
				$requete = 'insert into '.$table .' values (DEFAULT,';
				$i=1;
			}
			else{
				$requete = 'insert into '.$table .' values (';
				$i=0;
			}
			$execute = array();

			while(isset($path[$i+1])){
				$i=$i+1;
				if($path[$i]!='null'){
				$requete = $requete . ':' .'nom'.strval($i);
				
				$var = 'nom'.strval($i);
				$execute[$var] = $path[$i];
				}
				else{
					$requete =$requete . 'null';
				}
				if (isset($path[$i+1])){
					$requete = $requete . ', ';
				}
			}
			$requete = $requete . ');';
			$stmt = $pdo->prepare($requete);
            $stmt->execute($execute);
			$stmt = $pdo->query("SELECT LAST_INSERT_ID()");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($result);   
            //break;
            
        } elseif ($method == 'PUT') {
			$requete = 'update '. $table . ' set';
			if(isset($path[2])){
				$i=2;
				$execute = array();

				while(isset($path[$i+2])){
					$j=$i+1;
					$i=$i+2;
					$requete = $requete . " ". $path[$j] . ' = ' . ' :nom' .strval($i);
					$var = 'nom'.strval($i);
					$execute[$var] = $path[$i];



					if (isset($path[$i+2])){
						$requete = $requete . ', ';
					}
				}
				$requete = $requete . " Where " . ':nom1' . " = ". ':nom2' . ";";
				$execute[':nom1']=$path[1];
				$execute[':nom2']=$path[2];

				$stmt = $pdo->prepare($requete);
				$stmt->execute($execute);



                http_response_code(201); // Code status : POST/PUT succeeded
                echo json_encode(['message' => 'Utilisateur mis à jour avec succès']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Veuillez rensigner la condition']);
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
            //http_response_code(500); //Method not allowed
            echo json_encode(['message' => 'Méthode non autorise']);
            echo $e->getMessage();

        }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint non trouve']);
}


?>