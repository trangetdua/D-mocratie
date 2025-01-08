	<?php 
	require_once("../vue/header.php");

	if (!isset($_SESSION['fullname'])) {
		header("Location: ../vue/connection.php?error=notlogged");
		exit;
	}

	$fullname = $_SESSION['fullname'];


			$id =$_POST['choix'];
			$user = $_SESSION['user_number'];
			$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/choisi/$user/$id/?method=POST";
			
			$curl = curl_init($url);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			$response = curl_exec($curl);
			$id = $_SESSION['proposition'];
			$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/vote_pour/$user/$id/?method=POST";
			
			$curl = curl_init($url);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
			$response = curl_exec($curl);
        if ($response === false) {
            throw new Exception("Erreur lors de l'envoi des données: " . curl_error($curl));
        }
			header('Location:../vue/vote.php');

	require_once("../vue/footer.html");

	?>
	
