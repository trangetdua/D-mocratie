<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="./css/stylers.css">
</head>
<body>
    <header class="main">
        <nav class="navbar">
            <div class="icon">
                <img src="images/logo.png" alt="Logo" class="logo">
            </div>
            <div class="menu">
                <ul>
                    <li><a href="./index.html">HOME</a></li>
                    <li><a id="aide">AIDE</a></li>
                    <li><a id="about">A PROPOS</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="content-wrapper">
            <div class="content-left">
                <h1>YOUR VOTE <br><span class="content-span">OUR FUTURE</span></h1>
            </div>
            <div class="content-right">
                <h2 class="form-title">INSCRIPTION</h2>

                <?php if (isset($_GET['error']) && $_GET['error'] === "email_exists"): ?>
                    <p style="color: red;">Email déjà utilisé. Veuillez utiliser un autre email.</p>
                <?php endif; ?>

                <form class="reservation-form" action="../modele/inscription.php" method="post">
                    <div class="form-group">

                        <div class="form-group row">
                            <div class="form-item">
                                <label for="nom">Nom :</label>
                                <input type="text" id="nom" name="Nom_Utilisateur" placeholder="Votre nom" required>
                            </div>

                            <div class="form-item">
                                <label for="prenom">Prénom :</label>
                                <input type="text" id="prenom" name="Prenom_Utilisateur" placeholder="Votre prénom" required>
                            </div>
                        </div>

                        
                        <label for="adresse">Adresse :</label>
                        <input type="text" id="adresse" name="Adr_Utilisateur" placeholder="Votre adresse" required>

                        <label for="code-postal">Code postal :</label>
                        <input type="text" id="code-postal" name="Cp_Utilisateur" placeholder="Votre code postal" required pattern="^[0-9]{5}$" title="Le code postal doit contenir exactement 5 chiffres.">

                        <label for="email">Adresse email :</label>
                        <input type="email" id="email" name="Mail_Utilisateur" placeholder="Votre email" required>

                        <label for="login">Password :</label>
                        <input type="password" id="login" name="Login_Utilisateur" placeholder="Votre mot de passe" required>

                    </div>
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        </div>
    </section>

    <script src="./js/validation.js"></script>


</body>
</html>
