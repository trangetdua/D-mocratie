<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="./css/style.css">
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
                <h2 class="form-title">REGISTER</h2>

                <?php if (isset($_GET['error']) && $_GET['error'] === "email_exists"): ?>
                    <p style="color: red;">Email déjà utilisé. Veuillez utiliser un autre email.</p>
                <?php endif; ?>

                <form class="reservation-form" action="register.php" method="post">
                    <div class="form-group">
                        <label for="email">Adresse email :</label>
                        <input type="email" id="email" name="email" placeholder="Votre email" required>
                        
                        <label for="password">Password :</label>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
                        
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="name" placeholder="Votre nom" required>
                    </div>
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
