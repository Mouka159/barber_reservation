<?php

require_once  "../admis/db.php";

if (isset($_POST['envoyer'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
     $password = $_POST['mdp'];

    // Vérifier si l'email existe déjà
    $sql = "SELECT * FROM utilisateurs WHERE email_user = ?";
    $smt = $pdo->prepare($sql);
    $smt->execute([$email]);
    $user = $smt->fetch();

    if ($user) {
        $message = "Email existe déjà";
    } else {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertion des données
      $sql = "INSERT INTO utilisateurs (nom_user, email_user,telephone, mot_de_passe) VALUES (:nom, :email,:telephone, :mot_de_passe)";
     $smt = $pdo->prepare($sql);
  $smt->execute([
    'nom_user' => $username,
    'email_user' => $email,
    'telephone' => $telephone,
    'mot_de_passe' => $hashedPassword
]);
        $message = "Inscription réussie";
        // Redirection vers la page de connexion
        header("Location: ../page/connexion.php?email=" . urlencode($email));
        exit();
    }
}
?>
