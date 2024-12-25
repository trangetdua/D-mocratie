<?php
require_once ('./config/connexion.php'); 
require_once ('./controller/controllerUtilisateur.php');

//Appeler: .../index.php?action=index/show/create/....

$controleur = new utilisateurControleur();

// Récupérer request
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? null;

switch ($action) {
    case 'index':
        if ($method == 'GET') {
            //$controleur->index(); //Lister les utilisateurs (au cas où)
            $listeUtilisateurs = Utilisateur::getAll(); 
            require __DIR__ . '/vue/liste.php';
        }
        break;
    case 'show':
        if ($method == 'GET') {
            $controleur->show();   // GET /utilisateurs/show?id=xyz
        }
        break;
    case 'create':
        if ($method == 'POST') {
            $controleur->create();
        }
        break;
    case 'update':
        if ($method == 'PUT') {
            $controleur->update();
        }
        break;
    case 'delete':
        if ($method == 'DELETE') {
            $controleur->delete();
        }
        break;
    default:
        echo "Aucune action correspondante.";
}
