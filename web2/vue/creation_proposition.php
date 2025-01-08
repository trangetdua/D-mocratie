<?php
require_once("header.php");

try{


    $nom = $_POST['nom'];
    $contenue = $_POST['contenue'];
	$createur = intval($_SESSION['user_number']);
	
		$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Proposition/?method=POST";
		
        $data = [
            'Titre_Proposition' => $nom,
            'Description_Proposition' => $contenue,
            'Id_Utilisateur' => $createur,
			'Id_Groupe' => $_SESSION['groupe'],
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

		$id = $response['id'];
		$_SESSION['proposition']=$id;

	

		if(isset($_POST['Theme'])){
			$theme2 = $_POST['Theme'];
						$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Thème/?method=POST";
			$data = [
            'Nom_Theme' => $theme2,
            'Id_Groupe' => $id,
			];

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));



		}
		
		header('Location: proposition.php');

} catch (Exception $e) {
    echo $e->getMessage();
}

?>
