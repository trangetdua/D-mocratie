<?php
require_once("header.php");

try{

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $commentaire = $_POST['commentaire'];
	
	
	$createur = intval($_SESSION['user_number']);
	$proposition = intval($_SESSION['proposition']);
	
		$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/commentaire/?method=POST";
        $data = [
            'Contenue_Commentaire' => $commentaire,
			'Signaler' => 0,
			'id_proposition' => $proposition,
            'Id_Utilisateur' => $createur
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $response = json_decode(curl_exec($curl), true);

        if ($response === false) {
            throw new Exception("Erreur lors de l'envoi des données: " . curl_error($curl));
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Erreur de décode JSON: " . json_last_error_msg());
        }
		

	


		header('Location: propositionCommentaire.php');
}
} catch (Exception $e) {
    echo $e->getMessage();
}

?>
