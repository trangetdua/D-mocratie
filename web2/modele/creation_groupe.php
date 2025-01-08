<?php
require_once("header.php"); //creer_groupe

try{


    $nom = $_POST['nom'];
    $couleur = $_POST['couleur'];
	
	
	$createur = intval($_SESSION['user_number']);
	
		$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/groupe/?method=POST";
        $data = [
            'Nom_Groupe' => $nom,
            'Couleur_groupe' => $couleur,
            'Id_Utilisateur' => $createur,
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
		$_SESSION['groupe'] = $id;

	//on rajoute le groupe dans groupe, le role de l'utilisateur dans role_groupe et le membre a la liste des mmebres et les themes 
		$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/membre/$createur/$id/0/?method=POST";
		$curl = curl_init($url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		curl_exec($curl);
		
		$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/role_groupe/$id/1/$createur/?method=POST";
		$curl = curl_init($url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		curl_exec($curl);
		echo $_POST['Theme1'];
		if(isset($_POST['Theme1'])){
			$theme1 = $_POST['Theme1'];
			$url ="https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/Thème/?method=POST";
			$data = [
            'Nom_Theme' => $theme1,
            'Id_Groupe' => $id,
			];

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

		}
		

		if(isset($_POST['Theme2'])){
			$theme2 = $_POST['Theme2'];
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


		$_SESSION['role'] = "administrateur";
		header('Location: acceuil_groupe.php');

} catch (Exception $e) {
    echo $e->getMessage();
}

?>
