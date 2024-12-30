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
            
    
        } elseif ($method == 'POST') {

            /***************************************************************
             * Essayer de lire les données Json 
             ***************************************************************/

            $jsonBody = file_get_contents('php://input');
            $postData = json_decode($jsonBody, true);

            if (json_last_error() === JSON_ERROR_NONE && !empty($postData)) {
                // Récupérer les colonnes
                $columns = array_keys($postData);
                // Créer les placeholder :key
                $placeholders = array_map(fn($col) => ':' . $col, $columns);

                // Créer les requetes pour appliquer dans diffférentes tables
                // VD: INSERT INTO utilisateur (col1, col2) VALUES (:col1, :col2)
                $sql = sprintf(
                    'INSERT INTO %s (%s) VALUES (%s)',
                    $table,
                    implode(', ', $columns),
                    implode(', ', $placeholders)
                );

                // Préparer bind array
                $bindParams = [];
                foreach ($postData as $col => $val) {
                    $bindParams[':'.$col] = $val;
                }

                $stmt = $pdo->prepare($sql);
                $stmt->execute($bindParams);

                // Récupérer ID vient d'être insert
                $id = $pdo->lastInsertId();
                echo json_encode(['id' => $id]);

            } else {
                /**
                 * /***************************************************************
					* Lire les données à travers Json (Ambre)
					***************************************************************
                 * JSON n'est pas correct => lire data depuis $path.
                 */
                if (isset($path[1]) && $path[1] == 'id') {
                    $requete = 'INSERT INTO '.$table.' VALUES (DEFAULT,';
                    $i = 1;
                } else {
                    $requete = 'INSERT INTO '.$table.' VALUES (';
                    $i = 0;
                }

                $execute = array();
                while (isset($path[$i+1])) {
                    $i++;
                    if ($path[$i] != 'null') {
                        $requete .= ':' . 'nom' . strval($i);
                        $var = 'nom' . strval($i);
                        $execute[$var] = $path[$i];
                    } else {
                        $requete .= 'null';
                    }
                    if (isset($path[$i+1])) {
                        $requete .= ', ';
                    }
                }
                $requete .= ');';
                
                $stmt = $pdo->prepare($requete);
                $stmt->execute($execute);

                $stmt = $pdo->query("SELECT LAST_INSERT_ID()");
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
            }

        }  elseif ($method == 'PUT') {
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
            try {
                
                $primaryKey = isset($_GET['key']) ? htmlspecialchars($_GET['key']) : 'Id_Utilisateur';
                $primaryValue = isset($_GET['value']) ? htmlspecialchars($_GET['value']) : null;

                if (empty($primaryValue)) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Valeur de clé primaire manquante']);
                    exit;
                }
                
                    try {
                        $sql = "DELETE FROM $table WHERE $primaryKey = :primaryValue";
                        $stmt = $pdo->prepare($sql);
                
                        $params = [':primaryValue' => $primaryValue];
                        echo "<p>SQL Query: " . htmlspecialchars($sql) . "</p>";
                        echo "<p>Bind Parameters: " . htmlspecialchars(print_r($params, true)) . "</p>";
                        
                        $stmt->bindParam(':primaryValue', $primaryValue, PDO::PARAM_INT); // Sử dụng PARAM_STR nếu là email, PARAM_INT nếu là ID
                
                        $stmt->execute();
                
                        if ($stmt->rowCount() > 0) {
                            http_response_code(200);
                            echo json_encode(['message' => 'Enregistrement supprimé avec succès']);
                        } else {
                            http_response_code(404);
                            echo json_encode(['message' => 'Aucun enregistrement trouvé pour suppression']);
                        }
                    } catch (PDOException $pdoEx) {
                        http_response_code(500);
                        echo json_encode([
                            'message' => 'Erreur lors de la suppression - Problème base de données',
                            'error' => $pdoEx->getMessage()
                        ]);
                    }
                
            }catch (Exception $ex) {
                http_response_code(500);
                echo json_encode([
                    'message' => 'Erreur générale lors de la suppression',
                    'error' => $ex->getMessage()
                ]);
            }

        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Méthode pas autorise']);
        }
        
        
        }catch (Exception $e){
            //http_response_code(500); //Method not allowed
            echo json_encode(['message' => 'Méthode non autorise']);
            echo $e->getMessage();

        }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint non trouve']);
}


?>