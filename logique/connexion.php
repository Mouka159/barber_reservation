<?php
require_once  "../admis/db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

  //verification de l'utilisateur
    $sql = "SELECT * FROM utilisateurs WHERE email_user = ?";
    $smt = $pdo->prepare($sql);
    $smt->execute([$email_user]);
    $user = $smt->fetch();

    if ($user) {
        // Vérification du mot de passe haché
        if (password_verify($password, $user['mot_de_passe'])) {
             // Création de la session
             $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];
            header('Location: ../page/acceuil.php');
            exit();
        } else {
            $message = "Mot de passe incorrect";
        }
    } else {
        $message = "Utilisateur non trouvé";
    }
}
?>
