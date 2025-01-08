	<?php 
	require_once("header.php");

	if (!isset($_SESSION['fullname'])) {
		header("Location: connection.php?error=notlogged");
		exit;
	}

	$fullname = $_SESSION['fullname'];


			 $id =$_SESSION['vote'];

			for($i=0;$i<count($_POST);$i++){
				$name = "choix".$i.'_';
				$url = "https://projets.iut-orsay.fr/saes3-aviau/TestProket/web2/controller/api.php/Choix/?method=POST";
			$data = [
            'Nom_Choix' =>$_POST[$name],
			'Id_Vote'=>$id,
			];
			
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception("Erreur lors de l'envoi des données: " . curl_error($curl));
        }

			
			
        }

				header('Location:vote.php');

	require_once("footer.html");

	?>
	
