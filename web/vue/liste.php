<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Utilisateurs</title>
</head>
<body>
    <h1>Liste des Utilisateurs</h1>
    
    <?php if (!empty($listeUtilisateurs)): ?>
        <table bord>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Login</th>
            </tr>
            <?php foreach ($listeUtilisateurs as $u): ?>
                <tr>
                    <!-- Sử dụng getter hoặc thuộc tính trực tiếp -->
                    <td><?php echo $u->get('Id_Utilisateur'); ?></td>
                    <td><?php echo $u->get('Nom_Utilisateur'); ?></td>
                    <td><?php echo $u->get('Prenom_Utilisateur'); ?></td>
                    <td><?php echo $u->get('Mail_Utilisateur'); ?></td>
                    <td><?php echo $u->get('Login_Utilisateur'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun utilisateur trouvé</p>
    <?php endif; ?>

    <?php /* Pour format Json
    /public function index() {
            $listeUtilisateurs = Utilisateur::getAll(); 
            header("Content-Type: application/json");
            echo json_encode($listeUtilisateurs);
        }

     */?>
</body>
</html>


