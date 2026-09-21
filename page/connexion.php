<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Barber & Coiffeuse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="../css/connexion.css">
</head>
<body>
    <section>
        <div class="container">
            <h1>Connexion</h1>
            <form action="../logique/connexion.php" method="POST">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" placeholder="moukaila" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>
                <div class="inscri">
                <button type="submit"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
                </div>
                <span>vous n'avez pas de compte? <a href="inscription.php">inscrivez-vous</a></span>
            </form>
        </div>
    </section>
</body>
</html>