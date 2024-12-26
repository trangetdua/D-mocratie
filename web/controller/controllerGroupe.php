<?php
class GroupController {
    public function createGroup() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            echo "Please login first";
            return;
        }
        $idUser = $_SESSION['id_user'];

        // Lấy data form/JSON
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        // data gồm: "Nom_Groupe", "Themes_Groupe", "Image_Groupe", "Couleur_Groupe"...
        // Thêm "Createur_Id"
        $data['Createur_Id'] = $idUser;

        $newId = Groupe::create($data);
        if ($newId) {
            // Ghi vào group_members: role=admin
            GroupMemberRepository::addMember($newId, $idUser, 'admin');
            echo "Groupe créé, ID=$newId";
        } else {
            echo "Erreur creation groupe";
        }
    }

    public function listGroupsForUser() {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            echo "Please login";
            return;
        }
        $idUser = $_SESSION['id_user'];
        $groupes = GroupMemberRepository::getGroupsOfUser($idUser);
        echo json_encode($groupes);
    }
}

?>