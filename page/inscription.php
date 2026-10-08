<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription-barber & coiffeuse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="../css/inscription.css">
</head>
<body>
    <section>
        <div class="container">
            <h1>Inscription</h1>
            <form action="../logique/inscription.php" method="post">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" placeholder="moukaila" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="moukaila@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" placeholder="71769907" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="mdp" placeholder="********" required>
                </div>
                <button type="submit" name="envoyer"> <i class="fas fa-user-plus"></i> S'inscrire</button>
            </form>
            <div class="inscri">
                <span>vous avez deja un compte? <a href="connexion.php">connectez-vous</a></span>
             </div>
        </div>
       
    </section>

</body>
</html>